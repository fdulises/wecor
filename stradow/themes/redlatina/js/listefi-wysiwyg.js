//Definimos el contstructor
listefi.wysiwyg = function( opt ){
	if(typeof opt != "object") opt = {selector:opt};
	var w = {container: document.querySelector(opt.selector)};
	w.container.classList.add('ls-wcontainer')
	w.textarea = w.container.querySelector("textarea");

	//Insertamos el contenteditable y ocultamos el textarea
	w.textarea.setAttribute("data-state", "hidden");
	w.container.insertBefore(listefi.wysiwyg.createEditor(w.textarea.value), w.textarea);
	w.editable = w.container.querySelector(".ls-weditor");
	document.execCommand("enableObjectResizing", false, false);
	document.execCommand("styleWithCSS", false, true);

	//Generamos y agregamos el toolbar
	var toolinps = [], defaulttool = ["bold", "italic","strike", "underline", "eraser", "formatblock", "img", "justifyleft", "justifycenter", "justifyright", "link", "orderedlist", "unorderedlist", "unlink", "quote", "code", "changeview", "fullscreen"];
	toolinps = opt.toolbar || defaulttool;
	w.container.insertBefore(listefi.wysiwyg.createToolbar(w, toolinps), w.editable);

	//Pegar en texto plano
	/*w.container.addEventListener("paste", function(e) {
		e.preventDefault();
		var text = e.clipboardData.getData("text/plain");
		document.execCommand("insertTEXT", false, text);
	}); */

	//Definimos funcionamiento del metodo update
	w.update = function(){if( w.textarea.getAttribute("data-state") == "hidden" ) w.textarea.value = w.editable.innerHTML;};

	return w;
};
//Generamos el contenteditable
listefi.wysiwyg.createEditor = function(html){
	var editor = document.createElement("div");
	editor.setAttribute("contenteditable", "true");
	editor.setAttribute("class", "ls-weditor");
	editor.setAttribute("data-state", "showed");
	editor.innerHTML = html ? html : "<p>&nbsp</p>";
	return editor;
};
//Generamos el toolbar
listefi.wysiwyg.createToolbar = function(w, t){
	var el = document.createElement("div");
	el.setAttribute("class", "ls-toolbar");
	t.forEach(function(k){
		var v = listefi.wysiwyg.inp[k];
		var ael = document.createElement(v.type);
		if( v.type == "button" ) ael.setAttribute("type", "button");
		ael.setAttribute("title", v.title);
		ael.setAttribute("class", v.class);
		ael.innerHTML = v.html;
		ael.addEventListener(v.event, function(){v.action(w,this)});
		el.appendChild(ael);
	});

	return el;
};
//Escapar HTML
listefi.wysiwyg.escapeHTML = function(h) {
    return document.createElement('div').appendChild(document.createTextNode(h)).parentNode.innerHTML;
}
//Definimos las caracteristicas de los inputs
listefi.wysiwyg.inp = {
	bold: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('bold',false,'');},
		title: 'Negrita',
		html: '<span class="icon-bold"></span>'
	},
	italic: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('italic',false,'');},
		title: 'Cursiva',
		html: '<span class="icon-italic"></span>'
	},
	strike: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('strikethrough',false,'');},
		title: 'Techado',
		html: '<span class="icon-strikethrough"></span>'
	},
	underline: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('underline',false,'');},
		title: 'Subrayado',
		html: '<span class="icon-underline"></span>'
	},
	eraser: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('removeFormat',false,'');},
		title: 'Borrar Formato',
		html: '<span class="icon-eraser"></span>'
	},
	formatblock: {
		class: 'form-in', type: 'select', event: 'change',
		action: function(w, sel){
			if( sel.value == "<p>" ) document.execCommand('insertParagraph',"");
			else document.execCommand('formatBlock',false,sel.value);
			sel.value = "";
		},
		title: 'Añadir formato',
		html: '<option value="">Añadir Formato</option>'+
		'<option value="<p>">Parrafo</option>'+
		'<option value="<h1>">Encabezado #1</option>'+
		'<option value="<h2>">Encabezado #2</option>'+
		'<option value="<h3>">Encabezado #3</option>'+
		'<option value="<h4>">Encabezado #4</option>'+
		'<option value="<h5>">Encabezado #5</option>'+
		'<option value="<h6>">Encabezado #6</option>'
	},
	img: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){
			var selection = document.getSelection().toString();
			if( selection ) document.execCommand('insertImage',false,selection);
			else{
				var url = prompt("Ingrese URL de la imagen");
				url = "<p><img src="+url+"></p>";
				document.execCommand('insertHTML',false,url);
			}
		},
		title: 'Insertar Imágen',
		html: '<span class="icon-image"></span>'
	},
	justifyleft: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('justifyLeft')},
		title: 'Alinear a la izquierda',
		html: '<span class="icon-align-left"></span>'
	},
	justifycenter: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('justifyCenter')},
		title: 'Centrar',
		html: '<span class="icon-align-center"></span>'
	},
	justifyright: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('justifyRight')},
		title: 'Alinear a la derecha',
		html: '<span class="icon-align-right"></span>'
	},
	link: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){
			var selection = document.getSelection().toString(), url;
			if( listefi.validURL(selection) ) url = selection;
			else url = prompt("Ingrese URL del enlace");

			if( !selection ){
				url = '<a href="'+url+'">'+url+'</a>';
				document.execCommand('insertHTML',false,url);
			}else document.execCommand('createLink',false,url);
		},
		title: 'Insertar Enlace',
		html: '<span class="icon-link"></span>'
	},
	orderedlist: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('insertOrderedList',false,'');},
		title: 'Insertar Lista Ordenada',
		html: '<span class="icon-list-ol"></span>'
	},
	unorderedlist: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('insertUnorderedList',false,'');},
		title: 'Insertar Lista No Ordenada',
		html: '<span class="icon-list-ul"></span>'
	},
	unlink: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('unlink',false,'');},
		title: 'Quitar enlace',
		html: '<span class="icon-unlink"></span>'
	},
	quote: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){document.execCommand('formatBlock',false,"<blockquote>");},
		title: 'Insertar Cita',
		html: '<span class="icon-quote-left"></span>'
	},
	code: {
		class: 'btn', type: 'button', event: 'click',
		action: function(){
			var selection = document.getSelection().toString(),
			hcode = selection ? listefi.wysiwyg.escapeHTML(selection) : '<br>';
			hcode = "<pre><code>"+hcode+"</code></pre><p></p>";
			document.execCommand('insertHTML',false,hcode);
		},
		title: 'Insertar Código',
		html: '<span class="icon-code"></span>'
	},
	changeview: {
		class: 'btn', type: 'button', event: 'click',
		action: function(w){
			if( w.textarea.getAttribute("data-state") == "hidden" ){
				w.textarea.value = w.editable.innerHTML;
				w.textarea.setAttribute("data-state", "showed");
				w.editable.setAttribute("data-state", "hidden");
			}else{
				w.editable.innerHTML = w.textarea.value;
				w.textarea.setAttribute("data-state", "hidden");
				w.editable.setAttribute("data-state", "showed");
			}
		},
		title: 'Cambiar vista',
		html: '<span class="icon-eye"></span>'
	},
	fullscreen: {
		class: 'btn', type: 'button', event: 'click',
		action: function(w){
			if( w.container.getAttribute("data-state") ){
				w.container.removeAttribute("data-state");
			}else w.container.setAttribute("data-state", "full");
		},
		title: 'Expandir/Contraer editor',
		html: '<span class="icon-arrows-alt"></span>'
	}
};
