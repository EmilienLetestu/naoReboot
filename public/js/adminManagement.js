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
            }else{
                alert(this.responseText);
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
            }else{
                $id(containerId).remove();
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
                updateIcon(id,'block','do_not_disturb_off');
            }else{
                alert(this.responseText);
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
function privilege(event,id,reminderId){

    event.preventDefault();
    var url = $id(id).getAttribute("href");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
                updateIcon(id,'arrow_upward','arrow_downward');
                updateLevel(reminderId);
            }else{
                alert(this.responseText);
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