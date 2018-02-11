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

function show(id) {
    document.getElementById(id).style.display = "block";
}

function hide(id){
    document.getElementById(id).style.display = "none"
}