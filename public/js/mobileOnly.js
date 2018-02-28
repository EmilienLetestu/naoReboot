/**
 * Created by Emilien on 20/02/2018.
 */
if(screen.width < 768){

    /**
     * @param id
     * @param trigger
     */
    function footerList(id,trigger){

        var list = $id(id).getElementsByTagName('li');
        var style = getStyle(list[1],"display");
        for(var i = 1; i < list.length; i++) {
            style === "block" ?
                list[i].style.display = "none" :
                list[i].style.display = "block"
            ;
        }

        style === "block" ?
            swappClass(trigger,'fa-caret-down','fa-caret-right'):
            swappClass(trigger,'fa-caret-right','fa-caret-down')
        ;
    }
}
