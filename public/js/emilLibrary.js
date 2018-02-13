/**
 * Created by Emilien on 12/02/2018.
 */
/**
 * @param element
 * @param prop
 * @returns {*}
 */
function getStyle(element, prop) {

    var cssProp = window.getComputedStyle(element,null).getPropertyValue(prop);
    if(!cssProp){

        return false
    }
    return cssProp;
}

/**
 * @param id
 * @returns {Element}
 */
function $id(id) {
    return document.getElementById(id);
}

/**
 * @param className
 * @returns {NodeList}
 */
function $class(className) {
   return document.getElementsByClassName(className);
}

/**
 * @param element
 * @param className
 */
function removeClass(element,className){
    return  element.classList.remove(className)
}

/**
 *
 * @param element
 * @param className
 */
function addClass(element,className) {
    return element.classList.add(className)
}

/**
 * @param element
 * @param removeClass
 * @param addClass
 */
function swappClass(element,removeClass,addClass){
    element.classList.remove(removeClass);
    element.classList.add(addClass);
}

/**
 * @param string
 */
function wordCount(string){
    return string.split(' ').length;
}
