/**
 * Created by Emilien on 09/02/2018.
 */
function searchWidth() {

    var isfocus = document.activeElement;

    if(document.getElementById('nav_search_search') === isfocus){
        document.getElementById('search').style.width = "600px";
        document.getElementById('nav_search_submit').style.left="49%";
    }
    else{
        document.getElementById('search').style.width = "inherit";
        document.getElementById('nav_search_submit').style.left="20%";
    }
}

function getStyle(id, prop) {
    var element = document.getElementById(id);
    var cssProp = window.getComputedStyle(element,null).getPropertyValue(prop);
    if(!cssProp){
        return false
    }
    return cssProp;
}

function show(id) {

    document.getElementById(id).style.visibility = "visible";
}

function hide(id){

    document.getElementById(id).style.visibility = "hidden";
}

function showMap(id,buttonId) {

    document.getElementById(id).style.visibility = "visible";
    document.getElementById(buttonId).style.visibility = "visible";
}

function hideMap(id,buttonId) {
    document.getElementById(id).style.visibility = "hidden";
    document.getElementById(buttonId).style.visibility = "hidden";
}