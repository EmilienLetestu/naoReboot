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

        style === "none" ?
            swappClass(trigger,'fa-caret-square-o-down','fa-caret-square-o-right'):
            swappClass(trigger,'fa-caret-square-o-right','fa-caret-square-o-down')
        ;
    }
}
