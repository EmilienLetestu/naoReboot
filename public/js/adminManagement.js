/**
 * Created by Emilien on 14/02/2018.
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

function privilege(event,id){

    event.preventDefault();
    var url = $id(id).getAttribute("href");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
                updateIcon(id,'arrow_upward','arrow_downward');
            }else{
                alert(this.responseText);
            }
        }
    };
    xmlhttp.open("GET",url,true);
    xmlhttp.send();

}

function updateIcon(id,state1,state2){
    var icon = $id(id).getElementsByTagName('i');
    var state = icon[0].innerText.trim() == state1 ? state2 : state1;

    return icon[0].innerText = state;

}