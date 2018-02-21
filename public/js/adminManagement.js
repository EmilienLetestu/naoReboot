/**
 * Created by Emilien on 14/02/2018.
 */

/**
 * @param event
 * @param id
 * @param containerId
 */
function deleteEntity(event,id,containerId){

    event.preventDefault();
    var url = $id(id).getAttribute("href");
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
                $id(containerId).remove();
                generateMsg('jsGenerated','jsGeneratedMsg','Compte supprimé','#5fdda1');
            }else{
                generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
            }
        }
    };
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

/**
 * @param event
 * @param id
 * @param containerId
 */
function roleRequest(event,id,containerId){
    event.preventDefault();
    var url = $id(id).getAttribute("href");
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
                $id(containerId).remove();
                generateMsg('jsGenerated','jsGeneratedMsg','Demande de compte naturaliste accepté','#5fdda1');
            }else{
                generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
            }
        }
    };
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

/**
 * @param event
 * @param id
 */
function ban(event,id){

    event.preventDefault();
    var url = $id(id).getAttribute("href");
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
               var icon = updateIcon(id,'block','do_not_disturb_off');
               var message = icon === 'do_not_disturb_off' ? 'Utilisateur banni' : 'Bannissement levé';
               generateMsg('jsGenerated','jsGeneratedMsg',message,'#5fdda1');
            }else{
                generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
            }
        }
    };
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}

/**
 * @param event
 * @param id
 * @param reminderId
 */
function privilege(event,id,reminderId){

    event.preventDefault();
    var url = $id(id).getAttribute("href");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
                updateIcon(id,'arrow_upward','arrow_downward');
                updateLevel(reminderId);
                generateMsg('jsGenerated','jsGeneratedMsg','Role modifié avec succès','#5fdda1');
            }else{
                generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
            }
        }
    };
    xmlhttp.open("GET",url,true);
    xmlhttp.send();

}

/**
 * @param id
 * @param state1
 * @param state2
 * @returns {*}
 */
function updateIcon(id,state1,state2){

    var icon = $id(id).getElementsByTagName('i');
    var state = icon[0].innerText.trim() == state1 ? state2 : state1;

    return icon[0].innerText = state;
}

/**
 * @param id
 * @returns {string}
 */
function updateLevel(id){
    var account = $id(id);
    var level = account.innerHTML.trim() === 'Amateur' ? 'Naturaliste':'Amateur';

    return account.innerHTML = level;
}