<div {{$attributes->merge(['class' => "text-white"])->merge(["class" => $step->class ?? ""]) }}}}>
    <h1 class="text-6xl font-bold mb-4">{{__($step->title)}}</h1>
    <p class="text-2xl">{{__($step->text)}}</p>
    <div class="flex w-full gap-4 mt-8 flex-col md:flex-row">
        <x-button type="initForm" type="member" class="los-button-next text-2xl">{{__("button.member")}}</x-button>
        <x-button type="initForm" type="activist" class="los-button-next los-button-neg text-2xl">{{__("button.activist")}}</x-button>
    </div>
</div>
