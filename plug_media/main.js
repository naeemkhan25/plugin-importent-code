var frame,gframe;

;(function ($){
  $(document).ready(function (){
    $(".omb_datepikker").datepicker();
    var images_urls=$("#omb_image_urls").val();
    images_urls=images_urls?images_urls.split(';'):[];
   for(i in images_urls){
     var _images_urls=images_urls[i];
     $("#image_containers").append(`<img style="margin-right: 10px" src='${_images_urls}'/>`);
   }

    $('#ImageButtons').on("click",function(){
      gframe=wp.media({
        title:"upload Images",
        button:{
          "text":"Insert Images"
        },
        multiple:true
      });
      gframe.on("select",function (){
        var attachments=gframe.state().get("selection").toJSON();
        //console.log(attachments);
        var image_ids=[];
        var image_urls=[];

        for(i in attachments) {
          var attachment = attachments[i];
          image_ids.push(attachment.id);
          image_urls.push(attachment.sizes.thumbnail.url);
          $("#image_containers").append(`<img style="margin-right: 10px" src='${attachment.sizes.thumbnail.url}'/>`);
        }
        console.log(image_ids,image_urls)

        $("#omb_image_ids").val(image_ids.join(";"));
        $("#omb_image_urls").val(image_urls.join(";"));

         // $("#image_containers").html(`<img src='${attachments[i].sizes.thumbnail.url}'/>`);
      });

      gframe.open();
      return false;

    });
    var image_url=$("#omb_image_url").val();
    if(image_url){
      $("#image_container").html(`<img src='${image_url}'/>`);
    }
    $("#ImageButton").on("click",function (){
      if(frame){
          frame.open();
          return false;
      }
      frame=wp.media({
        title:"Upload Image",
        button:{
          "text":"Insert Image"
        },
        multiple:false
      });
      frame.on("select",function (){
        var attachment=frame.state().get("selection").first().toJSON();
        console.log(attachment);
        $("#omb_image_id").val(attachment.id);
        $("#omb_image_url").val(attachment.sizes.thumbnail.url);
        $("#image_container").html(`<img src='${attachment.sizes.thumbnail.url}'/>`);
      });
      frame.open();
      return false;
    });
  });
})(jQuery);


