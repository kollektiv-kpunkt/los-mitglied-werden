<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Primary Meta Tags -->
    <title>{{$title}}</title>
    <meta name="title" content="{{$title}}" />
    <meta name="description" content="{{$description}}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{request()->url()}}" />
    <meta property="og:title" content="{{$title}}" />
    <meta property="og:description" content="{{$description}}" />
    <meta property="og:image" content="{{env("APP_URL") . "/images/og/OG-" . App::getLocale() . ".jpg"}}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{request()->url()}}" />
    <meta property="twitter:title" content="{{$title}}" />
    <meta property="twitter:description" content="{{$description}}" />
    <meta property="twitter:image" content="{{env("APP_URL") . "/images/og/OG-" . App::getLocale() . ".jpg"}}" />

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#010e1f">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#010e1f">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    @vite(['resources/css/app.scss'])
</head>
<body {{$attributes}} style="--vh: 1vh">

    <nav class="fixed top-0 left-0 w-full z-50">
        <div class="los-app-container pt-4">
            <a href="/" class="flex items-center gap-x-6 w-fit los-app-logo">
                <img src="{{asset('images/logo.svg')}}" alt="Logo">
            </a>
        </div>
    </nav>
    <main class="los-app-container h-screen flex flex-col justify-center">
        <div class="los-memberform-outer">
            {{$slot}}
        </div>
    </main>

    <div class="los-app-bg">
        <div class="los-app-bg-blind"></div>
        <img src="{{asset("images/los-memberform-bg.jpg")}}" alt="Background Img">
    </div>
    <x-language-switcher />
    @vite(['resources/js/app.js'])
</body>
</html>
