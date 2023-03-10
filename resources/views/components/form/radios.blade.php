<div class="los-form-step">
    <h2 class="text-white text-5xl font-bold mb-10">{{__($step->title)}}</h2>
    <form action="/s/update" method="POST" class="flex flex-wrap gap-4 los-memberform-partial los-form-radio los-radio-{{$step->direction ?? "horizontal"}}" data-validation={{(isset($step->validation)) ? json_encode($step->validation) : ""}}>
        @php
            $str = "a";
            $key = $step->name ?? $key;
        @endphp
        @foreach ($step->choices as $choice)
            @if (isset($supporter->data[$key]) && $supporter->data[$key] == $choice->value)
            @php
                $checked = true;
            @endphp
            @elseif (isset($supporter->data[$key]) && gettype($supporter->data[$key]) == "array" && in_array($choice->value, $supporter->data[$key]))
            @php
                $checked = true;
            @endphp
            @else
            @php
                $checked = false;
            @endphp
            @endif
            @if($loop->first && isset($step->required) && $step->required == true)
                @php
                    $required = true
                @endphp
            @else
                @php
                    $required = false
                @endphp
            @endif
            <x-form.choice :choice="$choice" :name="$step->name ?? $key" :key="$key . '_' . $choice->value" :letter="$str" :checked="$checked" :multiple="$step->multiple ?? false" />
            @php
                $str++;
            @endphp
        @endforeach
        <x-form.submit :step="$step" />
    </form>
</div>
