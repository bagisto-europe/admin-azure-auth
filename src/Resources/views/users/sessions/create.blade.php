<x-admin::layouts.anonymous>
    {{-- Page Title --}}
    <x-slot:title>
        @lang('admin::app.users.sessions.title')
    </x-slot:title>

    <div class="flex justify-center items-center h-[100vh]">
        <div class="flex flex-col gap-[20px] items-center">
            {{-- Logo --}}
            <img 
                class="w-max" 
                src="{{ bagisto_asset('images/logo.svg') }}" 
                alt="Bagisto Logo"
            >

            <div class="flex flex-col min-w-[300px] bg-white dark:bg-gray-900 rounded-[6px] box-shadow">
                {{-- Login Form --}}
                <x-admin::form :action="route('admin.session.store')">
                    <div class="p-[16px]  ">
                        <p class="text-[20px] text-gray-800 dark:text-white font-bold">
                            @lang('admin::app.users.sessions.title')
                        </p>
                    </div>

                    <div class="p-[16px] border-t-[1px] border-b-[1px] dark:border-gray-800">
                        <div class="mb-[10px]">
                            {{-- Email --}}
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.users.sessions.email')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    class="w-[254px] max-w-full" 
                                    rules="required|email" 
                                    :label="trans('admin::app.users.sessions.email')"
                                    :placeholder="trans('admin::app.users.sessions.email')"
                                    >
                                </x-admin::form.control-group.control>

                                <x-admin::form.control-group.error 
                                    control-name="email"
                                >
                                </x-admin::form.control-group.error>
                            </x-admin::form.control-group>
                        </div>

                        {{-- Password --}}
                        <div class="relative w-full">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('admin::app.users.sessions.password')
                                </x-admin::form.control-group.label>
                        
                                <x-admin::form.control-group.control 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    class="w-[254px] max-w-full ltr:pr-10 rtl:pl-10" 
                                    rules="required|min:6" 
                                    :label="trans('admin::app.users.sessions.password')"
                                    :placeholder="trans('admin::app.users.sessions.password')"
                                >
                                </x-admin::form.control-group.control>
                        
                                <span 
                                    class="icon-view text-[22px] cursor-pointer absolute top-[42px] transform -translate-y-1/2 ltr:right-2 rtl:left-2"
                                    onclick="switchVisibility()"
                                    id="visibilityIcon"
                                >
                                </span>
                        
                                <x-admin::form.control-group.error 
                                    control-name="password"
                                >
                                </x-admin::form.control-group.error>
                            </x-admin::form.control-group>
                        </div>
                    </div>
                    <div class="flex justify-between items-center p-[16px]">
                        {{-- Forgot Password Link --}}
                        <a 
                            class="text-[12px] text-blue-600 font-semibold leading-[24px] cursor-pointer"
                            href="{{ route('admin.forget_password.create') }}"
                        >
                            @lang('admin::app.users.sessions.forget-password-link')
                        </a>
                        <button
                            class="px-[14px] py-[6px] bg-blue-600 border border-blue-700 rounded-[6px] text-gray-50 font-semibold cursor-pointer">
                            @lang('admin::app.users.sessions.submit-btn')
                        </button>
                    </div>

                    @if(Route::has('azure.authenticate'))
                        <div class="flex items-center justify-center mt-4 mb-5">
                            <div class="border-b border-gray-300 dark:border-gray-700 w-full"></div>
                            <span class="mx-4 text-gray-500 dark:text-gray-400">{{ __('azure-auth::app.or') }}</span>
                            <div class="border-b border-gray-300 dark:border-gray-700 w-full"></div>
                        </div>
                        
                        <div class="flex items-center justify-center">
                            <a 
                                href="{{ route('azure.authenticate') }}"
                                class="inline-flex items-center mt-3 mb-4 px-[14px] py-[6px] bg-white border border-black-400 border-black rounded-[6px] text-gray-500 font-bold cursor-pointer shadow-sm hover:bg-gray-100 transition-all"
                            >
                            <img 
                                src="{{ asset('vendor/azure-auth/mssymbol.svg') }}"
                                alt="Microsoft Logo"
                                class="w-6 h-6 mr-2"
                            >
                            <span>{{ __('azure-auth::app.sign-in') }}</span>
                            </a>
                        </div>
                    @endif
                </x-admin::form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function switchVisibility() {
                let passwordField = document.getElementById("password");
                let visibilityIcon = document.getElementById("visibilityIcon");

                passwordField.type = passwordField.type === "password" ? "text" : "password";
                visibilityIcon.classList.toggle("icon-view-close");
            }
        </script>
    @endpush
</x-admin::layouts.anonymous>