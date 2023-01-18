<div class="flex flex-wrap w-full gap-4 mt-8 flex-col md:flex-row">
    @foreach ($block->buttons as $button)
        <x-button markup="{{$button->markup ?? 'a'}}" type="{{$button->type ?? 'link'}}" action="{{$button->action ?? ''}}" class="{{$button->class ?? ''}}">{{__($button->label)}}</x-button>
    @endforeach
</div>
