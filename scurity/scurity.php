
<?php

private function is_security($noncename,$nonceaction,$postID){
    $nonce=isset($_POST[$noncename])?$_POST[$noncename]:'';
    if($nonce==''){
        return false;
    }
    if(!wp_verify_nonce($nonce,$nonceaction)){
        return false;
    }
    if(!current_user_can("edit_post",$postID)){
        return false;
    }
    if(wp_is_post_autosave($postID)){

        return false;
    }
    if(wp_is_post_revision($postID)){
        return false;
    }
    return true;
}
collback:
 if(!$this->is_security('upload_image_nonce','wp_noonce_action_image',$postId)){
        return $postId;
    }