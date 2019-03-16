<?php
session_start();
//$doc_root = "/var/www/vhosts/u0320942.plsk.regruhosting.ru/stolcafe.ru";
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include_once $doc_root.'/wp-config.php';
if(!class_exists('WP_Query')) {
    include_once $doc_root.'/wp-includes/class-wp-query.php';
}

function getDateByDay($day)
{
    switch ($day) {
        case "1" : $weekday = "monday"; break;
        case "2" : $weekday = "tuesday"; break;
        case "3" : $weekday = "wednesday"; break;
        case "4" : $weekday = "thursday"; break;
        case "5" : $weekday = "friday"; break;
        case "6" : $weekday = "saturday"; break;
        case "7" : $weekday = "sunday"; break;
    }

    if (strtotime("today midnight") == strtotime($weekday)) {
        $weekday = "+7 days";
    }

    return date("d.m.Y", strtotime($weekday));
}

function getOrders() {
 global $wpdb;
 $past_date = $wpdb->get_results("SELECT UNIX_TIMESTAMP() AS now;");
 $past_date = intval($past_date[0]->now) - (3600*24);
 $ids =$wpdb->get_col("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'shop_order' AND UNIX_TIMESTAMP(post_date_gmt) > {$past_date} ORDER BY UNIX_TIMESTAMP(post_date_gmt) ASC;");
 $orders =array();
 foreach($ids as $id) {
     $order = new WC_Order($id);
     $data = $order->get_data();
     $productInfo = array();

     foreach ($data['line_items'] as $item) {
        $product = $item->get_product();

        $day = $product->get_attribute('day');
        $name = $product->get_name();

        $productForDay = $order->get_meta($product->get_id().'_forDay');

        $productInfo[] = ['day' => getDateByDay($productForDay), 'name' => $name];
     }

     $orders[] = array('id'=>$id,'f_name'=>$order->get_billing_first_name(),'l_name'=>$order->get_billing_last_name(),'address'=>$order->get_billing_address_1(),'city'=>$order->get_billing_city(),'state'=>$order->get_billing_state(),'postcode'=>$order->get_billing_postcode(),'country'=>$order->get_billing_country(),'email'=>$order->get_billing_email(),'phone'=>$order->get_billing_phone(),'date'=>$order->get_date_completed(), 'productInfo' => $productInfo);
 }
 return $orders;
}    
 
ob_start();    
extract(array('orders'=>getOrders()));
if(!empty($orders)) {

require_once __DIR__.'/orders_template.php';
$s = ob_get_contents();
ob_end_clean();
function wp_get_mail_content_type_f() {
    return 'text/html';
}

add_filter( 'wp_mail_content_type', 'wp_get_mail_content_type_f' );
wp_mail(get_bloginfo('admin_email'), 'Отчет по заказам', $s, array('charset: utf-8;'));
echo 'Письмо было отправлено';
} else {
echo 'Нету новых заказов';
}