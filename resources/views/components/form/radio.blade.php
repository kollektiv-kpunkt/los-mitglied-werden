<div class="los-form-step">
    <h2 class="text-white text-5xl font-bold mb-10">{{__($step->title)}}</h2>
    <form action="/s/update" method="POST" class="flex flex-wrap gap-4 los-memberform-partial los-form-radio los-radio-{{$step->direction ?? "horizontal"}}">
        @php
            $str = "a";
        @endphp
        @foreach ($step->choices as $choice)
        @if ($loop->first)
        @php
            $checked = true;
        @endphp
        @else
        @php
            $checked = false;
        @endphp
        @endif
        <x-form.choice :choice="$choice" :name="$key" :key="$key . '_' . $choice->value" :letter="$str" :checked="$checked" />
        @php
            $str++;
        @endphp
        @endforeach
        <x-form.submit :step="$step" />
    </form>
</div>
