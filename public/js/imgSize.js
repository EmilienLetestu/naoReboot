/**
 * Created by Emilien on 16/02/2018.
 */

/***
 * @param id
 * @returns {string}
 */
function evalSize(id) {

    var ratio = document.getElementById(id).naturalWidth/document.getElementById(id).naturalHeight;

    return ratio < 1.1 ? document.getElementById(id).style.objectFit = 'contain' : 'cover';
}