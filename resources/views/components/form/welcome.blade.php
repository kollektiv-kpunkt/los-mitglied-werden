<div {{$attributes->merge(['class' => "text-white"])->merge(["class" => $step->class ?? ""]) }}}}>
    <h1 class="text-6xl font-bold mb-4">{{__($step->title)}}</h1>
    <p class="text-2xl">{{__($step->text)}}</p>
    <div class="flex w-full gap-4 mt-4">
        <x-button type="initForm" type="member" class="los-button-more text-2xl">{{__("button.member")}}</x-button>
    </div>
</div>
