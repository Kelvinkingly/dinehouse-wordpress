<?php
if(!defined('ABSPATH'))exit;
add_action('after_setup_theme',function(){add_theme_support('title-tag');add_theme_support('post-thumbnails');});
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('dinehouse',get_stylesheet_uri(),array(),'1.0');wp_enqueue_script('dinehouse',get_template_directory_uri().'/app.js',array(),'1.0',true);});
add_action('wp_head',function(){if(!has_site_icon())echo '<link rel="icon" type="image/svg+xml" href="'.esc_url(get_template_directory_uri().'/favicon.svg').'">';});
function dh_asset($f){return esc_url(get_template_directory_uri().'/'.$f);}
function dh_dishes(){return array(array('Heirloom Burrata','Creamy burrata, ripe tomatoes, basil and extra virgin olive oil.','Starters','Vegetarian',16,'dish1.webp'),array('Lemon Butter Salmon','Grilled salmon with a silky lemon risotto and seasonal greens.','Mains','Fish',29,'dish2.webp'),array('Wild Mushroom Tagliatelle','Hand-cut pasta, slow roasted mushrooms and herb butter.','Mains','Vegetarian',24,'dish3.webp'),array('Dark Chocolate Delice','Rich chocolate, berry compote and a delicate cocoa crumb.','Desserts','Vegetarian',12,'dish4.webp'));}
add_action('init',function(){register_post_type('dh_dish',array('label'=>'Menu dishes','public'=>true,'show_in_rest'=>true,'supports'=>array('title','editor','thumbnail','custom-fields'),'menu_icon'=>'dashicons-carrot'));});
add_action('after_switch_theme',function(){if(get_option('dh_seeded'))return;foreach(dh_dishes() as $d){$id=wp_insert_post(array('post_type'=>'dh_dish','post_title'=>$d[0],'post_content'=>$d[1],'post_status'=>'publish'),true);if(!is_wp_error($id)){foreach(array('category','diet','price','photo') as $i=>$k)update_post_meta($id,'dh_'.$k,$d[$i+2]);}}update_option('dh_seeded',1);flush_rewrite_rules();});
function dh_meta($k){return get_post_meta(get_the_ID(),'dh_'.$k,true);}
