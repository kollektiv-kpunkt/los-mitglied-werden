@php
    $locales = [
        "de",
        "en",
        "fr",
        "it"
    ];
    $currentLocale = App::getLocale();
    $otherLocales = array_filter($locales, function($locale) use ($currentLocale) {
        return $locale !== $currentLocale;
    });
@endphp


<div class="los-lang-switcher">
    <div class="los-lang-current fixed bottom-4 left-4 h-8 w-14 bg-accent rounded-full text-white flex gap-x-1 justify-center items-center px-2 z-50 cursor-pointer">
        <i class="icofont-globe"></i>
        <span class="text-sm uppercase">{{$currentLocale}}</span>
    </div>
    @foreach ($otherLocales as $locale)
        <div class="los-lang-other fixed bottom-4 left-4 w-8 h-8 bg-white rounded-full text-accent flex gap-x-1 justify-center items-center px-2">
            <a href="/{{$locale}}">
                <span class="text-sm uppercase">{{$locale}}</span>
            </a>
        </div>
    @endforeach
</div>

<script>
    document.querySelector(".los-lang-current").addEventListener("click", function() {
        let otherLangs = document.querySelectorAll(".los-lang-other");

        for (let i = 0; i < otherLangs.length; i++) {
            setTimeout(function() {
                otherLangs[i].animate([
                    {transform: "translatex(0)"},
                    {transform: `translatex(calc(3.5rem + ${i * 2.25}rem + 0.25rem))`},
                ], {
                    duration: 250,
                    easing: "ease-in-out",
                    fill: "forwards"
                });
            }, i * 50);
        };
    });
</script>



