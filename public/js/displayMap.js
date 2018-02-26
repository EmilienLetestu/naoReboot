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

    var imgId = "img" + loopIndex;
    if(loggedUser() === true ){
        initReportMap(loopIndex);
        $id(id).style.visibility = "visible";
        $id(buttonId).style.visibility = "visible";
        $id(imgId).style.visibility = "hidden";

    }
    else{
        generateMsg('jsGenerated','jsGeneratedMsg','Fonctionnalité réservé aux membres, se connecter?','#ff5240');
        hideMap(id,buttonId,imgId);
    }
}

/**
 * @param id
 * @param buttonId
 * @param loopIndex
 */
function hideMap(id,buttonId,loopIndex) {
    var imgId = "img" + loopIndex;
    $id(imgId).style.visibility = "visible";
    $id(id).style.visibility = "hidden";
    $id(buttonId).style.visibility = "hidden";
}

if(screen.width < 768){


    /**
     * @param id
     * @param trigger
     */
    function mobileCard(id,trigger){

        var num = $id(id).id.match(/\d+/);
        var map = 'reportMap' + num;
        var hidden = $id(id).getElementsByClassName('mobileHidden');
        var style = getStyle(hidden[0],"display");

        if(style === "block"){
            hidden[0].style.display = "none";
            $id(map).style.visibility = "hidden";
        }else{
            hidden[0].style.display = "block";
        }

        style === "block" ?
            swappClass(trigger,'fa-caret-square-o-down','fa-caret-square-o-right'):
            swappClass(trigger,'fa-caret-square-o-right','fa-caret-square-o-down')
        ;
    }
}
