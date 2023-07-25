document.addEventListener("DOMContentLoaded", function (event) {
    const menuResponsive = document.getElementsByClassName('menu-responsive')[0]
    const btnOpen = document.querySelector('header .btn-open')
    const btnClose = document.querySelector('header .btn-close')

    btnOpen.addEventListener('click', (event) => {
        menuResponsive.classList.add('menu-visible')
        document.body.style.overflow = 'hidden'
    })
    btnClose.addEventListener('click', (event) => {
        menuResponsive.classList.remove('menu-visible')
        document.body.style.overflow = 'auto'
    })

    document.querySelectorAll('header .dropdown').forEach((parent) => {
        let content = parent.children[1]
        parent.addEventListener('click', (event) => {
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden')
                content.classList.add('flex')
                return
            }
            content.classList.add('hidden')
            content.classList.remove('flex')
        })
        parent.addEventListener('mouseover', (event) => {
            content.classList.remove('hidden')
            content.classList.add('flex')
        })
        parent.addEventListener('mouseleave', (event) => {
            content.classList.remove('flex')
            content.classList.add('hidden')
        })
    })
});
const stickNav = document.getElementById('stickNav');
window.addEventListener("scroll", () => {
    if(window.scrollY > 20) {
        stickNav.style.position = "fixed";
        stickNav.style.opacity = "0.90";
    }else {
        stickNav.style.position = "inherit";
    }
})
