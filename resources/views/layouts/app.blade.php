<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emenu</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/icons/logo.svg') }}?v={{ filemtime(public_path('assets/images/icons/logo.svg')) }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/icons/logo.svg') }}?v={{ filemtime(public_path('assets/images/icons/logo.svg')) }}">

    <link rel="stylesheet" href="{{ asset('assets/output.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @stack('style')
</head>

<body>
    <div id="Content-Container"
        class="relative flex flex-col w-full max-w-[640px] min-h-screen mx-auto overflow-x-hidden pb-32">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>

    @yield('script')
    @stack('script')
</body>

</html>
