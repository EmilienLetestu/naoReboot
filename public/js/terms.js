/**
 * Created by Emilien on 18/02/2018.
 */
/**
 * @param anchor
 * @returns {string}
 */
function showAnchor(anchor) {
   var termNum = anchor.getAttribute("href").match(/\d+/);
   var article = $class("termArticle");

   return  article[termNum - 1].style.display = "block";
}

/**
 * @param title
 * @returns {string}
 */
function showHideArticle(title) {

   var articleNum = title.innerHTML.match(/\d+/);
   var article    = $class("termArticle")[articleNum - 1];
   var style = getStyle(article,"display");

   return style === "none" ?
       article.style.display = "block" :
       article.style.display = "none"
   ;
}