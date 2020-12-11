;(function ($){
    $(document).ready(function (){
        $(".accordion-container .body").hide();
        $(".accordion-container .body").first().show();
        $(".accordion-container .title").on("click",function (){
            // $(".accordion-container .body").hide();
            //eka dek valyu
            //duplicate er jonno arek rokom code ber korthe hoibe parent
            $(this).parents(".accordion-container").find(".body").hide();
           $(this).next(".body").show("slow");
        })
        $('.main-carousel').flickity({
            // options
            cellAlign: 'left',
            contain: true
        });

    })
})(jQuery);