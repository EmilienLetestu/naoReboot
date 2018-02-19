/**
 * Created by Emilien on 15/02/2018.
 */

window.addEventListener('scroll',function () {
    document.getElementById('jsGenerated').style.display = "none";
});

/**
 * @param id
 * @param buttonId
 * @param loopIndex
 */
function showMap(id,buttonId,loopIndex) {
    if(loggedUser() === true ){
        initReportMap(loopIndex);
        $id(id).style.visibility = "visible";
        $id(buttonId).style.visibility = "visible";
    }
    else{
        hideMap(id,buttonId);
        generateMsg('jsGenerated','jsGeneratedMsg','Fonctionnalité réservé aux membres, se connecter?','#ff5240');
    }
}

/**
 * @param id
 * @param buttonId
 */
function hideMap(id,buttonId) {
    $id(id).style.visibility = "hidden";
    $id(buttonId).style.visibility = "hidden";
}
