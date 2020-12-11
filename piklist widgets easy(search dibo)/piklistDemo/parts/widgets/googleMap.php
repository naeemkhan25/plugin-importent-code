
<?php
/*
Title: GoogleMap
Description: A description of what my widget does
*/
?>
<?php echo $before_widget; ?>

<div class="mapouter">
    <div class="gmap_canvas">
        <iframe width="300" height="200" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $settings['place']; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    </div>
    <style>
        .mapouter{position:relative;text-align:right;height:500px;width:600px;}
        .gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}
    </style>
</div>
<?php echo $after_widget; ?>