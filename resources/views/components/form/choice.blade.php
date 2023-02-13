<div class="los-input-group los-input-choices-group">
    @if ($multiple == true)
        <input type="checkbox" {{$attributes}} name="{{$name}}[]" id="{{$key}}" value="{{$choice->value}}" class="los-input-radio"@if($checked) {{" checked"}}@endif>
    @else
        <input type="radio" {{$attributes}} name="{{$name}}" id="{{$key}}" value="{{$choice->value}}" class="los-input-radio"@if($checked) {{" checked"}}@endif>
    @endif
    <label for="{{$key}}" class="los-input-radio-label text-2xl flex gap-3 bg-accent text-white bg-opacity-30 px-4 py-3 items-center border-2 border-accent rounded-sm cursor-pointer" tabindex="0" data-letter="{{$letter}}">
        <span class="los-input-radio-letter bg-accent h-8 w-8 flex justify-center items-center uppercase flex-shrink-0">{{$letter}}</span>
        {{__($choice->label)}}
    </label>
</div>
