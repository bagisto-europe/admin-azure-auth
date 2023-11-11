<?php

namespace Bagisto\AzureAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Bagisto\AzureAuth\Helpers\AzureConfigHelper;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
    ) {
    }

    /**
     * Redirect the user to the Azure authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToAzure()
    {
        if (!AzureConfigHelper::isConfigured()) {
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
            $user = Socialite::driver('azure')->user();

            $localUser = $this->adminRepository->where('email', $user->getEmail())->first();

            if (!$localUser) {
                $randomPass = Str::random(80);

                $userData = [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => bcrypt($randomPass),
                    'role_id' => 1,
                    'status' => true
                ];
                
                $adminUser = $this->adminRepository->create($userData);

                if ($adminUser) {
                    Log::info('Local user created for ', ['user_email' => $user->getEmail()]);
                }
            }

            auth()->guard('admin')->login($userData);

            if (! auth()->guard('admin')->user()->status) {
                session()->flash('warning', trans('admin::app.settings.users.activate-warning'));
    
                auth()->guard('admin')->logout();
    
                return redirect()->route('admin.session.create');
            }

            Log::info('Azure Authentication Successful', ['user_email' => $user->getEmail()]);

            return redirect()->route('admin.dashboard.index');
        } catch (\Exception $e) {
            Log::error('Azure Authentication Error: ' . $e->getMessage());

            return redirect()->route('admin.session.create')->with('warning', 'Unable to authenticate with your Microsoft account. Please try again.');
        }
    }

    /**
     * Show the error view for missing or invalid Azure configuration.
     *
     * @return \Illuminate\View\View
     */
    public function showConfigError()
    {
        return view('azure-auth::errors.config');
    }

}