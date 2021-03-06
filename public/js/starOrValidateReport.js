/**
 * Created by Emilien on 14/02/2018.
 */

/**
 * @param event
 * @param id
 */
function addPoint(event,id) {

    event.preventDefault();

    if(loggedUser() === true){

        var url = $id(id).getAttribute("href");
        var  xmlhttp  = new XMLHttpRequest();

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

    } else {
        generateMsg('jsGenerated','jsGeneratedMsg','Fonctionnalité réservé aux membres, se connecter?','#ff5240');
    }
}

/**
 * @param event
 * @param id
 * @param containerId
 */
function addValidation(event,id,containerId) {
    event.preventDefault();

    if(loggedUser() === true){

        var url = $id(id).getAttribute("href");
        var  xmlhttp  = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if(this.readyState === 4){

                if(this.responseText === 'success'){

                    $id(id).innerHTML = updateScore(url,id);
                    parseInt($id(id).innerHTML) === 5 ?
                        validateAndPublish(containerId) :
                        generateMsg('jsGenerated','jsGeneratedMsg','Validation ajoutée','#5fdda1')
                    ;

                } else {
                    generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
                }
            }
        };

        xmlhttp.open("GET",url,true);
        xmlhttp.send();

    } else {
        generateMsg('jsGenerated','jsGeneratedMsg','Fonctionnalité réservé aux membres, se connecter?','#ff5240');
    }
}

function deleteReport(event,id,cardId){

    event.preventDefault();

    if(confirm('Supprimer cette observation ?')){
        var url = $id(id).getAttribute("href");
        var  xmlhttp  = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if(this.readyState === 4){

                if(this.responseText == 'success'){

                    $id(cardId).remove();
                    generateMsg('jsGenerated','jsGeneratedMsg','Observation Supprimée','#5fdda1');

                } else {

                    generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
                }
            }
        };

        xmlhttp.open("GET",url,true);
        xmlhttp.send();
    }
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

/**
 * @param containerId
 */
function validateAndPublish(containerId){
    generateMsg('jsGenerated','jsGeneratedMsg','Observation validée et publiée','#5fdda1');
    $id(containerId).remove();
}

/**
 * @param id
 */
function checkAndHideFlash(id){
    if($id(id) !== null){
       $id.style.display = "none";
    }
}
