<div class="los-form-contentblocks">
    @foreach ($step->blocks as $block)
        <x-dynamic-component :component='"form.contentblocks.{$block->type}"' :block="$block"/>
    @endforeach
</div>
