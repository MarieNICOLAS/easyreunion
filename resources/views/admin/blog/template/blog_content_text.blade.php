<div {{ isset($element) ? 'data-elementorder='.$element->element_order : "" }}
     {{ isset($element) ? 'id=element-'.$element->id : "" }}
     {{ isset($element) ? 'class=article-element' : "" }}
     {{ isset($element) ? 'data-blogtype='.$element->type->template_name  : ""}}
     >
    <div class="iconButton">
        <i class="large material-icons editElementButton" data-func="delete" {{ isset($element) ? 'id=iconButton-0-'.$element->id : "" }}>
            delete
        </i>
        <div>&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <i class="large material-icons editElementButton" data-func="up" {{ isset($element) ? 'id=iconButton-1-'.$element->id : "" }}>arrow_upward</i>
        <i class="large material-icons editElementButton" data-func="down" {{ isset($element) ? 'id=iconButton-2-'.$element->id : "" }}>arrow_downward</i>


    </div>
    <div class="blogArticleTextArea" {{ isset($element) ? 'id=textarea-'.$element->id : "" }}>
        {{ isset($element) ? $element->content_text : "" }}
    </div>
    <br/><br/>

</div>

