// Methodes pour afficher correctement le menu en fonction des resize (burger menu ou pas )
let closeMenuBoutton = document.getElementById('close-menu-boutton');

function hideNavMenu() {
    closeMenuBoutton.style.visibility = 'hidden';
    document.getElementById('nav-bar').style.visibility = 'hidden';
}
closeMenuBoutton.addEventListener( 'click', hideNavMenu );

function showNavMenu() {
    document.getElementById('nav-bar').style.visibility = 'visible';
}
function showNavMenuWithCloseBox() {
    showNavMenu();
    closeMenuBoutton.style.visibility = 'visible';
}

let burgerMenu = document.getElementById('burger-menu');
burgerMenu.addEventListener( 'click', showNavMenuWithCloseBox );

let lastWidowWidth = 1000;
function showHideNavMenu() {
    if( $(window).width() > 1000 ) {
        showNavMenu();
    }
    else if( lastWidowWidth > 1000 ) hideNavMenu();
    lastWidowWidth = $(window).width();
}
window.addEventListener( 'resize' , showHideNavMenu );