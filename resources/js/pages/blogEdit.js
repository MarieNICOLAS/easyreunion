let token                     = document.querySelector('input[name="_token"]').value;
let saveButton                = document.getElementById('saveButton');
let addElementTypeButtons     = document.querySelectorAll('.addElementTypeButton');
let blogArticleContentElement = document.getElementById('blogArticleContentElement');
let elementorder              = parseInt(originalCount);
let inputCategory             = document.getElementById('blog_category_name');
let inputCategoryId           = document.getElementById('blog_category_id');
let categoryNameListDiv       = document.getElementById('category_name_list');
let inputCoverImage           = document.getElementById('blog_article_cover_img');
let formElements              = document.querySelectorAll('.formElement');
let messageDiv                = document.getElementById('message');

/**
 * Update field category name and id
 * after autocompletion
 *
 * @param name
 * @param id
 */
const addCategoryInInput = (name, id) => {
    inputCategory.value = name;
    inputCategoryId.value = id;
    categoryNameListDiv.style.display = "none";
}

/**
 * init BlogArticleElement at page loading
 */
const initElements = () => {

    let allElements = document.querySelectorAll('.article-element');

    // init if element exist
    if(allElements.length > 0) {
        for(let i = 0; i < allElements.length; i++) {


            let type = allElements[i].dataset.blogtype;

            let id = allElements[i].id.split('-')[1];


            // generate view for blog_content_text
            if(type == "blog_content_text") {
                initElementTextArea(id);
            }


            if(type == "blog_content_text_img_left" || type == "blog_content_text_img_right") {
                initElementTextArea(id);
                initElementImgText(id);
            }


            // init button icon
            for(let i = 0; i < 3; i++) {
                document.getElementById('iconButton-'+i+'-' + id).addEventListener('click', function () {
                    elementButtonExecuteFunc(this);
                })
            }




        }
    }


}


/**
 * Listener category with autocomplet
 */
inputCategory.addEventListener('input', function() {

    inputCategoryId.value = "";

    let string = this.value;

    let url = urlCategoryList;

    if(string.length > 1) {

        let datas = { string : string };

        datas = createDatas(datas);

        fetch(url, {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: datas
        }).then(function(response) {
            if (response.ok) {
                return response.json();
            }
        }).then(function (result) {

            categoryNameListDiv.style.display = "block";
            let html = "";
            for(let i = 0; i < result[0].length; i++) {
                html += `<li onclick="addCategoryInInput('${result[0][i].name}', '${result[0][i].id}')">${result[0][i].name}</li>`;
            }

            categoryNameListDiv.innerHTML = html;

            setTimeout(function(){
                    categoryNameListDiv.style.display = "none";
                }, 5000
            );

        });
    }

})


/**
 * listener input image
 */

inputCoverImage.addEventListener("change", function() {

    const reader = new FileReader();
    reader.addEventListener("load", () => {
        const uploaded_image = reader.result;
        document.querySelector("#blog_article_image").value = uploaded_image;
        document.querySelector("#display-image").style.display = "block";
        document.querySelector('#blog_article_image_url').value = "";
        document.querySelector("#display-image").style.backgroundImage = `url(${uploaded_image})`;
    });
    reader.readAsDataURL(this.files[0]);
});


/**
 * Listener change element in form
 */
for(let i = 0; i < formElements.length; i++) {
    formElements[i].addEventListener('change', function() {
        saveButton.classList.add('needToSave');
    });
}


/**
 * Listener on AddBlogArticleElement
 */
for (let i = 0; i < addElementTypeButtons.length; i++) {
    addElementTypeButtons[i].addEventListener('click', function(e) {
        e.preventDefault();
        addArticleElement(this.dataset.type, this.dataset.typeid, this.href);
    })
}

/**
 *
 * Add BlogElement
 *
 * @param type
 * @param typeId
 * @param url
 */
const addArticleElement = (type, typeId, url) => {


    let template = document.querySelector('#template_'+type+'>div');

    // count element and order
    elementorder++;

    // create element in bdd
    let datas = createDatas( { type_id : typeId, element_order: elementorder} );

    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: datas
    }).then(function(response) {
        if (response.ok) {
            return response.json();
        }
    }).then(function (result) {
        if(type == "blog_content_text") {

            let new_template = template.cloneNode(true);

            // add order on div
            new_template.dataset.elementorder = elementorder;
            new_template.classList.add('article-element');
            new_template.setAttribute('id', 'element-'+result.id);

            // add info on texstarea
            new_template.querySelector('.blogArticleTextArea').setAttribute('id', 'textarea-'+result.id);

            // add the template in fluw
            blogArticleContentElement.append(new_template);

            // add command button on editElementButton of template
            let editElementButtons = new_template.querySelectorAll('.editElementButton');

            // add listener on button
            for(let i = 0; i < editElementButtons.length; i++) {
                editElementButtons[i].setAttribute('id', 'iconButton-'+i+'-'+result.id);
                editElementButtons[i].addEventListener('click', function() {
                    elementButtonExecuteFunc(this);
                })
            }

            // add quill html editor wysiwig on bloc element
            let quill = new Quill('#textarea-'+result.id, {
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['bold', 'italic', 'underline'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'font': [] }],
                        [{ 'align': [] }],
                        ['image', 'code-block'],
                        ['video'],
                        ['link'],
                        ['clean']
                    ]
                },
                placeholder: 'Rédigez votre texte...',
                theme: 'snow'
            });

            // add listener on div textarea
            document.getElementById('textarea-'+result.id).addEventListener('DOMSubtreeModified', function() {
                saveButton.classList.add('needToSave');
            });
        }


        if(type == "blog_content_text_img_left" || type == "blog_content_text_img_right") {

            let new_template = template.cloneNode(true);

            // add order on div
            new_template.dataset.elementorder = elementorder;
            new_template.classList.add('article-element');
            new_template.setAttribute('id', 'element-'+result.id);

            // add info on texstarea
            new_template.querySelector('.blogArticleTextArea').setAttribute('id', 'textarea-'+result.id);

            // add the template in fluw
            blogArticleContentElement.append(new_template);

            // add command button on editElementButton of template
            let editElementButtons = new_template.querySelectorAll('.editElementButton');

            // add listener on button
            for(let i = 0; i < editElementButtons.length; i++) {
                editElementButtons[i].setAttribute('id', 'iconButton-'+i+'-'+result.id);
                editElementButtons[i].addEventListener('click', function() {
                    elementButtonExecuteFunc(this);
                })
            }

            // init left part
            new_template.querySelector(".TextImgLeft-blog_article_image").setAttribute('id', "blog_article_image-"+result.id);
            new_template.querySelector(".TextImgLeft-display-image").setAttribute('id', "display-image-"+result.id);
            new_template.querySelector('.TextImgLeft-blog_article_image_url').setAttribute('id', "blog_article_image_url-"+result.id);
            new_template.querySelector(".TextImgLeft-blog_article_cover_img").setAttribute('id', "blog_article_cover_img-"+result.id);

            initElementTextArea(result.id);
            initElementImgText(result.id);

            location.reload();

        }
    });
}

/**
 * Init block img/text with id
 */
const initElementImgText = (id) => {

    let inputFile = document.querySelector('#blog_article_cover_img-'+id);


    inputFile.addEventListener("change", function() {

        const reader = new FileReader();
        reader.addEventListener("load", () => {
            const uploaded_image = reader.result;
            document.querySelector("#blog_article_image-"+id).value = uploaded_image;
            document.querySelector("#display-image-"+id).style.display = "block";
            document.querySelector('#blog_article_image_url-'+id).value = "";
            document.querySelector("#display-image-"+id).style.backgroundImage = `url(${uploaded_image})`;
        });
        reader.readAsDataURL(this.files[0]);

    });

}

/**
 * Init textArea
 */
const initElementTextArea = (id) => {


    // init quill js editor
    let html = document.getElementById('textarea-'+id).innerText;

    document.getElementById('textarea-'+id).innerHTML = "";
    let quill = new Quill('#textarea-' + id, {
        modules: {
            toolbar: [
                [{header: [1, 2, 3, 4, 5, 6, false]}],
                [{'list': 'ordered'}, {'list': 'bullet'}],
                ['bold', 'italic', 'underline'],
                [{'color': []}, {'background': []}],
                [{'font': []}],
                [{'align': []}],
                ['image', 'code-block'],
                ['video'],
                ['link'],
                ['clean']
            ]
        },
        theme: 'snow'
    });

    // add content to quill js editor
    let delta = quill.clipboard.convert(html);
    quill.setContents(delta, 'silent');


    // add listener change on textarea
    document.getElementById('textarea-'+id).addEventListener('DOMSubtreeModified', function() {
        saveButton.classList.add('needToSave');
    });





}



/**
 * execute function delete, up, down BlogElement
 *
 * @param buttonElement
 */
const elementButtonExecuteFunc = (buttonElement) => {
    let func = buttonElement.dataset.func;
    let elementParent = buttonElement.parentNode.parentNode;
    let el = buttonElement.id;

    let elementId = el.split('-')[2];
    let elementOrder = elementParent.dataset.elementorder;

    let current_element = document.getElementById(`element-${elementId}`);

    if( func == "delete") {

        // delete in bdd
        let url = urlDeleteElement;

        let datas = { element_id : elementId }

        datas = createDatas(datas);

        fetch(url, {
            method: "DELETE",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: datas
        }).then(function(response) {
            if (response.ok) {
                return response.json();
            }
        }).then(function (result) {
            console.log(result);
        });

        current_element.remove();
    }

    if( func == "up") {
        let target_id = parseInt(elementOrder)-1;
        // target elment
        let target_element = document.getElementById('blogArticleContentElement').querySelector(`.article-element[data-elementorder="${target_id}"]`);
        // move element before order before
        target_element.insertAdjacentElement('beforebegin',current_element);
    }

    if( func == "down") {
        let target_id = parseInt(elementOrder)+1;
        // target elment
        let target_element = document.getElementById('blogArticleContentElement').querySelector(`.article-element[data-elementorder="${target_id}"]`);
        // move element before order before
        target_element.insertAdjacentElement('afterend',current_element);
    }

    // re-order elements
    reOrderAllElements();

}

/**
 * Re-order all elements
 */
const reOrderAllElements = () => {
    let allElements = document.querySelectorAll('.article-element');

    let newElementOrder = 0;

    for(let i = 0; i < allElements.length; i++) {
        newElementOrder++;
        allElements[i].dataset.elementorder = newElementOrder;
    }
    elementorder = newElementOrder;
}


/**
 * save button submit
 */
saveButton.addEventListener('click', function(e) {

    e.preventDefault();

    let url = saveButton.href;

    let datas = createDatas(retrieveFormData());

    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: datas
    }).then(function(response) {
        if (response.ok) {
            return response.json();
        }
    }).then(function (result) {
        document.getElementById('blog_article_id').value = result.id;
        saveElements();
        saveButton.classList.remove('needToSave');
        saveButton.classList.add('upToDate');
        messageDiv.style.display = "block";
        messageDiv.innerHTML= "Article sauvegardé !";
        messageDiv.classList.add('fade-out');
        setTimeout(function(){
                messageDiv.innerHTML = "";
                messageDiv.style.display = "none";
            }, 5000
        );
    });


})

/**
 * Parse all elements and prepare to save
 */
const saveElements = () => {
    let allElements = document.querySelectorAll('.article-element');

    for(let i = 0; i < allElements.length; i++) {


        console.log(i);

        let type = allElements[i].dataset.blogtype;
        let currentElement = allElements[i];
        let elementId = currentElement.id.split('-')[1];
        let elementOrder = currentElement.dataset.elementorder;

        let contentText = null;
        let cover_img_64  = null;
        let cover_img_url = null;

        if(type == "blog_content_text") {
            contentText = currentElement.querySelector('.ql-editor').innerHTML;
        }

        if(type == "blog_content_text_img_left" || type == "blog_content_text_img_right") {
            // add contentText
            contentText = currentElement.querySelector('.ql-editor').innerHTML;
            console.log(contentText);

            // add contentImg64
            cover_img_64 = currentElement.querySelector('#blog_article_image-'+elementId).value;
            cover_img_url= currentElement.querySelector('#blog_article_image_url-'+elementId).value;

        }

        updateElement(elementId, elementOrder, contentText, cover_img_64, cover_img_url);
    }


}


/**
 * Update in bdd element
 *
 * @param elementId
 * @param orderId
 * @param contentText
 */
const updateElement = (elementId, orderId = null, contentText = null, cover_img_64 = null, cover_img_url = null) => {

    let url = urlUpdateElement;

    let datas = { element_id : elementId, element_order : orderId, content_text: contentText, cover_img_64: cover_img_64, cover_img_url: cover_img_url};

    datas = createDatas(datas);

    fetch(url, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: datas
    }).then(function(response) {
        if (response.ok) {
            return response.json();
        }
    }).then(function (result) {
        console.log(result);
    });

}


/**
 *
 * strinfy data to post ajax
 *
 * @param datas
 * @returns {string | *}
 */
const createDatas = (datas) => {
    datas['_token'] = token;
    datas['article_id'] = document.getElementById('blog_article_id').value;
    datas = JSON.stringify(datas);
    return datas;
}


/**
 * return data from form
 * @returns {{title: *, resume: *, publicated_at: *, status: *, category_name: *}}
 */
const retrieveFormData = () => {
    return {
        title: document.getElementById('blog_title').value,
        resume: document.getElementById('blog_resume').value,
        publicated_at: document.getElementById('blog_publicated_at').value,
        status: document.getElementById('blog_status').value,
        category_name: document.getElementById('blog_category_name').value,
        category_id: document.getElementById('blog_category_id').value,
        cover_img_64: document.getElementById('blog_article_image').value,
        cover_img_url: document.getElementById('blog_article_image_url').value,
        slug: document.getElementById('blog_slug').value
    }
}


// at page loading

initElements();
