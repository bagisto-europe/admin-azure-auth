<?php

namespace Bagisto\AzureAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Bagisto\AzureAuth\Helpers\AzureConfigHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Webkul\User\Repositories\AdminRepository;

class SessionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AdminRepository $adminRepository
    ) {}

    /**
     * Redirect the user to the Azure authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToAzure()
    {
        if (! AzureConfigHelper::isConfigured()) {
            return view('azure-auth::errors.config');
        }

        return Socialite::driver('azure')->redirect();
    }

    /**
     * Handle the callback from Azure.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleCallback()
    {
        try {
            if (! AzureConfigHelper::isConfigured()) {
                return view('azure-auth::errors.config');
            }

            $user = Socialite::driver('azure')->user();

            $localUser = $this->adminRepository->where('email', $user->getEmail())->first();

            if (! $localUser) {
                $randomPass = Str::password(80);

                $userData = [
                    'name'     => $user->getName(),
                    'email'    => $user->getEmail(),
                    'password' => bcrypt($randomPass),
                    'role_id'  => 1,
                    'status'   => true,
                ];

                $localUser = $this->adminRepository->create($userData);

                if ($localUser) {
                    Log::info('Local user created for ', ['user_email' => $user->getEmail()]);
                } else {
                    Log::error('Error creating local user');
                }
            }

            if (! $localUser || ! $localUser->status) {
                session()->flash('warning', trans('admin::app.settings.users.activate-warning'));

                auth()->guard('admin')->logout();

                return redirect()->route('admin.session.create');
            }

            auth()->guard('admin')->login($localUser);

            return redirect()->route('admin.dashboard.index');
        } catch (\Exception $e) {
            Log::error('Azure Authentication Error: '.$e->getMessage());

            return redirect()->route('admin.session.create')->with('warning', __('azure-auth::app.auth-error'));
        }
    }
}
