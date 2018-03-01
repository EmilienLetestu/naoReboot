/**
 * Created by Emilien on 12/02/2018.
 */

var isScrolling;

window.addEventListener('scroll', function () {

    // Clear our timeout throughout the scroll
    window.clearTimeout( isScrolling );
    document.getElementById('adminNavTrigger').style.display = "none";

    // Set a timeout to run after scrolling ends
    isScrolling = setTimeout(function() {
        document.getElementById('adminNavTrigger').style.display = "block";
    }, 66);

}, false);

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

function activeLink(){
    var path = window.location.pathname.split('/');
    var link = path[path.length-1].split('-');
    var activeColor = "#FF9100";

    switch(link[link.length-1]) {
        case 'admin':
            document.getElementById('adminLink').style.backgroundColor = activeColor;
            break;
        case 'membres':
            document.getElementById('userLink').style.backgroundColor = activeColor;
            break;
        case 'innactifs':
            document.getElementById('unactivatedLink').style.backgroundColor = activeColor;
            break;
        case 'naturaliste':
            document.getElementById('validationLink').style.backgroundColor = activeColor;
            break;
        default:
            document.getElementById('birdLink').style.backgroundColor = activeColor;
    }
}

activeLink();


