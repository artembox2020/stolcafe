<?php
session_start();  global $dayToday; $dayToday = date('N'); $hourToday = date('H'); //echo date('H'); echo '<pre>'; echo date("d.m.Y H:i:s", strtotime("monday")); echo '</pre>';
include_once $_SERVER['DOCUMENT_ROOT'].'/wp-config.php';
if(!class_exists('WP_Query')) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/wp-includes/class-wp-query.php';
}

function checkPurchasable($forDay)
{
        global $dayToday;
        global $hourToday;
	    $day = date('N', strtotime("+3 hours"));

	    $dayToday = $day;
	    
	    if (empty($forDay)) {
	        $forDay = $day;
	    }
        
        if (in_array($day, array(6,7))) {
            
            return true;
        }
        
        if (in_array($day, array(5)) && (int)date('H', strtotime("+3 hours")) >= 15) {
            
            return true;
        }
        
        if ($forDay >= $day +1) {
            
            return true;
        }

        return false;
	}

function getProducts($lanch = false,$cat_id =0) {
       $products = array();
       $categories = array();
       $cat_ids = array();
       if($lanch) {
           $operator = "IN";
           $field = 'slug';
           $terms = 'lanch';
           
       }
       else if(!empty($cat_id)) {
           $operator = "IN";
           $field = 'id';
           $terms = $cat_id;
       }
       else {
           $operator = "NOT IN";
           $field = 'slug';
           $terms = 'lanch';
       }
        $args = array(
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'posts_per_page'                 => 999999,
    'tax_query'             => array(
		'relation' => 'AND',
        array(
            'taxonomy'      => 'product_cat',
            'field' => $field,
            'terms'         => $terms,
            'operator'      => $operator
        ),
		array(
            'taxonomy'      => 'product_cat',
            'field' => 'slug',
            'terms'         => 'uncategorized',
            'operator'      => 'NOT IN'
        ),
    )
    );
     $loop = new WP_Query( $args );
     $s = ''; $i = 0;
     $res = '';
     while ( $loop->have_posts() ) : $loop->the_post();
    global $product;
    $productAttribute = $product->get_attribute('day');

    if (isset($_GET['day_id']) && !empty($_GET['day_id'])) {
        $day = - (int)$_GET['day_id'];
    } else {
        $day = date('N', strtotime("+3 hours"));
        if (in_array($day, array(6,7)) || (in_array($day, array(5)) && date('H', strtotime("+3 hours")) >= 15) ) {
            if (empty($productAttribute)) {
                $day = 1;
            } else {
                $days = explode(',', $productAttribute);
                sort($days);
                $day = $days[0];
            }
        }
    }

    $active = checkPurchasable($day) ? 1 : 0;
    $found = false;

    foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
        $_product = $values['data'];

        if ( $_product->id == $product->get_id() ) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        global $wpdb;
        $table = $wpdb->prefix.'postmeta';
        $wpdb->delete($table, ['post_id' => $product->get_id(), 'meta_key' =>$_COOKIE['PHPSESSID'].'_forDay']);
        $data = ['post_id' => $product->get_id(), 'meta_key' => $_COOKIE['PHPSESSID'].'_forDay', 'meta_value' => $day];
        $format = array('%d','%s', '%s');
        $wpdb->insert($table, $data, $format);
    }

    if (!empty($productAttribute) && !in_array($day, explode(',', $productAttribute))) {
        continue;
    }

     $image_text = $product->get_image();
     preg_match("/(?:srcset)[' ']*=[' ']*\"([^\"]*)/",$image_text,$srcs);
     preg_match("/[^|,]([^,]*)300w/",$srcs[1],$image_src);
     if( empty($image_src) || count($image_src) < 2 ) {
       $image_src = array_pop(explode(",",$srcs[1]));
       $image_src = explode(" ",trim($image_src));
       $image_src = $image_src[0];
     }
     else $image_src = trim($image_src[1]);
     $products[] = array('image'=>$image_src,'permalink'=>$product->get_permalink(),'id'=>$product->get_id(),'title'=>$product->get_title(),'price'=>$product->get_price(),'description'=>$product->get_description(),'short'=>$product->get_short_description(),'ids'=>$product->get_category_ids());
     if($res!='') $res.=' , ';
     $ids = $product->get_category_ids();
	 $productShortDescription = str_replace("\\", "/", $product->get_short_description());
	 $productDescription = str_replace("\\", "/", $product->get_description());
	 $productTitle = str_replace("\\", "/", $product->get_title());
     $res.='"'.$i.'"'.':{"image":"'.$image_src.'","permalink":"'.$product->get_permalink().'","id":"'.$product->get_id().'","title":"'.str_replace(array('"'),array("'"),$productTitle).'","price":"'.$product->get_price().'","description":"'.str_replace(array("\r\n","\n","'","\""),array("<br/>","<br/>","oiionqs1ww1s","89h2sxbxuwiw1q"),$productDescription).'","short":"'.str_replace(array("\r\n","\n","'","\""),array("<br/>","<br/>","oiionqs1ww1s","89h2sxbxuwiw1q"), $productShortDescription).'","ids":"'.$ids[0].'", "day":"'.$productAttribute.'", "active": "'.$active.'", "forDay": "'.$product->get_meta($_COOKIE['PHPSESSID'].'_forDay').'"}';
     $cat_id = $product->get_category_ids();
     //print_r($cat_id);
     $cat_id = $cat_id[0];
     if(!in_array($cat_id,$cat_ids)) {
       $categories[] = array('id'=>$cat_id,'slug'=>get_term($cat_id)->slug,'name'=>get_term($cat_id)->name);
       $cat_ids[] = $cat_id;
     }
     ++$i;
     endwhile; wp_reset_query();
     $products['cats'] = $categories;

    if (empty($res)) {
        $res = '"0":""';
    }

    return ' { '.$res.',"length":"'.$i.'" } ';
    }

echo getProducts(false,$_GET['cat_id']);