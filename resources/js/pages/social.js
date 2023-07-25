(function(){

    const popupCenter = function(url, title, width, height){
        const popupWidth = width || 640;
        const popupHeight = height || 320;
        const windowLeft = window.screenLeft || window.screenX;
        const windowTop = window.screenTop || window.screenY;
        const windowWidth = window.innerWidth || document.documentElement.clientWidth;
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        const popupLeft = windowLeft + windowWidth / 2 - popupWidth / 2 ;
        const popupTop = windowTop + windowHeight / 2 - popupHeight / 2;
        const popup = window.open(url, title, 'scrollbars=yes, width=' + popupWidth + ', height=' + popupHeight + ', top=' + popupTop + ', left=' + popupLeft);
        popup.focus();
        return true;
    };
    const share = document.querySelector('.shareT');
    share.setAttribute("data-url", window.location.href);

    const shareF = document.querySelector('.shareF');
    shareF.setAttribute("data-url", window.location.href);

    const shareL = document.querySelector('.shareL');
    shareL.setAttribute("data-url", window.location.href);



     document.querySelector('.share_twitter').addEventListener('click', function(e){
        e.preventDefault();
        var url = this.getAttribute('data-url');
        
        var shareUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(document.title) +
            "&via=EasyReunion" +
            "&url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Twitter");
    });

    document.querySelector('.share_facebook').addEventListener('click', function(e){
        e.preventDefault();
        var url = this.getAttribute('data-url');
        var shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur facebook");
    });


    document.querySelector('.share_linkedin').addEventListener('click', function(e){
        e.preventDefault();
        var url = this.getAttribute('data-url');
        var shareUrl = "https://www.linkedin.com/shareArticle?url=" + encodeURIComponent(url);
        popupCenter(shareUrl, "Partager sur Linkedin");
    });

})();