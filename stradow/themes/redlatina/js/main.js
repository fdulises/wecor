document.addEventListener("DOMContentLoaded",function(){
	document.querySelector('#btnlang').addEventListener('click',function(e){
		e.preventDefault();
		var siteLang = listefi.getCookie('sitelang');
		if( siteLang == null ){
			listefi.setCookie('sitelang','es');
			siteLang = 'es';
		}
		if( siteLang == 'es' ) listefi.setCookie('sitelang','en');
		else if( siteLang == 'en' ) listefi.setCookie('sitelang','es');
		window.location = window.location;
	});

	//Funciones y estilos
	raychel.menuOffCanvas();
	var bxs = BoxSearch('<button type="button" class="mw-close fnt-white">&times;</button>');
	var head = document.querySelector('header');
	var menu = document.querySelector('nav');
	var mainSite = document.querySelector('main');
	var asideSite = document.querySelector('aside');
	var foot = document.querySelector('footer');
	var aud = document.querySelector('audio');

	function putBlur() {
		if (head) head.style.filter = 'blur(2rem)';
		if (menu) menu.style.filter = 'blur(2rem)';
		if (mainSite) mainSite.style.filter = 'blur(2rem)';
		if (asideSite) asideSite.style.filter = 'blur(2rem)';
		if (foot) foot.style.filter = 'blur(2rem)';
		if (aud) aud.style.filter = 'blur(2rem)';
	}
	function outPutBlur() {
		if (head) head.style.filter = 'blur(0px)';
		if (menu) menu.style.filter = 'blur(0px)';
		if (mainSite) mainSite.style.filter = 'blur(0px)';
		if (asideSite) asideSite.style.filter = 'blur(0px)';
		if (foot) foot.style.filter = 'blur(0px)';
		if (aud) aud.style.filter = 'blur(0px)';
	}

	function BoxSearch(args) {
		var contBlack = document.querySelector('#BoxSearch');
		contBlack.setAttribute('class', 'li-cover hide');
		contBlack.setAttribute('data-state', 'inactive');

		var show = function () {
			contBlack.classList.remove('hide');
			contBlack.setAttribute('data-state', 'active');
		};

		var remove = function () {
			document.body.removeChild(contBlack)
		};

		var hide = function () {
			contBlack.setAttribute('data-state', 'inactive');
			setTimeout(function () {
				contBlack.classList.add('hide')
			}, 600);
			document.body.style.overflow = 'auto';
			outPutBlur();
		};

		var addContent = function (cont) {
			if (typeof cont == 'string') contBlack.innerHTML += cont;
			else contBlack.appendChild(cont);
		};

		contBlack.addEventListener('click', hide);
		if (args != null) addContent(args);
		document.body.appendChild(contBlack);

		return {
			show: show,
			hide: hide,
			remove: remove,
			addContent: addContent,
			cover: contBlack
		};
	};

	var searchButton = document.querySelector('#searchButton').addEventListener('click', function () {
		bxs.show();
		document.body.style.overflow = 'hidden';
		putBlur();
	});
	var contForm = document.querySelector('#cont-form').addEventListener('click', function (evt) {
		evt.stopPropagation();
	});
	var contCategories = document.querySelector('#cont-categories').addEventListener('click', function (evt) {
		evt.stopPropagation();
	});

	if (window.matchMedia("(max-width: 600px)").matches){
		var btnM = document.querySelector("#btnMenu");
		btnM.addEventListener('click', function () {
			var box = document.createElement('div');
			box.style.width = "100%";
			box.style.height = "100%";
			box.style.position = "fixed";
			box.style.backgroundColor = "rgba(0,0,0,.4)";
			box.style.top = "0";
			box.style.left = "0";
			if (mainSite) mainSite.style.filter = 'blur(2rem)';
			if (asideSite) asideSite.style.filter = 'blur(2rem)';
			if (foot) foot.style.filter = 'blur(2rem)';
			if (aud) aud.style.filter = 'blur(2rem)';
			aud.style.zIndex = "0";
			document.body.appendChild(box);
			var barmenu = document.querySelector("#contMenu");
			box.addEventListener('click', function () {
				barmenu.setAttribute("data-state", "hide")
				this.parentNode.removeChild(this);
				outPutBlur();
				aud.style.zIndex = "200";
			});
			this.addEventListener("click",function(){
				document.body.removeChild(box);
			});
		});
	}
	//Slide Show
	var slideExist = document.querySelector(".deb-slide");
	if (slideExist)
		debSlide({
			selector: ".deb-slide",
			time: 8000,
			next: '.deb-s-n',
			prev: '.deb-s-p',
			auto: true,
			responsive: true,
		});

});
