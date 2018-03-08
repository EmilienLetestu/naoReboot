/**
 * Created by Emilien on 15/02/2018.
 */

window.addEventListener('load', function () {
    loadElement(6,'card','reportCard');
    removeLoadBtn('browserLoadBtn','card',6);

    if(window.location.pathname === "/observations/en-attente-de-validation" ){
        showResetBtn("unvalidated_filter_order","unvalidated_filter_bird");
    }

    if(window.location.pathname === "/observations/valide" ){
        showResetBtn("filter_order","filter_bird");
    }
});


function showResetBtn(filter1, filter2){

    var order = $id(filter1);
    var bird  = $id(filter2);

    if(order.options[order.selectedIndex].value !== "" || bird.options[bird.selectedIndex].value !== ""){
        $id('resetFilter').style.display = screen.width <= 768 ? "block" : "inline-block";
    }

}
