@component('_partials.head')
@yield('title')
@endcomponent

<body class="min-h-full">
    <div class="page-container w-100 min-vh-100 flex flex-column m-0 dark:bg-gray-900 dark:text-white" id="app">
        @include('_partials.navbar')
        @yield('content')
    </div>
</body>

@component('_partials.foot')
@yield('script')
@endcomponent

