let closeMenuBoutton = document.getElementById('close-menu-boutton');
closeMenuBoutton.addEventListener( 'click', hideNavMenu );
function showNavMenu() {
    document.getElementById('nav-bar').style.visibility = 'visible';
    closeMenuBoutton.style.visibility = 'visible';
}
function hideNavMenu() {
    closeMenuBoutton.style.visibility = 'hidden';
    document.getElementById('nav-bar').style.visibility = 'hidden';
}
let burgerMenu = document.getElementById('burger-menu');
burgerMenu.addEventListener( 'click', showNavMenu );
