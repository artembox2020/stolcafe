<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/wp-config.php';
if(!class_exists('WP_Query')) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/wp-includes/class-wp-query.php';
}

function remove_product_pp($product_id) {
        $cart = WC()->instance()->cart;
        $cart_id = $cart->generate_cart_id($product_id);
        $cart_item_id = $cart->find_product_in_cart($cart_id);
        if($cart_item_id){
           $cart->set_quantity($cart_item_id,0);
        }
}

remove_product_pp($_REQUEST['id']);