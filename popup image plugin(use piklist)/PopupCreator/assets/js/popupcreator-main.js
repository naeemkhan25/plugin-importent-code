
;(function ($){
    var exitModal=[];
    var displaydelay=[];
    var displayexit=false;
    $(document).ready(function (){
        PlainModal.closeByEscKey = false
        PlainModal.closeByOverlay = false
        var modales=document.querySelectorAll(".modal-content");

        for(i=0;i<modales.length;i++){
            var content=modales[i];
           var modal= new PlainModal(content);
            modal.closeButton = content.querySelector('.close-button');
            var delay=content.getAttribute("data-delay");

            if(content.getAttribute('data-exit')==1){
                if(delay>0){
                    displaydelay.push({modal:modal,delay:delay});
                }
                else{
                    modal.open();
                }

            }else{
                exitModal.push(modal);
            }
        }
        for(i in displaydelay){
            setTimeout(function (i){
                console.log(i);
               displaydelay[i].modal.open();
            },displaydelay[i].delay,i);
        }
    });

                window.onbeforeunload = function () {
                    if (!displayexit) {
                        for (i in exitModal) {
                            exitModal[i].open();
                        }
                        displayexit = true;
                        return true;
                    }
                }


})(jQuery);
