/**
 * Created by Emilien on 21/02/2018.
 */
window.addEventListener('load', function () {
    loadElement(3,'birdInfo','bird');
});

/**
 * @param id
 * @param trigger
 */
function showHideBirdMap(id,trigger) {
    var style = getStyle($id(id),'display');

    style === 'none' ?
        $id(id).style.display = "block" :
        $id(id).style.display = "none"
    ;

    style === 'none' ?
        swappClass(trigger,'fa-plus','fa-minus'):
        swappClass(trigger,'fa-minus','fa-plus')
    ;
}