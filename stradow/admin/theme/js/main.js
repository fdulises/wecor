//Definimos funcionamiento de barra de navegacion
document.addEventListener('DOMContentLoaded', function () {
	var btn = document.querySelector('#actionNav');
	var nav = document.querySelector('#leftNav');
	var cont = document.querySelector('#cont');
	function showNav(){
		btn.setAttribute('data-estado','open');
		nav.setAttribute('data-estado','open');
		cont.setAttribute('data-estado','open');
	}
	function hideNav(){
		btn.setAttribute('data-estado','close');
		nav.setAttribute('data-estado','close');
		cont.setAttribute('data-estado','close');
	}
	document.querySelector('#actionNav').addEventListener('click',function(){
		if( btn.getAttribute('data-estado') == "open" ){
			hideNav();
			listefi.setCookie('navshow', 0, 30);
		}else{
			showNav();
			listefi.setCookie('navshow', 1, 30);
		}
	});
	if( listefi.getCookie('navshow') == 1 ) showNav();
	else hideNav();
});

//Definimos funcionamiento de Menus dropdowns
(function(){
	var openedListCookie = listefi.getCookie('openedList');
	if( !openedListCookie ){
		listefi.setCookie('openedList', '', 30);
		openedListCookie = '';
	}
	var openedList = openedListCookie.split(",");
    function dropenerToogle( dataid ){
        var index = openedList.indexOf(dataid);
        var isset = index != -1;
        if( !isset ) openedList.push( dataid );
        else openedList.splice(index, index);
        listefi.setCookie('openedList', openedList.join(","), 30);
    }
    window.addEventListener("load", function(){
        selectorMultiple('.drcont', function(k,e){
            e[k].style.height = e[k].offsetHeight+"px";
            var dataid = e[k].parentNode.getAttribute("data-id");
            if( in_array( dataid, openedList ) ) e[k].parentNode.setAttribute("data-state", "opened");
            else e[k].parentNode.setAttribute("data-state", "closed");
        });
        addEvent(".dropener", "click", function(){
            var iconc = this.querySelector("span");
            var state = this.parentNode.getAttribute("data-state") || "closed";
            var dataid = this.parentNode.getAttribute("data-id");
            if( state == "closed" ){
                this.parentNode.setAttribute("data-state", "opened");
                iconc.setAttribute("class", "icon-chevron-up");
            }else{
                this.parentNode.setAttribute("data-state", "closed");
                iconc.setAttribute("class", "icon-chevron-down");
            }
            dropenerToogle( dataid );
        });
    });
})();

document.addEventListener('DOMContentLoaded',function(){

/* Definimos la logica que se ejecuta en todas las secciones */

//Auxiliar para envio de formularios
addEvent(".simpleform", "submit", function(e){
	e.preventDefault();
	listefi.ajax({
		url:this.action, method:this.method, data:new FormData(this),
		success: function(result){
			result = JSON.parse(result);
			if( result.state == 1 ) listefi.alert("Datos Guardados Correctamente","Éxito");
			else listefi.alert("<p>No se púdo procesar el formulario.</p><p>Intente de nuevo más tarde</p>","Error");
		}
	});
});

//Generamos recomendacion de SLUG
addEvent("input[data-slugsuggest]", "focus", function(){
	var sluginput = this.getAttribute("data-slugsuggest");
	sluginput = document.querySelector(sluginput);
	if( sluginput.value && !this.value ) this.value = getSlug(sluginput.value);
});

//Tildamos checkeds por defecto
selectorMultiple("input[type='checkbox']", function(k,e){
	var estado = e[k].getAttribute("data-estado");
	if(estado == 1) e[k].setAttribute('checked', 'checked');
});

//Agregamos la propiedad selected a los option con el value deseado
selectorMultiple('select[data-selected]', function(k,e){
	var value = e[k].getAttribute('data-selected');
	var option = e[k].querySelector('option[value="'+value+'"]');
	if( option ) option.setAttribute('selected', 'selected');
});

selectorMultiple("a[href='"+window.location+"']", function(k,e){
	e[k].classList.add("active");
});

var previmgf = listefi('.previewimgfile');
if(previmgf){
	imgupload({filein: '#cover', container: '.form-upload'});
}


/* Definimos la logica que se ejecuta en una seccion especifica */
if( SITIO_SEC == 'users.create' ){
	formProccess({
		selector: "#form-usercreate",
		success: function(result){
			if( result.state != 1 ){
				var msg = "";
				var errors = {
					nickname_error: "El nickname es incorrecto",
					email_error: "El E-mail es incorrecto",
					role_error: "El id del grupo es incorrecto",
					email_duplicated: "El E-mail ya se encuentra registrado",
					nickname_duplicated: "El nickname ya se encuentra registrado"
				};
				for( acterr in errors ){
					if( in_array(acterr, result.error) ) msg += "<li>"+errors[acterr]+"</li>";
				}
				listefi.alert("<p>Error al procesar el formulario</p><ul>"+msg+"</ul>","Error");
			}else document.location = APP_ROOT+'/users';
		}
	});
}else if( SITIO_SEC == 'users.update' ){
	var passchange = document.querySelector('#passchange');
	passchange.addEventListener('submit',function(evt){
		evt.preventDefault();
		if( this.password.value == this.repass.value ){
			listefi.confirm("<p>¿Desea actualizar la contraseña de este usuario?</p><p>Esto cerrara la sesión del usuario seleccionado.</p>", function(respuesta){
				if( respuesta ){
					listefi.ajax({
						url:passchange.action,
						method:passchange.method,
						data: new FormData(passchange),
						success:function(result){
							result = JSON.parse(result);
							if( result.state == 1 ) listefi.alert("La contraseña se ha actualizado correctamente","Éxito");
							else listefi.alert("Ocurrio un error al procesar el formulario, intente de nuevo más tarde","Error");
						},
					});
				}
			});
		}
	});
}


});
