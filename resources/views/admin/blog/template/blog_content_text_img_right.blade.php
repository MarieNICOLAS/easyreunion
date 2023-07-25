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
    <div class="contentTextImgleft_content">

        <div class="element">
            <div class="blogArticleTextArea" {{ isset($element) ? 'id=textarea-'.$element->id : "" }}>
                {{ isset($element) ? $element->content_text : "" }}
            </div>
        </div>


        <div class="contentTextImgLeft_img element">

            <label class="text-xl mb-1 text-center">
                Ajouter une photo
            </label>
            <input type="file" id="blog_article_cover_img-{{ isset($element) ? $element->id : "" }}" accept="image/jpeg, image/png, image/jpg" class="TextImgLeft-blog_article_cover_img">
            <input type="hidden" id="blog_article_image-{{ isset($element) ? $element->id : "" }}" class="formElement TextImgLeft-blog_article_image">
            <input type="hidden" id="blog_article_image_url-{{ isset($element) ? $element->id : "" }}" value = "{{ isset($element) ? $element->img1 : ""}}" class="formElement TextImgLeft-blog_article_image_url">
            @if(isset($element) && ($element->img1))
                <div id="display-image-{{ isset($element) ? $element->id : "" }}" class="display-image-bloc TextImgLeft-display-image" style="background-image: url('{{ URL::asset($element->img1) }}')" class="TextImgLeft-display-image"></div>
            @else
                <div id="display-image-{{ isset($element) ? $element->id : "" }}" class="display-image-bloc TextImgLeft-display-image" style="display: none" class="TextImgLeft-display-image"></div>
            @endif

        </div>




    </div>
    <br/><br/>

</div>
