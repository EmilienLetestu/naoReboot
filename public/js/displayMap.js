/**
 * Created by Emilien on 15/02/2018.
 */

/**
 * @param id
 * @param buttonId
 */
function showMap(id,buttonId) {

    $id(id).style.visibility = "visible";
    $id(buttonId).style.visibility = "visible";
}

/**
 * @param id
 * @param buttonId
 */
function hideMap(id,buttonId) {
    $id(id).style.visibility = "hidden";
    $id(buttonId).style.visibility = "hidden";
}