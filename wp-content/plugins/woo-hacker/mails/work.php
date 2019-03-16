<?php 
  $ch = curl_init("http://stolcafe.ru/wp-content/plugins/woo-hacker/mails/goods.php");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
  curl_exec($ch);
  curl_close($ch);

  $ch = curl_init("http://stolcafe.ru/wp-content/plugins/woo-hacker/mails/orders.php");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
  curl_exec($ch);
  curl_close($ch);
?>