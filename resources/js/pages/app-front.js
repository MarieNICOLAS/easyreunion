let hostname = window.location.hostname;

    if(hostname != "easy" && hostname != "localhost" && hostname != "easyReunion") {
      
        window.axeptioSettings = {
            clientId: "62beef4ca82bf8c8b7ae267c",
            cookiesVersion: "easyreunion-fr",
        };
    }

    (function (d, s) {
        var t = d.getElementsByTagName(s)[0], e = d.createElement(s);
        e.async = true;
        e.src = "//static.axept.io/sdk.js";
        t.parentNode.insertBefore(e, t);
    })(document, "script");

    // scroll to top function
    const btnUp = document.getElementById('btnUp');
    btnUp.addEventListener('click', () =>{

    window.scrollTo({
    top: 0,
    left: 0,
    behavior: "smooth"
        })
    })
