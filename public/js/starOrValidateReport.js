/**
 * Created by Emilien on 14/02/2018.
 */

/**
 * @param event
 * @param id
 */
function addPoint(event,id) {

    event.preventDefault();

    var url = $id(id).getAttribute("href");
    var  xmlhttp  = new XMLHttpRequest();

    alert($id(id).text.trim());

    xmlhttp.onreadystatechange = function () {
        if(this.readyState === 4){

            if(this.responseText === 'success'){

                $id(id).innerHTML = updateScore(url,id);
            } else {
                generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
            }
        }
    };
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

/**
 * @param url
 * @param id
 * @returns {string}
 */
function updateScore(url,id){

    var getScore = $id(id).text.trim();
    var route = url.split('/');


    return route[1] === 'star' ?
        '<i class="fa fa-star-o" aria-hidden="true"></i>' + (parseInt(getScore) + 1) :
         $id(id).innerHTML = parseInt(getScore) + 1 + '/5'
    ;
}
