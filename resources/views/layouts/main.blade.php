@component('_partials.head')
@yield('title')
@endcomponent

<body class="min-h-full bg-gray-100">
    <div class="row mr-0">
        <div class="col-xl-2">
            @include('_partials.navbar')
        </div>
        <div class="col-xl-10">
            <div class="page-container w-100 min-vh-100 flex flex-column m-0" id="app">
                @yield('content')
            </div>
        </div>
    </div>
</body>

@component('_partials.foot')
@yield('script')
@endcomponent

