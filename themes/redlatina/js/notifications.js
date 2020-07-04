/*
 *API de Notificaciones Debred 2019 v.1 
 * Esta API a sido desarrollada por el equipo de Debred
 * 
 */
class raychelNotify{

    static createDiv(){
        var cont = document.createElement('div')
        cont.setAttribute('class','rc-notify')
        return cont
    }
    static textDiv(text){
        var cont = this.createDiv()
        var txt = document.createTextNode(text)
        cont.appendChild(txt)
        return cont
    }
    static logicAttributes(firstPosition, secondPosition, cont, type) {
        if( (firstPosition == "center" && secondPosition == "right") || (firstPosition == "right" && secondPosition == "center") )
            cont.setAttribute('class', 'rc-notify rc-CR '+type)
        else if ( (firstPosition == "bottom" && secondPosition == "right") || (firstPosition == "right" && secondPosition == "bottom") )
            cont.setAttribute('class', 'rc-notify rc-BR '+type)
        else if ( (firstPosition == "top" && secondPosition == "left") || (firstPosition == "left" && secondPosition == "top") )
            cont.setAttribute('class', 'rc-notify rc-TL '+type)
        else if ( (firstPosition == "center" && secondPosition == "left") || (firstPosition == "left" && secondPosition == "center") )
            cont.setAttribute('class', 'rc-notify rc-CL '+type)
        else if ( (firstPosition == "bottom" && secondPosition == "left") || (firstPosition == "left" && secondPosition == "botton") )
            cont.setAttribute('class', 'rc-notify rc-BL '+type)
        else if(firstPosition == "center" && secondPosition == "center")
            cont.setAttribute('class', 'rc-notify rc-CC '+type)
        else cont.setAttribute('class', 'rc-notify rc-TR ' + type)
    }
    static danger(text,firstPosition,secondPosition){
        var cont = this.textDiv(text)
        var icon = document.createElement('span') 
        var type = "rc-danger"
        icon.setAttribute('class','icon-warning')
        cont.appendChild(icon) 
        this.logicAttributes(firstPosition, secondPosition, cont,type)
        cont.setAttribute('data-state', 'opened')
        setTimeout(function () { cont.setAttribute('data-state', 'closed') }, 8000)
        cont.addEventListener('click',function(){
            document.body.removeChild(cont)
        })
        return document.body.appendChild(cont)
    }
    static success(text,firstPosition,secondPosition) {
        var cont = this.textDiv(text)
        var icon = document.createElement('span')
        var type = "rc-success"
        icon.setAttribute('class','icon-check')
        cont.appendChild(icon)
        cont.setAttribute('data-state', 'opened')
        this.logicAttributes(firstPosition,secondPosition,cont,type)
        setTimeout(function () { cont.setAttribute('data-state', 'closed') }, 8000)
        cont.addEventListener('click',function(){
            document.body.removeChild(cont)
        })
        return document.body.appendChild(cont)
    }
    static warning(text,firstPosition,secondPosition) {
        var cont = this.textDiv(text)
        var icon = document.createElement('span')
        var type = "rc-warning"
        icon.setAttribute('class','icon-eye')
        cont.appendChild(icon)
        this.logicAttributes(firstPosition, secondPosition, cont, type)
        cont.setAttribute('data-state', 'opened')
        setTimeout(function () { cont.setAttribute('data-state', 'closed') }, 8000)
        cont.addEventListener('click',function(){
            document.body.removeChild(cont)
        })
        return document.body.appendChild(cont)
    }
    static info(text, firstPosition, secondPosition) {
        var cont = this.textDiv(text)
        var icon = document.createElement('span')
        var type = "rc-info"
        icon.setAttribute('class', 'icon-info-circle')
        cont.appendChild(icon)
        this.logicAttributes(firstPosition, secondPosition, cont, type)
        cont.setAttribute('data-state', 'opened')
        setTimeout(function () { cont.setAttribute('data-state', 'closed') }, 8000)
        cont.addEventListener('click', function () {
            document.body.removeChild(cont)
        })
        return document.body.appendChild(cont)
    }
}