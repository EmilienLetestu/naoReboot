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