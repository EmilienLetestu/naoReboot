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

    if (confirm('Surpprimer ce compte ?')){

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
}

/**
 *
 * @param event
 * @param id
 */
function deleteAllExpired(event,id){

    event.preventDefault();
    if($class('expired').length > 0 && confirm('Attention cette action est irréversible, continuer ?')){
        var url =  $id(id).getAttribute("href");
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
            if(this.readyState === 4){
                if(this.responseText == 'success'){
                    removeExpiredFromTable();
                    generateMsg('jsGenerated','jsGeneratedMsg','Comptes supprimé','#5fdda1');
                }else{
                    generateMsg('jsGenerated','jsGeneratedMsg',this.responseText,'#ff5240');
                }
            }
        };
        xmlhttp.open("GET",url,true);
        xmlhttp.send();
    }else{
        generateMsg('jsGenerated','jsGeneratedMsg','Aucun compte à supprimer','#ff5240');
    }
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
 * @param containerId
 */
function ban(event,id,containerId){

    event.preventDefault();
    var url = $id(id).getAttribute("href");
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
               var icon = updateIcon(id,'fa-ban','fa-user-plus');
                updateClass(containerId,'banStatus','banStatus1');
               var message = icon === false ? 'Utilisateur banni' : 'Bannissement levé';
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
 *
 * @param event
 * @param id
 * @param reminderId
 * @param containerId
 */
function privilege(event,id,reminderId,containerId){

    event.preventDefault();
    var url = $id(id).getAttribute("href");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4){
            if(this.responseText == 'success'){
                updateIcon(id,'fa-angle-double-up','fa-angle-double-down');
                updateLevel(reminderId);
                updateClass(containerId,'level1','level2');
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
 * @param class1
 * @param class2
 * @returns {boolean}
 */
function updateIcon(id,class1,class2){

    var icon = $id(id).getElementsByTagName('i');
    icon[0].classList.contains(class1) ?
        swappClass(icon[0],class1,class2) :
        swappClass(icon[0],class2,class1)
    ;

    return icon[0].classList.contains(class1);
}

/**
 * update class to avoid filter conflict
 * @param id
 * @param class1
 * @param class2
 */
function updateClass(id,class1,class2){
    var element = $id(id);
    $id(id).classList.contains(class1) ?
        swappClass(element,class1,class2) :
        swappClass(element,class2,class1)
    ;
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

function removeExpiredFromTable(){

   var expired = $class('expired');

   while(expired[0]){
       expired[0].parentNode.removeChild(expired[0]);
   }
}