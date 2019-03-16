<?php
/*
Plugin Name: WooHacker
Description: Integrates Woocommerce into front page
Version: 1.0
Author: Artem Palamarchuk
*/
define('WOOH_DIR', plugin_dir_path(__FILE__));
define('WOOH_URL', plugin_dir_url(__FILE__));

function wooh_loader() {
  require_once WOOH_DIR."/includes/WooHacker.php";
  return (new WooHacker());
}
add_action('plugins_loaded','wooh_loader');