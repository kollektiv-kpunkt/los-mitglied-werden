<div class="los-input-submit-wrapper overflow-hidden max-h-0 w-full">
    <div class="los-input-submit flex flex-col mt-4">
        <x-button class="text-2xl ml-auto los-button-next" type="submit" markup="button" data-next="{{(isset($step->next)) ? json_encode($step->next) : ''}}">{{__("button.next")}}</x-button>
    </div>
</div>
