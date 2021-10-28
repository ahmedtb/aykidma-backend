<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">اسم الشركة</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="بحث" aria-label="بحث">
        <button class='fl-1'>تسجيل الخروج</button>
    </header>

    <div class="container-fluid">
        <div id='dashboard'></div>

        {{-- <div class="bg-gray col-10">

                <div class="row">
                    @foreach ($services as $service)
                        @include('components.serviceApproveal')
                    @endforeach
                </div>

            </div> --}}

    </div>
</body>

</html>
