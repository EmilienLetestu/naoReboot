/**
 * Created by Emilien on 12/02/2018.
 */
function getStyle(element, prop) {

    var cssProp = window.getComputedStyle(element,null).getPropertyValue(prop);
    if(!cssProp){

        return false
    }
    return cssProp;
}

function $id(id) {
    return document.getElementById(id);
}

function $class(className) {
   return document.getElementsByClassName(className);
}

function swappClass(element,removeClass,addClass){
    element.classList.remove(removeClass);
    element.classList.add(addClass);
}
