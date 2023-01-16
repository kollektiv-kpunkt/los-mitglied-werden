<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body {{$attributes}} style="--vh: 1vh">

    <nav class="fixed top-0 left-0 w-full z-50">
        <div class="los-app-container pt-4">
            <a href="/" class="flex items-center gap-x-6">
                <img src="{{asset('images/logo.svg')}}" alt="Logo">
                <div class="text-white">
                    <p class="font-bold text-2xl">{{__("claim.title")}}</p>
                    <p class="">{{__("claim.subtitle")}}</p>
                </div>
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

</body>
</html>
