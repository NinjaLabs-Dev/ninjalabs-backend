<div class="navbar flex items-center justify-content-between bg-white dark:bg-gray-800">
    <div class="branding mx-4 text-uppercase dark:text-white font-medium">
        <h3>NinjaLabs Development</h3>
    </div>
    <div class="items flex justify-content-end align-items-center mx-4">
        <a href="{{ route('dashboard') }}" class="{{ Request::route()->getName() === 'dashboard' ? 'bg-gray-300' : '' }} px-3 mx-2 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-100 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline transition">
            Home
        </a>
        <a href="{{ route('custom.urls') }}" class="{{ Request::route()->getName() === 'custom.urls' ? 'bg-gray-300' : '' }}  px-3 mx-2 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-100 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline transition">
            Custom URLs
        </a>
{{--        <a href="{{ route('twitch') }}" class="{{ Request::route()->getName() === 'twitch' ? 'bg-gray-300' : '' }}  px-3 mx-2 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-100 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline transition">--}}
{{--            Twitch Users--}}
{{--        </a>--}}
        @can('sql backups')
            <a href="{{ route('backups') }}" class="{{ Request::route()->getName() === 'backups' ? 'bg-gray-300' : '' }}  px-3 mx-2 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-100 rounded-lg dark-mode:bg-gray-700 dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline transition">
                DB Backups
            </a>
        @endcan
    </div>
</div>
