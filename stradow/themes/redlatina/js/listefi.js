/*
* Listefi - Frontend Framework
* Desarrollado por el equipo Debred - contacto@debred.com
* V 17.11.09
*/
var listefi = function(e){return document.querySelector(e)};
/*
	AJAX
*/
listefi.ajax = function(conf){
	var url = conf.url;
	var method = conf.method.toLowerCase() || 'get';
	var data = null;
	var isFormData = conf.data instanceof FormData;
	conf.success || ( conf.success = function(a){} );

	//Preparamos los datos a enviar si son requeridos
	if( !isFormData && (typeof conf.data == 'object') ){
		data = Object.keys(conf.data).map(function(k){
			return encodeURIComponent(k) + '=' + encodeURIComponent(conf.data[k])
		}).join('&');
	}else data = conf.data || null;

	//Se agregan los datos a enviar a la url en caso de peticion get
	if( typeof data == 'string' && method == 'get' ) url += ((/\?/).test(url)?"&":"?")+data;

	//Evitamos que se guarde en cache la peticion
	if( !conf.cache ) url += ((/\?/).test(url)?"&":"?")+(new Date()).getTime();

	//Preparamos el objeto de la peticion ajax
	var xhr = new XMLHttpRequest();
	xhr.open( method, url );

	//Establecemos los encabezados necesarios para peticion post
	if( method == 'post' && !isFormData ){
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	}

	//Manejador de eventos para procesar respuesta
	if( typeof conf.success == 'function' ){
		xhr.addEventListener('readystatechange', function(){
			if(xhr.readyState > 3){
				if( xhr.status==200 ) conf.success(xhr.responseText);
				if( typeof conf.complete == 'function' ) conf.complete(xhr);
			}
		});
	}

	//Manejador de eventos inicio de transferencia
	if( typeof conf.loadstart == 'function' ) xhr.addEventListener('loadstart', conf.loadstart);

	//Manejador de eventos rastreo de proceso de transferencia (Download)
	if( typeof conf.progress == 'function' ) xhr.addEventListener('progress', conf.progress);

	//Manejador de eventos rastreo de proceso de transferencia (Upload)
	if( typeof conf.uploadProgress == 'function' ) xhr.upload.addEventListener('progress', conf.uploadProgress);

	//Manejador de eventos transferencia completa
	if( typeof conf.load == 'function' ) xhr.addEventListener('load', conf.load);

	//Manejador de eventos error de transferencia
	if( typeof conf.error == 'function' ) xhr.addEventListener('error', conf.error);

	//Enviamos peticion y retornamos objeto ajax
	xhr.send(data);
	return xhr;
};
/*
	AJAX - Load
*/
listefi.load = function(container, url){listefi.ajax({method: 'get', url: url, success: function(resultado){listefi(container).innerHTML = resultado}})};

/*
	Modal Windows
*/
listefi.lightbox = function(args){
	var contBlack = document.createElement('div');
	contBlack.setAttribute('class','li-cover hide');
	contBlack.setAttribute('data-state','inactive');

	var show = function(){
		contBlack.classList.remove('hide');
		contBlack.setAttribute('data-state','active');
	};

	var remove = function(){document.body.removeChild(contBlack)};

	var hide = function(){
		contBlack.setAttribute('data-state','inactive');
		setTimeout(function () {contBlack.classList.add('hide')}, 600);
	};

	var addContent = function(cont){
		if( typeof cont == 'string' ) contBlack.innerHTML += cont;
		else contBlack.appendChild(cont);
	};

	contBlack.addEventListener('click',hide);
	if(args != null) addContent(args);
	document.body.appendChild(contBlack);

	return {show:show, hide:hide, remove:remove, addContent:addContent, cover:contBlack};
};

listefi.alert = function(body, head, controls, callback){
	var newlightbox = listefi.lightbox();
	function ccreate(){
		var cc = document.createElement('div');
		cc.setAttribute("class", "container cont-600 mg-sec");
		ccreate = function(){return cc.cloneNode();}
		return cc.cloneNode();
	}
	var cont = ccreate();
	listefi.alert = function(body, head, controls, callback){
		var continner = "";
		if( head != null ){
			continner = '<div class="card-header"><button type="button" class="mw-close">&times;</button><h4>'+head+'</h4></div>';
			continner += "<div class='card-frame'>"+body+"</div>";
		}else continner += "<div class='card-frame'><button type='button' class='mw-close'>&times;</button>"+body+"</div>";

		cont.addEventListener('click',function(e){e.stopPropagation();});
		cont.innerHTML = continner;

		if( controls != null ){
			var cfo = document.createElement("div");
			cfo.setAttribute("class", "card-footer tx-right");
			controls.forEach(function(i){
				var nbtn = document.createElement("button");
				nbtn.setAttribute("type", "button");
				nbtn.innerHTML = i.html;
				nbtn.setAttribute("class", i.class);
				nbtn.setAttribute("id", i.id);
				nbtn.addEventListener("click", function(){i.action(newlightbox)});
				cfo.appendChild(nbtn);
			});
			cont.appendChild(cfo);
		}

		cont.querySelector(".mw-close").addEventListener("click", newlightbox.hide);
		newlightbox.innerHTML = ""; newlightbox.addContent(cont);
		if( callback != null ) callback(newlightbox);
		newlightbox.show();
	}
	listefi.alert(body, head, controls, callback);
};

listefi.confirm = function(body, arg1, arg2){
	var header = arg1;
	var callback = arg2;
	if( typeof arg1 == "function" ){callback = arg1; header = 'Confirmar!';}
	function closeCallback(){
		callback(false);
		this.removeEventListener("click", closeCallback);
	}
	listefi.alert(body, header, [
		{html: "Aceptar",
		class: "btn btn-primary",
		id: "",
		action: function(l){callback(true); l.hide(); l.cover.querySelector(".mw-close").removeEventListener("click", closeCallback)}},
		{html: "Cancelar",
		class: "btn",
		id: "",
		action: function(l){callback(false); l.hide(); l.cover.querySelector(".mw-close").removeEventListener("click", closeCallback)}}
	], function(l){
		l.cover.querySelector(".mw-close").addEventListener("click", closeCallback);
	});
};
/*
	ScrollTo
*/
Math.easeInOutQuad = function (t, b, c, d) {
	t /= d/2; if (t < 1) return c/2*t*t + b; t--;
	return -c/2 * (t*(t-2) - 1) + b;
};
var requestAnimFrame = (function(){
	return 	window.requestAnimationFrame || function( callback ){
		window.setTimeout(callback, 1000 / 60);
	};
})();
listefi.scrollTo = function(to, duration, callback) {
	function move(amount) {
		document.documentElement.scrollTop = amount;
		document.body.parentNode.scrollTop = amount;
		document.body.scrollTop = amount;
	}
	function position() {
		return document.documentElement.scrollTop ||
			document.body.parentNode.scrollTop ||
			document.body.scrollTop;
	}
	var start = position(),	change = to - start, currentTime = 0, increment = 20;
	duration = (typeof(duration) === 'undefined') ? 500 : duration;
	var animateScroll = function() {
		currentTime += increment;
		var val = Math.easeInOutQuad(currentTime, start, change, duration);
		move(val);
		if (currentTime < duration) requestAnimFrame(animateScroll);
		else {if (callback && typeof(callback) === 'function') callback();}
	};
	animateScroll();
};

/*
	Cookies - Set cookie, get cookie y delete cookie
*/
listefi.getCookie = function( name ){
	var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return v ? v[2] : null;
};
listefi.setCookie = function( name, value, days ){
	var d = new Date; d.setTime(d.getTime() + 24*60*60*1000*days);
	document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
};
listefi.deleteCookie = function(name) { listefi.setCookie(name, '', -1); };
/*
	Helpers
*/
listefi.getRand = function(){var nran = 0; nran = Math.ceil(Math.random()*1000000); return nran;}
//Get the position of any element relative to the viewport
listefi.offset = function(el){
	var rect = el.getBoundingClientRect(),
	scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
	scrollTop = window.pageYOffset || document.documentElement.scrollTop;
	return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
}
listefi.validURL = function(str){
	var a = document.createElement('a'); a.href = str;
	return (a.host && a.host != window.location.host);
}