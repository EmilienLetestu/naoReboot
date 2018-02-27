/**
 * Created by Emilien on 15/02/2018.
 */

window.addEventListener('load', function () {
    loadElement(4,'memberInfo','member');
    removeLoadBtn('memberLoadBtn','memberInfo',4);
});

function memberFilter() {
    var select = $id("memberFilter");
    var option = select.options[select.selectedIndex].value;
    select.options[0].innerHTML = "retirer les filtres";
    var classes = $class("memberInfo");
    var limit = !$id("memberLoadBtn") ? classes.length : $id("memberLoadBtn").value;

    for (var i = 0; i < limit; i++) {

        if(getStyle(classes[i],"display") === "block"){
            classes[i].classList.contains(option) ?
                classes[i].style.display = "block" :
                classes[i].style.display = "none"
            ;
        }

        if(option === " "){
            classes[i].style.display = "block";
        }
    }
}