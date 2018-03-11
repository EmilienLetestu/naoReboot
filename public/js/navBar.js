/**
 * Created by Emilien on 09/02/2018.
 */

window.addEventListener('scroll',function () {
    document.getElementById('jsGenerated').style.display = "none";
    if(document.getElementById('backGenerated')){
        document.getElementById('backGenerated').style.display = "none";
    }
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

function search(array) {

    $id('nav_search_search').addEventListener('keyup',function () {
        var input = $id('nav_search_search');
        var search = input.value;
        var compare = search.charAt(search.length - 1);
        var match = [];
        for(var i = 0; i < array.length; i++){
            var birdFr    = array[i]['birdFr'].charAt(search.length - 1);
            var birdLatin = array[i]['birdLatin'].charAt(search.length - 1);
            var location  = array[i]['location'].charAt(search.length - 1);
            if(birdFr === compare || birdLatin === compare || location === compare){
                match.push({
                    latin: x[i]['birdLatin'].trim().replace(/\s+/g, '-').toLowerCase(),
                    fr:  x[i]['birdFr'],
                    id: x[i]['birdId']
                });
            }
        }
        var results = removeDuplicate(match);
        var  links = createHistoricLinks(results);
        if(links !== null){
            generateMsg('jsGenerated','jsGeneratedMsg',links,'#838383');
        }
    });

}