var linkactive = document.querySelector('.nav-bar ul a[href="'+window.location.href+'"]');
if( linkactive ) linkactive.classList.add('active');

var btnshownav = document.querySelector('#btnshownav');
var mainnav = document.querySelector('.nav-bar ul');
btnshownav.addEventListener('click', function(){
	var state = mainnav.getAttribute('data-state');
	if( state != 'show' ) mainnav.setAttribute('data-state', 'show');
	else mainnav.setAttribute('data-state', 'hide');
});
