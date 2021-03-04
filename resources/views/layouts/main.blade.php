@component('_partials.head')
@yield('title')
@endcomponent

<body class="min-h-full bg-gray-100">
    <div class="page-container w-100 min-vh-100 flex flex-column m-0" id="app">
        @include('_partials.navbar')
        @yield('content')
    </div>
</body>

@component('_partials.foot')
@yield('script')
@endcomponent

