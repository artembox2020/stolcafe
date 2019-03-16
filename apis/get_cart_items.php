<?php //echo '<pre>';
include_once $_SERVER['DOCUMENT_ROOT'].'/wp-config.php';
if(!class_exists('WP_Query')) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/wp-includes/class-wp-query.php';
}
//echo WC()->cart->get_cart_url();
$cart_base = WC()->cart->get_cart_item_quantities();
$s = '{';
$i = 0;
$total = 0;
$total_price = 0;
$j = 0;

if (!empty($_REQUEST['pageSize'])) {
        $pageSize = (int)$_REQUEST['pageSize'];
    } else {
        $pageSize = 10;
    }
    
    if (!empty($_REQUEST['page'])) {
        $page = (int)$_REQUEST['page'];
    } else {
        $page = 1;
    }
    
    $offset = ($page - 1) * $pageSize;
    $number = 0;
    $busyDays = [];

foreach($cart_base as $id=>$q) {
    $p = new WC_Product($id);
    $forDay = $p->get_meta($_COOKIE['PHPSESSID'].'_forDay');

    if (empty($forDay)) {
        $busyDays = [1,2,3,4,5,6,7];
    } else {

        if (!in_array($forDay, $busyDays)) {
            $busyDays[] = $forDay;
        }
    }

    if (!empty($_REQUEST['day'])) {

        if (!empty($forDay) && (int)$_REQUEST['day'] != 0 - (int)$forDay) {
            continue;
        }
    }
    
    
    
    
    $image_text = $p->get_image();
    //echo $image_text."<br/>";
    preg_match("/(?:srcset)[' ']*=[' ']*\"([^\"]*)/",$image_text,$srcs);
    preg_match("/[^|,]([^,]*)300w/",$srcs[1],$image_src);
    /*if( empty($image_src) || count($image_src) < 2 ) {
       $image_src = array_pop(explode(",",$srcs[1]));
       $image_src = explode(" ",trim($image_src));
       $image_src = $image_src[0];
    }
    else 
      if( count($image_src) ==1 ) { $image_src = trim($image_src[1]); }
      else {
      */
      preg_match("/(?:src)[' ']*=[' ']*\"([^\"]*)/",$image_text,$srcs);
      $image_src = trim($srcs[1]);
      if(!isset($image_src)) $image_src = "";
      /*} */
    if ($offset <= 0 && $number < $pageSize) {

        if($i > 0 && $offset<0) $s.=','; 
        $s2 = '"id":"'.$p->get_id().'", "q":"'.$q.'","link":"'.$p->get_permalink().'","title":"'.str_replace('"',"'",$p->get_title()).'","price":"'.$p->get_price().'","image":"'.$image_src.'", "forDay": "'.$p->get_meta($_COOKIE['PHPSESSID'].'_forDay').'"}';
        $s.='"'.$j++.'":{'.$s2;
        ++$number;
    }

    
    $total_price += intval($p->get_price())*$q;
    $total+= $q;
    ++$i;
    --$offset;
}

if ($total > 0) {
    $allPages = ceil((int)$i / $pageSize);
} else {
    $allPages = 0;
}

$emptyDays = array_diff([1,2,3,4,5,6,7], $busyDays);
$emptyDays = implode(",", $emptyDays);

if($i > 0 && $offset< 0 ) $s.=',';
$s.='"q":"'.$i.'","total":"'.$total.'","price":"'.$total_price.'", "pageSize": "'.$pageSize.'", "page":"'.$page.'", "allPages": "'.$allPages.'", "emptyDays":"'.$emptyDays.'"';
$s.='}';
echo $s; //echo '</pre>';