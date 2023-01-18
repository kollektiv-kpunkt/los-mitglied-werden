<div class="los-input-submit-wrapper overflow-hidden max-h-0 w-full">
    <div class="los-input-submit flex flex-col mt-4">
        <x-button class="text-2xl ml-auto los-button-next" type="submit" markup="button" data-next="{{$step->next ?? ''}}">{{__("button.next")}}</x-button>
        <p class="text-sm text-white text-end mt-2">Oder <b class="text-accent">Enter &#11152;</b> drücken</p>
    </div>
</div>
