<?php
/*
Plugin Name: FeedFeed Reposter
Description: This plugin for repost your posts on thefeedfeed.com
Version: 1.0
Author: thefeedfeed.com
Author URI: http://thefeedfeed.com
*/

/*************new post**********/
function ff_post_publish_send($post_ID) {

    $user_post = get_post($post_ID);
    $data =[
        'Post' => [
            'source_id' => $user_post->ID,
            'title' => $user_post->post_title,
            'content' => $user_post->post_content,
            'link' => $user_post->guid,
            'type' => $user_post->post_type,
            ]
        ];
    $postdata = http_build_query($data);

    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );

    $context  = stream_context_create($opts);

    $result = file_get_contents('http://feedfeed-test.aura.nest.vn.ua/post/create', false, $context);

}

add_action('publish_post', 'ff_post_publish_send');
