@php
    $config = json_decode(file_get_contents(resource_path('config/formconfig.json')));
@endphp
<x-app-layout
    :title="__('Jetzt Mitglied werden!')"
    :description="__('Jetzt Mitglied werden!')"
    :og="asset('images/og-image.png')"
    :canonical="env('APP_URL')"
>
@foreach ($config->steps as $step)
    <x-dynamic-component :component='"form.{$step->type}"' :step="$step"/>
@endforeach
</x-app-layout>
