@php
    $config = json_decode(file_get_contents(resource_path('config/formconfig.json')));
@endphp
<x-app-layout
    :title="__('Jetzt Mitglied werden!')"
    :description="__('Jetzt Mitglied werden!')"
    :og="asset('images/og-image.png')"
    :canonical="env('APP_URL')"
>
    <div class="los-memberform-base" data-supporter-uuid={{$supporter->uuid}}>
        @foreach ($config->steps as $key => $step)
        <div class="los-memberform-step-container{{($loop->first) ? ' active' : ' future'}}" data-step-key="{{$key}}">
            <div class="los-memberform-step-inner">
                @if(!$loop->first)
                <button type='los-memberform' action="goto:BACK" class="text-white text-sm italic mb-4 los-memberform-back-button cursor-pointer"><i class="icofont-rounded-left mr-1"></i>Zurück</button>
                @endif
                <x-dynamic-component :component='"form.{$step->type}"' :step="$step" :key="$key" :supporter="$supporter"/>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
