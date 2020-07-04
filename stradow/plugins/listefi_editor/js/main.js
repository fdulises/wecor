var contcard = "";
contcard = '<div class="card-header"><button type="button" class="mw-close">&times;</button><h4>Insertar Imagen</h4></div>';

contcard += "<div class='card-frame cop-main'><button type='button' class='btn btn-default btn-block size-l op-up'>Subir imagen</button><button type='button' class='btn btn-default btn-block size-l op-url'>Añadir desde URL</button></div>";

contcard += "<form class='card-frame cop-up hide'><input type='file' class='hide' name='newup' accept='image/*'><div><progress id='progreso' value='0' max='1' class='li-progress'></progress></div><button type='button' class='btn btn-default btn-block size-l'>Seleccionar imagen</button></form>";

contcard += "<div class='card-frame cop-sel hide'><button type='button' class='btn btn-default btn-block size-l'>Seleccionar</button></div>";

contcard += "<form class='card-frame cop-url hide'><input type='text' name='urlimg' class='form-in' placeholder='URL de la imagen'><button type='button' class='btn btn-default btn-block'>Añadir desde URL</button></form>";

var acont = document.createElement("div");
acont.setAttribute('class', 'container cont-600 mg-sec');
acont.addEventListener('click',function(e){e.stopPropagation();});
acont.innerHTML = contcard;

var copmain = acont.querySelector(".cop-main");
var copup = acont.querySelector(".cop-up");
var copurl = acont.querySelector(".cop-url");

copurl.querySelector('button').addEventListener("click", function(){
	adim.hide();
	var url = copurl.querySelector('input').value;
	url = "<p><img src='"+url+"'></p>";
	myeditor.editable.focus();
	(function(document){document.execCommand('insertHTML',false,url)})(document);
});

//Boton subida de archivo
var coupfile = copup.querySelector('input');
copup.querySelector('button').addEventListener("click", function(){
	coupfile.click();
});
coupfile.addEventListener("change", function(){
	var data = new FormData(copup);
	var progreso = document.querySelector("#progreso");
	progreso.value = 0;
	//var f = new Date();

	//data.append('subdir', 'post/'+f.getFullYear()+'/'+(f.getMonth()+1));
	data.append('subdir', 'post');
	listefi.ajax({
		url: APP_ROOT+'/media/upload', method: 'post',
		data: data,
		loadstart: function(){
			progreso.value = 0;
		},
		load: function(){
			progreso.value = 1;
		},
		uploadProgress: function(evt){
			if(evt.lengthComputable) progreso.value = evt.loaded/evt.total;
			else console.log("Tamaño desconocido");
		},
		success: function(result){
			result = JSON.parse(result);
			if( result.state == 1 ){
				var url = result.data.url;
				url = "<p><img src='"+url+"'></p>";
				adim.hide();
				myeditor.editable.focus();
				try{(document.execCommand('insertHTML',false,url))();}catch(e){};

			}else listefi.alert("Se produjo un error al intentar procesar lo solicitado", "Error");
		}
	});
});

acont.querySelector(".op-up").addEventListener("click", function(){
	copup.classList.remove('hide');
	copmain.classList.add('hide');
});
acont.querySelector(".op-url").addEventListener("click", function(){
	copurl.classList.remove('hide');
	copmain.classList.add('hide');
});

var adim = listefi.lightbox();
adim.addContent(acont);
acont.querySelector(".mw-close").addEventListener("click", adim.hide);


liweditor.inp.img = {
	class: 'btn', type: 'button', event: 'click',
	action: function(){
		copmain.classList.remove('hide');

		copup.classList.add('hide');
		copurl.classList.add('hide');

		adim.show();
	},
	title: 'Insertar Imágen',
	html: '<span class="icon-image"></span>'
};

var myeditor = liweditor({
	selector: ".contenteditor",
	toolbar: ["bold", "italic", "underline", "formatblock", "img", "justifyleft", "justifycenter", "justifyright", "link", "orderedlist", "unorderedlist", "unlink", "quote", "code", "changeview", "fullscreen"]
});
