/**
 * Created by Emilien on 15/02/2018.
 */

window.addEventListener('scroll',function () {
    document.getElementById('restrictedAccess').style.display = "none";
});

/**
 * @param id
 * @param buttonId
 */
function showMap(id,buttonId) {
    if(loggedUser() === true ){
        $id(id).style.visibility = "visible";
        $id(buttonId).style.visibility = "visible";
    }
    else{
        hideMap(id,buttonId);
        generateMsg('restrictedAccess','restrictedMsg','Fonctionnalité réservé aux membres, se connecter?');
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