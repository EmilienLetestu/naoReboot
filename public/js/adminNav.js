/**
 * Created by Emilien on 12/02/2018.
 */

function offCanvas() {
   var menu = $id('adminNav');
   var trigger = $id('adminNavTrigger');
   var icon = $id('adminNavIcon');
   var large = "250px";
   var small = "0px";

   if(getStyle(menu, 'width') === "0px"){
      menu.style.width = large;
      trigger.style.left = large;
      swappClass(icon,'fa-caret-right','fa-caret-left');
   }else{
       menu.style.width = small;
       trigger.style.left = small;
       swappClass(icon,'fa-caret-left','fa-caret-right');
   }
}
