<?php
 $doc_root = "/var/www/vhosts/u0320942.plsk.regruhosting.ru/stolcafe.ru";
  include_once $doc_root.'/wp-config.php';
  if(!class_exists('WP_Query')) {
    include_once $doc_root.'/wp-includes/class-wp-query.php';
 } 
 mail('artembo2020@gmail.com','Test message3','Test message3');
?>