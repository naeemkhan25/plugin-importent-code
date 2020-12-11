<?php

class MediaWidgets extends WP_Widget {
    public function __construct()
    {
        parent::__construct(
           "mediaWidgets",
            __("Media Widgets","media-widgets"),
            array(__("Media widgets description","media-widgets"))
        );
    }
    public function form($instance)
    {
        $title=isset($instance["title"])?$instance["title"]:__("media Widgets","media-widgets");
        if(!isset($instance['url'])){
            $instance['url']='';
        }
        if(!isset($instance['image'])){
            $instance['image']='';
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','demowidget'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Image:','demowidget'); ?></label>
            <br/>
        <p class="imgpreview"></p>
        <input class="imgph" type="hidden" id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>"  value="<?php echo esc_attr($instance['image']);?>"  />
        <input type="button" class="button btn-primary widgetuploader" value="<?php _e('Add Image','demowidget'); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php _e('Target URL:','demowidget'); ?></label>
            <br/>
            <input class="widefat" type="url" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" value="<?php echo esc_attr($instance['url']);?>" />
        </p>
<?php
   }
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['image'] = sanitize_text_field($new_instance['image']);

        $instance['url'] = sanitize_text_field($new_instance['url']);

        return $instance;

    }
    public function widget($args, $instance)
    {


        $image_src='';
        $desplay_image=false;
        if($instance["image"]){
            $desplay_image=1;
            $image_src=wp_get_attachment_image_src($instance["image"],"thumbnail");
        }
        $args["before_widget"];
        if(isset($instance["title"])&&$instance["title"]!=''){
            $args["before_title"];
            echo apply_filters("widgets_title",$instance["title"]);
            $args["after_title"];
        }
        ?>
        <div class="widget_image">
            <?php
            if($desplay_image){
                if(isset($instance['url'])&&$instance["url"]!=''){
                    ?>
                    <a  target="_blank" href="<?php echo esc_url($instance["url"]);?>"><img  alt="<?php _e('media Widgets','media-widgets');?>"src="<?php echo esc_url($image_src[0]); ?>"></a>
                        <?php
                }
                else{
                    ?>
                    <img  alt="<?php _e('media','media-widgets');?>"src="<?php echo esc_url($image_src[0]); ?>">
                        <?php
                }
            }
            ?>
        </div>
<?php

        $args["after_widget"];
    }
}