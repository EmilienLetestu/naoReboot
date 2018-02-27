/**
 * Created by Emilien on 09/02/2018.
 */

window.addEventListener('scroll',function () {
    document.getElementById('jsGenerated').style.display = "none";
    if(document.getElementById('backGenerated')){
        document.getElementById('backGenerated').style.display = "none";
    }
});


document.getElementById('nav_search_search').addEventListener('keyup',function (event) {
    search(event);
});


function searchWidth() {
    $id('search').style.width = "600px";
}

function searchBlur() {
    $id('search').style.width = "inherit";
}

/**
 * @param event
 */
function search(event){
    event.preventDefault();

    if($id("nav_search_search").value !== ""){

        var form = $id("searchForm");
        var url = "/resultat-de-la-recherche";
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if(this.readyState === 4){

                generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#5a5a5a');
            }
        };
        xmlhttp.open("POST",url,true);
        xmlhttp.send(new FormData(form));
    }
}