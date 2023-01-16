<div class="los-form-step">
    <h2 class="text-white text-5xl font-bold mb-10">{{__($step->title)}}</h2>
    <form action="/s/update" method="POST" class="flex justify-between flex-wrap los-memberform-partial">
        @foreach ($step->fields as $field)
        <x-form.input :field="$field" />
        @endforeach
        <x-form.submit :step="$step" />
    </form>
</div>
