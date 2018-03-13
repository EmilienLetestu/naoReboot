/**
 * Created by Emilien on 09/02/2018.
 */

window.addEventListener('scroll',function () {
    document.getElementById('jsGenerated').style.display = "none";
    document.getElementById('searchLinks').style.display = "none";

    if(document.getElementById('backGenerated')){
        document.getElementById('backGenerated').style.display = "none";
    }
});

if(screen.width > 768){
    document.getElementById('search').addEventListener('mouseenter',function () {
        searchWidth();
    });

    document.getElementById('nav_search_search').addEventListener('blur',function () {
       searchBlur();
    });

    window.addEventListener('scroll',function () {
        searchBlur();
    });
}

if(screen.width < 768){


    window.addEventListener('scroll',function (){
        mobileSearch("none");
    });

    document.getElementById('searchTrigger').addEventListener('touchstart',function () {
        mobileSearch("inline-block");
    });


    if(document.getElementById('accountBadge')){

        window.addEventListener('scroll',function (){
            hide('dashboard');
        });

        document.getElementById('accountBadge').addEventListener('touchstart',function () {
            getStyle($id('dashboard'),'display') === 'hidden' ?
                show('dashboard') : hide('dashboard');
        });
    }
}

function searchWidth() {
    $id('search').style.width = "600px";
    $id('nav_search_search').setAttribute("placeholder","espèce,région...");
}

/**
 *
 * @param style
 */
function mobileSearch(style) {
    $id('nav_search_search').style.display = style;
}

function searchBlur() {
    $id('search').style.width = "inherit";
    $id('nav_search_search').removeAttribute("placeholder");
}

/**
 * @param array
 */
function search(array) {

    $id('nav_search_search').addEventListener('keyup',function () {
        var input = $id('nav_search_search');
        var search = input.value.toLowerCase();

        var match = [];
        for(var i = 0; i < array.length; i++){
            var birdFr    = array[i]['birdFr'].slice(0,search.length);
            var birdLatin = array[i]['birdLatin'].slice(0,search.length);
            var breed     = array[i]['breed'].slice(0,search.length);
            var birdGroup = array[i]['birdGroup'].slice(0,search.length);
            var city      = array[i]['location1'].slice(0,search.length);
            var shire     = array[i]['location2'].slice(0,search.length);

            if(birdFr === search || birdLatin === search || city === search || shire === search || breed === search || birdGroup === search ){
                match.push({
                    latin: array[i]['birdLatin'].trim().replace(/\s+/g, '-'),
                    fr:  array[i]['birdFr'],
                    id: array[i]['birdId']
                })
            ;}
        }

        var results   = removeDuplicate(match);
        var links     = createHistoricLinks(results);
        var title     = '<h3>RESULTAT DE VOTRE RECHERCHE POUR : <span id="searchQuery">' + search.toUpperCase() +' </span></h3>';
        var matchless = '<p class="searchResults">Désolé nous n’avons pas trouvé de résultat correspondant à votre recherche.</p>';

        results.length === 0 || search.length === 0 ?
            generateMsg('searchLinks','searchLinks',matchless,'#838383'):
            generateMsg('searchLinks','searchLinks',title + links,'#838383')
        ;
    });
}