<x-admin::layouts.anonymous>
    {{-- Page Title --}}
    <x-slot:title>
        {{ __('azure-auth::app.config-error.title') }}
    </x-slot>

    {{-- Error page Information --}}
    <div class="flex justify-center items-center h-[100vh] bg-white">
        <div class="flex items-center justify-center border rounded py-2 px-4">
            <!-- Error Message Div -->
            <div class="flex flex-col items-center text-center">
                <img src="{{ bagisto_asset('images/logo.svg') }}" class="mb-8" alt="Logo">

                <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
                    {{ __('azure-auth::app.config-error.title') }}
                </h2>

                <p class="text-gray-800 mb-3">
                    {{ __('azure-auth::app.config-error.message') }}
                </p>

                <p class="text-[14px] text-gray-800 mb-6">
                    @lang('azure-auth::app.config-error.support', [
                        'link'  => 'mailto:info@bagisto.eu',
                        'email' => 'info@bagisto.eu',
                        'class' => 'text-blue-600 font-semibold transition-all hover:underline',
                    ])
                </p>

                <a href="{{ route('admin.session.create') }}" class="primary-button">
                    {{ __('admin::app.errors.go-back') }}
                </a>
            </div>
    
            <!-- Image Div -->
            <div class="flex-shrink-0">
                <img src="{{ bagisto_asset('images/error.svg') }}" class="w-full" alt="Error Image">
            </div>
        </div>
    </div>
</x-admin::layouts.anonymous>
