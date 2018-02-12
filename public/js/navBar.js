/**
 * Created by Emilien on 09/02/2018.
 */

function searchWidth() {

    var isfocus = document.activeElement;

    if($id('nav_search_search') === isfocus){

        $id('search').style.width = "600px";
        $id('nav_search_submit').style.left="49%";
    } else {
       $id('search').style.width = "inherit";
       $id('nav_search_submit').style.left="20%";
    }
}

function show(id) {

    $id(id).style.visibility = "visible";
}

function hide(id){

    $id(id).style.visibility = "hidden";
}

function showMap(id,buttonId) {

    $id(id).style.visibility = "visible";
    $id(buttonId).style.visibility = "visible";
}

function hideMap(id,buttonId) {
    $id(id).style.visibility = "hidden";
    $id(buttonId).style.visibility = "hidden";
}