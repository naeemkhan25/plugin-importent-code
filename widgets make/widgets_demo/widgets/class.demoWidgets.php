<?php

class DemoWidgets extends WP_Widget{
    public function __construct()
    {
        parent::__construct(
            "demoWidgets",
            __("Demo Widgets","widgets_demo"),
            array('description'=>__("Demo Widgets Description","widgets_demo"))
        );
    }

    public function form($instance)
    {
        $title=isset($instance["title"])?$instance["title"]:__("Demo Widgets","widgets_demo");
        $latitude=isset($instance["latitude"])?$instance["latitude"]:22.3;
        $longitude=isset($instance["longitude"])?$instance["longitude"]:25.3;
        $email=isset($instance["email"])?$instance["email"]:"naeemkhan.cse@gmail.com";
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title'));?>"><?php _e("Demo Widgets","widgets_demo"); ?></label>
            <input  class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name("title"));?>" id="<?php echo esc_attr($this->get_field_id('title'));?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('latitude'));?>"><?php _e("Latitude","widgets_demo"); ?></label>
            <input  class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name("latitude"));?>" id="<?php echo esc_attr($this->get_field_id('latitude'));?>" value="<?php echo esc_attr($latitude); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('longitude'));?>"><?php _e("longitude","widgets_demo"); ?></label>
            <input  class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name("longitude"));?>" id="<?php echo esc_attr($this->get_field_id('longitude'));?>" value="<?php echo esc_attr($longitude); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('Email'));?>"><?php _e("Email","widgets_demo"); ?></label>
            <input  class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name("email"));?>" id="<?php echo esc_attr($this->get_field_id('Email'));?>" value="<?php echo esc_attr($email); ?>">
        </p>
        <?php

    }

    public function widget($args,$instance)
    {


        echo $args['before_widget'];
        if(isset($instance["title"])&&$instance["title"]!=''){
            echo $args["before_title"];
            echo apply_filters("widgets_title",$instance["title"]);
            echo $args["after_title"];
        }
            ?>
            <div class="demowidget <?php echo esc_attr($args["id"]); ?>">
                <p>Latitude:<?php echo isset($instance["latitude"])?$instance["latitude"]:'N/A';?></p>
                <p>Longitude:<?php echo isset($instance["longitude"])?$instance["longitude"]:'N/A';?></p>

            </div>
<?php
   echo $args["after_widget"];
    }
    public function update($new_instance, $old_instance)
    {
              $instance=$new_instance;
              $instance["title"]=sanitize_text_field($instance["title"]);
              if(!is_email($new_instance["email"])){
                  $instance['email']=$old_instance['email'];
              }if (!is_numeric($new_instance["latitude"])){
                  $instance["latitude"]=$old_instance['latitude'];
              }
              if (!is_numeric($new_instance["longitude"])){
                  $instance["longitude"]=$old_instance['longitude'];
              }
              return $instance;
    }
}