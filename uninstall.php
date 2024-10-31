 <?php

 /**
 * @package requestlogic
 */

 if( !defined('WP_UNINSTALL_PLUGIN') ){
     die;
 }

 $posts = get_posts(array('post_type' => 'requestlogic', 'numberposts' => -1));

 foreach($posts as $post){
    wp_delete_post($post->ID, false);
 }