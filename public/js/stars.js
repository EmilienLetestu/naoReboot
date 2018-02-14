/**
 * Created by Emilien on 14/02/2018.
 */
function addStar(id) {
    var url = $id(id).getAttribute("href");
    var  xmlhttp  = new XMLHttpRequest();
    var getScore = $id(id).text.trim();
    xmlhttp.onreadystatechange = function () {
        if(this.readyState === 4){
            if(this.responseText === 'success'){
                $id(id).innerHTML = '<i class="fa fa-star-o" aria-hidden="true"></i>'+(parseInt(getScore)+ 1);
            }
            else{
                alert(this.responseText);
            }
        }
    };
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
}
