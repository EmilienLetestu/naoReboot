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



if(screen.width > 768){
    document.getElementById('search').addEventListener('mouseenter',function () {
        searchWidth();
    });

    document.getElementById('search').addEventListener('mouseleave',function () {
       searchBlur();
    });
}

if(screen.width < 768){

    window.addEventListener('scroll',function (){
        mobileSearch("none");
        hide('dashboard');
    });

    document.getElementById('searchTrigger').addEventListener('touchstart',function () {
        mobileSearch("inline-block");
    });

    document.getElementById('accountBadge').addEventListener('touchstart',function () {
        getStyle($id('dashboard'),'display') === 'hidden' ?
        show('dashboard') : hide('dashboard');
    });
}

function searchWidth() {
    $id('search').style.width = "600px";
}

function mobileSearch(style) {
    $id('nav_search_search').style.display = style;
}

function searchBlur() {
    $id('search').style.width = "inherit";
}


/**
 * @param event
 */
function search(event){

    event.preventDefault();

    if($id("nav_search_search").value === ""){
        $id('jsGenerated').style.display = "none";
    }

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