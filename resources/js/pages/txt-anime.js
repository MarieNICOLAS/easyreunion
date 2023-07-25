const txtanim = document.getElementById("txt-anime");

var typewriter = new Typewriter(txtanim,{
    loop: true,
    delay: 75,
    deleteSpeed: 50,
});

typewriter
.pauseFor(1500)
.typeString('<span class="easy-green"><strong>réunion</strong></span>')
.pauseFor(1500)
.deleteChars(7)
.pauseFor(1000)
.typeString('<span class="easyDarkBlue2"><strong>séminaire</strong></span>')
.pauseFor(1500)
.deleteChars(9)
.pauseFor(1000)
.typeString('<span class="text-red"><strong>assemblée générale</strong></span>')
.pauseFor(1500)
.deleteChars(18)
.pauseFor(1000)
.typeString('<span class="easyDarkBlue2"><strong>visio conférence</strong></span>')
.pauseFor(1500)
.deleteChars(16)
.pauseFor(1000)
.typeString('<span class="easy-LightBlue"><strong>formation</strong></span>')
.pauseFor(1500)
.deleteChars(9)
.pauseFor(1000)
.typeString('<span class="easy-Color"><strong>cocktail</strong></span>')
.pauseFor(1500)
.deleteChars(8)
.pauseFor(1000)
.typeString('<span class="text-pink"><strong>tournage de film</strong></span>')
.pauseFor(3000)
.start();