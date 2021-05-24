<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TFM Stream</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
</head>
<body class="min-h-full bg-gray-100">
    <div class="page-container min-vh-100 flex flex-column m-0" id="app">
        <div class="container-fluid min-vh-100">
            <div class="row min-vh-100">
                <div class="col-lg-12 min-vh-100 p-0">
                    <stream-client></stream-client>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>
</html>
