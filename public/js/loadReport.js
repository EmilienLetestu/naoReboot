/**
 * Created by Emilien on 15/02/2018.
 */

window.addEventListener('load', function () {
    loadElement(6,'card','reportCard');
    removeLoadBtn('browserLoadBtn','card',6);
    showResetBtn();
});

function showResetBtn(){
    var order = $id('filter_order');
    var bird  = $id('filter_bird');

    if(order.options[order.selectedIndex].value !== "" || bird.options[bird.selectedIndex].value !== ""){
        $id('resetFilter').style.display = screen.width <= 768 ? "block" : "inline-block";
    }

}
