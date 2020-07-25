var linkactive = document.querySelector('.nav-bar ul a[href="'+window.location.href+'"]');
if( linkactive ) linkactive.classList.add('active');

var btnshownav = document.querySelector('#btnshownav');
var mainnav = document.querySelector('.nav-bar ul');
btnshownav.addEventListener('click', function(){
	var state = mainnav.getAttribute('data-state');
	if( state != 'show' ) mainnav.setAttribute('data-state', 'show');
	else mainnav.setAttribute('data-state', 'hide');
});


var selectelems = document.querySelectorAll('select[data-selected]');
Object.keys(selectelems).map(function(k){
	var value = selectelems[k].getAttribute('data-selected');
	var option = selectelems[k].querySelector('option[value="'+value+'"]');
	if( option ) option.setAttribute('selected', '');
});

hljs.initHighlightingOnLoad();
