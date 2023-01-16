@php
    $config = json_decode(file_get_contents(resource_path('config/formconfig.json')));
@endphp
<x-app-layout
    :title="__('Jetzt Mitglied werden!')"
    :description="__('Jetzt Mitglied werden!')"
    :og="asset('images/og-image.png')"
    :canonical="env('APP_URL')"
>
@foreach ($config->steps as $key => $step)
<div class="los-memberform-step-container{{($loop->first) ? " active" : ""}}" data-step-key="{{$key}}">
    <div class="los-memberform-step-inner">
        @if(!$loop->first)
        <p class="text-white text-sm italic mb-4 los-memberform-back-button cursor-pointer"><i class="icofont-rounded-left mr-1"></i>Zurück</p>
        @endif
        <x-dynamic-component :component='"form.{$step->type}"' :step="$step" :key="$key" />
    </div>
</div>
@endforeach
</x-app-layout>
