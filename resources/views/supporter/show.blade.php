@php
    $config = json_decode(file_get_contents(resource_path('config/formconfig.json')));
@endphp
<x-app-layout
    :title="__('Jetzt Mitglied werden!')"
    :description="__('Jetzt Mitglied werden!')"
    :og="asset('images/og-image.png')"
    :canonical="env('APP_URL')"
>
    <div class="los-memberform-base" data-supporter-uuid={{$supporter->uuid}} data-supporter-history={{$supporter->history ?? ""}}>
        @php
            if(isset($supporter->history)) {
                $history = json_decode($supporter->history, true);
                $activeStep = end($history);
                unset($history[array_key_last($history)]);
                $supporter->history = $history;
            } else {
                $activeStep = array_key_first((array)$config->steps);
                $supporter->history = [];
            }
        @endphp
        @foreach ($config->steps as $key => $step)
        @php
            if (in_array($key, $supporter->history)) {
                $statusClass = 'past';
            } else if ($key == $activeStep) {
                $statusClass = 'active';
            } else {
                $statusClass = 'future';
            }
        @endphp
        <div class="los-memberform-step-container {{$statusClass}}" data-step-key="{{$key}}">
            <div class="los-memberform-step-inner">
                @if(!$loop->first && ($loop->index !== count((array)$config->steps) - 1))
                <button type='los-memberform' action="goto:BACK" class="text-white text-sm italic mb-4 los-memberform-back-button cursor-pointer"><i class="icofont-rounded-left mr-1"></i>{{__("button.back")}}</button>
                @endif
                <x-dynamic-component :component='"form.{$step->type}"' :step="$step" :key="$key" :supporter="$supporter"/>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
