<?php
$doc_root = "/var/www/vhosts/u0320942.plsk.regruhosting.ru/stolcafe.ru";
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include_once $doc_root.'/wp-config.php';
if(!class_exists('WP_Query')) {
    include_once $doc_root.'/wp-includes/class-wp-query.php';
}
function getCatsData() {
 global $wpdb;
 $past_date = $wpdb->get_results("SELECT UNIX_TIMESTAMP() AS now;");
 $past_date = intval($past_date[0]->now) - (3600*24);
 $ids =$wpdb->get_col("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'shop_order' AND UNIX_TIMESTAMP(post_date_gmt) > {$past_date} ORDER BY UNIX_TIMESTAMP(post_date_gmt) ASC;");
 $cats_data = array();
 foreach($ids as $id) {
     $order = new WC_Order($id);
     $data = $order->get_data();
     foreach($data['line_items'] as $item) {
         $product = $item->get_product();
         $category = $product->get_category_ids();
         $category = $category[0];
         $category_name = get_term($category);
         if( $category_name->parent != 0 ) $category_name = get_term($category_name->parent)->name;
         else $category_name = $category_name->name;

         if(!isset($cats_data[$category_name])) $cats_data[$category_name] = array();
         elseif(!isset($cats_data[$category_name][$product->get_id()])) $cats_data[$category_name][$product->get_id()]= array('q'=>0);
         $cats_data[$category_name][$product->get_id()]['q'] += intval($item->get_quantity());
         $cats_data[$category_name][$product->get_id()]['name'] = $product->get_name();
     }
 }
 return $cats_data;
}    
 
ob_start();    
extract(array('cats_data'=>getCatsData()));

if( !empty($cats_data) ) {

require_once  $doc_root.'/wp-content/plugins/woo-hacker/mails/goods_template.php';
$s = ob_get_contents();
ob_end_clean();
function wp_get_mail_content_type_f() {
    return 'text/html';
}

add_filter( 'wp_mail_content_type', 'wp_get_mail_content_type_f' );

wp_mail('artembo2020@gmail.com'/*get_bloginfo('admin_email')*/,'Отчет по расходам блюд',$s, array('charset: utf-8;'));
}