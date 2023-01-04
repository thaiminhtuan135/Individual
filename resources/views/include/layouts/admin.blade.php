<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">--}}
    @if (isset($title))
        <title>{{ $title }}</title>
    @endif
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
          integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- CSS only -->
    {{--    <script src="{{ asset('js/adminApp.js') }}?t={{ time() }}" defer></script>--}}
    @yield('css')
    <script>
        window.Laravel = {!! json_encode(
            [
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/'),
                'STRIPE_PUBLISH_KEY' => env('STRIPE_PUBLISH_KEY'),
            ],
            JSON_UNESCAPED_UNICODE,
        ) !!};
    </script>
    @vite(['resources/sass/app.scss'])
</head>

<body>
@include('include.admin.sidebar')
<div id="app" class="home">
    <div class="body-mr text-color">
{{--        <loader></loader>--}}
        <custom-input></custom-input>
    </div>
    {{--    @include('include.admin.header')--}}
    {{--    <div class="bg-arc-sp"></div>--}}
    {{--            @vite('resources/js/coreui.bundle.min.js')--}}

    <div class="page-title-sp">
        @yield('title')
    </div>
    <!-- <div class="body-frame"></div> -->
    @yield('content')
    @if (session()->get('Message.flash'))
        <notyf :data="{{json_encode(session()->get('Message.flash')[0])}}"></notyf>
    @endif
    @php
        session()->forget('Message.flash');
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    @yield('javascript')
</div>
<script>
    const body = document.querySelector('body'),
        sidebar = body.querySelector('nav'),
        toggle = body.querySelector(".toggle"),
        searchBtn = body.querySelector(".search-box"),
        modeSwitch = body.querySelector(".toggle-switch"),
        modeText = body.querySelector(".mode-text");


    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    })

    searchBtn.addEventListener("click", () => {
        sidebar.classList.remove("close");
    })

    modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");

        if (body.classList.contains("dark")) {
            modeText.innerText = "Light mode";
        } else {
            modeText.innerText = "Dark mode";

        }
    });
</script>
</body>

</html>
