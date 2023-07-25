<div style="display: flex; justify-content: space-around;">
    <div style="width: 49%">
        <img  src="{{ URL::asset($element->img1) }}" alt="{{ $element->img1 }}"/>
    </div>
    <div style="width: 49%">
        {!! $element->content_text !!}
    </div>
</div>

