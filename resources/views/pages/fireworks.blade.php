@component('_partials.head')
    TFM Fireworks 2021
@endcomponent

<body class="min-h-full dark:bg-gray-800" style="background: url('{{ asset('firework_background.png') }}') fixed no-repeat; background-size: cover;">
<div class="page-container min-vh-100 row w-full mx-0" id="app">
    <div class="content-container col-md-12 flex justify-content-center">
        <div class="col-md-7 login-container flex flex-column items-center justify-content-center">
            <video src="https://ninjalabs-cdn.s3.fr-par.scw.cloud/tfm_newyear_show_FINAL.mp4" controls class="border-8 border-black"></video>
        </div>
    </div>
</div>
</body>

@component('_partials.foot')
    @yield('script')
@endcomponent
