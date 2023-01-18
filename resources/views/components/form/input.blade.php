<div class="los-input-group los-input-group-{{$field->size ?? "half"}} text-{{$field->color ?? "white"}} los-input-group-{{$field->accent ?? "accent"}} flex flex-col">
    <label for="{{$field->name}}" class="text-2xl mb-2">{{__($field->label)}}</label>
    <input type="{{$field->type}}" name="{{$field->name}}" id="{{$field->name}}" value="{{$value}}" class="los-input text-3xl los-input-{{$field->type}}" placeholder="{{__($field->placeholder ?? "")}}"@if(isset($field->required) && $field->required == true) required @endif>
</div>
