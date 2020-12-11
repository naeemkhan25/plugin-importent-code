;(function ($){
 $(document).ready(function (){
     $('body').on('click',"#notice_ninja .notice-dismiss",function (){
         console.log("daligation");
         setCookie("nn-close",1,60);
     })
 })
})(jQuery);

function setCookie(cookieName,cookieValue,expiryInSeconds){
    var expiry=new Date();
    expiry.setTime(expiry.getTime() + 1000 * expiryInSeconds);
    document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expiry.toGMTString() + "; path=/";

}