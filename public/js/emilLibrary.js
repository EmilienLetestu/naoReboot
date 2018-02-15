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
 * @param id
 */
function show(id) {
    getStyle($id(id),'visibility') === 'hidden' ?
        $id(id).style.visibility = "visible":
        $id(id).style.display    = "flex"
    ;
}

/**
 * @param id
 */
function hide(id){

    $id(id).style.visibility = "hidden";
}

/**
 * @param string
 */
function wordCount(string){
    var trimmed = string.trim();
    return trimmed.split(' ').length;
}

/**
 * @param limit
 * @param targetClass
 * @param id
 */
function loadElement(limit,targetClass,id) {
    var total  = $class(targetClass).length;
    for(var i=0; i < total ; i++){
        if(i < limit){
            $id(id+''+[i+1]+'').style.display = 'block';
        }
    }
}

/**
 * @param btn
 * @param targetClass
 * @param id
 */
function loadMore(btn,targetClass,id){
    var total  = $class(targetClass).length;
    var newLimit = parseInt(btn.value) + 6;
    loadElement(newLimit,targetClass,id);
    btn.value = newLimit;
    total <= newLimit ? btn.remove() : null;
}
