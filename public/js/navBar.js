/**
 * Created by Emilien on 09/02/2018.
 */

window.addEventListener('scroll',function () {
    document.getElementById('jsGenerated').style.display = "none";
    if(document.getElementById('backGenerated')){
        document.getElementById('backGenerated').style.display = "none";
    }
});




function searchWidth() {
    $id('search').style.width = "600px";
    $id('nav_search_submit').style.left="49%";
}

function searchBlur() {
    $id('search').style.width = "inherit";
    $id('nav_search_submit').style.left="24%";
}