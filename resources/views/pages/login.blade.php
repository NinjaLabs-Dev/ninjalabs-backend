@component('_partials.head')
    Login
@endcomponent

<body class="min-h-full dark:bg-gray-800">
<div class="page-container min-vh-100 row w-full mx-0" id="app">
    <div class="content-container col-md-12 flex justify-content-center">
        <div class="col-md-3 login-container flex flex-column items-center justify-content-center">
            <div class="login-card card flex flex-column align-items-center bg-gray-200 dark:bg-gray-600 w-100 shadow-sm">
                <div class="login-icon flex justify-center items-center -top-10 relative">
                    <div class="inner-container bg-gradient-to-tr from-red-700 to-pink-600 p-3 rounded shadow">
                        <svg width="32" height="32" class="text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                </div>

                <form action="{{ route('login') }}" method="POST" class="login-form w-100 px-10">
                    @csrf

                    <div class="flex -mx-3">
                        <div class="w-full px-3 mb-5">
                            <label for="" class="text-xs font-bold dark:text-white px-1">Username</label>
                            <div class="flex">
                                <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><span class="material-icons-outlined text-gray-400 text-lg">person</span></div>
                                <input type="text" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-pink-500 dark:bg-gray-700 dark:border-gray-800 dark:text-white transition"
                                       placeholder="John"
                                       autocomplete="username"
                                       name="username"
                                       id="username"
                                       required
                                >
                            </div>
                        </div>
                    </div>
                    <div class="flex -mx-3">
                        <div class="w-full px-3 mb-12">
                            <label for="" class="text-xs font-bold dark:text-white px-1">Password</label>
                            <div class="flex">
                                <div class="w-10 z-10 pl-1 text-center pointer-events-none flex items-center justify-center"><span class="material-icons-outlined text-gray-400 text-lg">lock</span></div>
                                <input type="password" class="w-full -ml-10 pl-10 pr-3 py-2 rounded-lg border-2 border-gray-200 outline-none focus:border-pink-500 dark:bg-gray-700 dark:border-gray-800 dark:text-white transition"
                                       placeholder="************"
                                       autocomplete="password"
                                       name="password"
                                       id="password"
                                       required
                                >
                            </div>
                        </div>
                    </div>
                    <div class="flex mx-3">
                        <div class="w-full px-3 mb-5">
                            <button class="block w-full max-w-xs mx-auto bg-pink-700 hover:bg-pink-800 focus:bg-pink-800 text-white rounded-lg px-3 py-3 font-semibold transition">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

@component('_partials.foot')
    @yield('script')
@endcomponent

