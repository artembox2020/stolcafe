<?php
global $dayToday; global $hourToday; $dayToday = date('N'); $hourToday = date('H');
class WooHacker {
    public function __construct() {
       add_action('pre_get_posts', array($this,'hideLanchOnShopPage'));
       add_action('wp_head',array($this,'hideOnStart'));
       // echo "<style> body { visibility:hidden!important;  }</style>";
       add_action('wp_footer',array($this,'run'));
	   if (!is_admin()) {
	   	add_filter('posts_where' , array($this,'posts_where'));
	   }

	   if (false && !$this->checkPurchasable(0)) {
	       add_filter( 'woocommerce_is_purchasable', '__return_false');
	   }

	   add_filter( 'woocommerce_thankyou', array($this, 'custom_after_create_order'), 10, 1 );
	   add_action( 'woocommerce_before_cart', array($this, 'custom_before_cart'), 10, 1); 

    }
    
    public function custom_before_cart()
    {
        /*$url = home_url().'/apis/get_cart_items.php';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $url;
        echo $result;*/
        include_once(__DIR__.'/templates/cart.php');
    }

    public function custom_after_create_order($order_id)
    {
        session_start();
        $order = new WC_Order($order_id);
        $data = $order->get_data();
        foreach ($data['line_items'] as $item) {
            $product =  $item->get_product();

            $forDay = $product->get_meta($_COOKIE['PHPSESSID'].'_forDay');
            if (!empty($forDay)) {
                if (!$this->checkPurchasable($forDay)) {
                    $days = $product->get_attribute('day');

                    if (empty($days)) {
                        $days = [1,2,3,4,5];
                    } else {
                        $days = explode(",", $days);
                    }
                    
                    sort($days);
                    $newForDay = 0;

                    foreach ($days as $day) {
                        if ((int)$day > $forDay) {
                            $newForDay = $day;
                            break;
                        }
                    }

                    if (empty($newForDay)) {
                        $forDay = $days[0];
                    } else {
                        $forDay = $newForDay;
                    }
                }
            }
            
            if (!empty($forDay)) {
                global $wpdb;
                $table = $wpdb->prefix.'postmeta';
                $data = ['post_id' => $order_id, 'meta_key' => $product->get_id().'_forDay', 'meta_value' => $forDay];
                $format = array('%d','%s', '%s');
                $wpdb->insert($table, $data, $format);
                $wpdb->delete($table, ['post_id' => $product->get_id(), 'meta_key' =>$_COOKIE['PHPSESSID'].'_forDay']);
            }
        }
    }

    public function custome_add_to_cart($cart_item_key, $product_id) {
        session_start();
        $_SESSION['pp_'.$product_id] = $_SESSION['p_'.$product_id];
        
	}

	public function checkPurchasable($forDay)
	{
	    global $dayToday;
	    global $hourToday;
	    $day = $dayToday;
	    
	    if (empty($forDay)) {
	        $forDay = $day;
	    }
        
        if (in_array($day, array(6,7))) {
            
            return true;
        }
        
        if (in_array($day, array(5)) && (int)$hourToday >= 15) {
            
            return true;
        }
        
        if ($forDay >= $day +1) {
            
            return true;
        }
        
        return false;
	    
	    
	}

	public function posts_where( $where ) {
		$args = array (
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 999999,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => 'uncategorized',
			),
		),
    	);

		$ids = get_posts($args);

		$ids = wp_list_pluck( $ids, 'ID' );

		$ids = implode(",", $ids);

		$where .= " AND ID NOT IN (".$ids.")";

		return $where;
	}

    public function hideOnStart() {
        echo '<style>.vc-row-wrapper.vc_inner.vc_row-fluid .columns.four { display:none!important; }  .vc_tta-panels-container .vc_tta-panels .vc_tta-panel { visibility:hidden!important;  }  .vc_tta-panels-container .vc_tta-panels .vc_tta-panel-new { visibility:visible!important; } .products .product.type-product.product_cat-uncategorized, .product_cat-uncategorized, .product-categories li.cat-item a[href*=uncategorized] { display:none; }</style>';
    }
    
    public function hideLanchOnShopPage($query) {
       if (!is_admin() && is_post_type_archive( 'product' ) && $query->is_main_query()) {
           $query->set('tax_query', 
               array(
                    'relation' => 'AND',
                    array ('taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'operator' => 'NOT IN',
                            'terms' => array('lanch')
                          ),
                    array(
                           'taxonomy' => 'product_cat',
                           'field'    => 'slug',
                           'terms'    => 'uncategorized',
                           'operator' => 'NOT IN',
                         ) 
                     )
            );   
       }   
    }
    
    private function getProducts($lanch = false, $cat = -1) {
       $products = array();
       $categories = array();
       $cat_ids = array();
       if($lanch) $operator = "IN";
       else $operator = "NOT IN";
       if($cat != -1) {  $category = $cat; $operator = "IN"; $posts_per_page = 3;  }
       else  { $category = 'lanch'; $posts_per_page = 999999; }
        $args = array(
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'posts_per_page'                 => $posts_per_page,
    'tax_query'             => array(
        'relation' => 'AND',
        array(
            'taxonomy'      => 'product_cat',
            'field' => 'slug',
            'terms'         =>$category,
            'operator'      => $operator
        ),
        array(
            'taxonomy'      => 'product_cat',
            'field' => 'slug',
            'terms'         =>'uncategorized',
            'operator'      =>'NOT IN'
        ),
    )
    );
     $loop = new WP_Query( $args );
     while ( $loop->have_posts() ) : $loop->the_post();
     global $product;
     $image_text = $product->get_image();
     preg_match("/(?:srcset)[' ']*=[' ']*\"([^\"]*)/",$image_text,$srcs);
     preg_match("/[^|,]([^,]*)300w/",$srcs[1],$image_src);
     if( empty($image_src) || count($image_src) < 2 ) {
       $image_src = array_pop(explode(",",$srcs[1]));
       $image_src = explode(" ",trim($image_src));
       $image_src = $image_src[0];
     }
     else $image_src = trim($image_src[1]);
     $cat_id = $product->get_category_ids();
     //print_r($cat_id);
     $cat_id = $cat_id[0];
     if(get_term($cat_id)->slug != 'uncategorized')
     $products[] = array('image'=>$image_src,'permalink'=>$product->get_permalink(),'id'=>$product->get_id(),'title'=>str_replace(array('"'),array("'"),$product->get_title()),'price'=>$product->get_price(), /*'description'=>$product->get_description(),'short'=>$product->get_short_description(), */ 'ids'=>$product->get_category_ids());
     
     if(!empty($cat_id) && !in_array($cat_id,$cat_ids) && get_term($cat_id)->slug != 'uncategorized') {
       $categories[] = array('id'=>$cat_id,'slug'=>get_term($cat_id)->slug,'name'=>get_term($cat_id)->name);
       $cat_ids[] = $cat_id;
     }
     endwhile; wp_reset_query();
     //echo "<br/><br/>Categories---<br/><br/>";
     //print_r($categories);
     $products['cats'] = $categories;
     return $products;
    }
    
    public function run() {
       //echo date("D");  echo date("G"); 
       $category = 'monday';
       switch(date('D')) {
           case 'Sun': $category = 'sunday'; if(intval(date('G')) < 6) $category = 'saturday'; break;
           case 'Mon': $category = 'monday'; if(intval(date('G')) < 6) $category = 'sunday';  break;
           case 'Tue': $category = 'tuesday'; if(intval(date('G')) < 6) $category = 'monday';  break;
           case 'Wed': $category = 'wednesday'; if(intval(date('G')) < 6) $category = 'tuesday'; break;
           case 'Thu': $category = 'thursday'; if(intval(date('G')) < 6) $category = 'wednesday'; break;
           case 'Fri': $category = 'friday'; if(intval(date('G')) < 6) $category = 'thursday'; break;
           default: $category = 'saturday'; if(intval(date('G')) < 6) $category = 'friday'; break;
       }
       if(is_front_page()) {
          extract(array('prods'=>$this->getProducts(false)));
//echo "<br/>---products---08080989popkpo<br/>";
//print_r($prods['cats']);
          extract(array('prods22'=>$this->getProducts(true,$category)));
          include_once plugin_dir_path(__FILE__)."/../scripts/menu.php";
          include_once plugin_dir_path(__FILE__)."/../scripts/lanch.php";
       }
	   echo '<script>jQuery(function($){$(".product-categories .cat-item a[href*=uncategorized]").parent().remove(); $("a[href*=\'/monday\']").closest("li.cat-item").remove(); $("a[href*=\'/tuesday\']").closest("li.cat-item").remove(); $("a[href*=\'/wednesday\']").closest("li.cat-item").remove(); $("a[href*=\'/thursday\']").closest("li.cat-item").remove(); $("a[href*=\'/friday\']").closest("li.cat-item").remove(); $("a[href*=\'/saturday\']").closest("li.cat-item").remove(); $("a[href*=\'/sunday\']").closest("li.cat-item").remove(); $("a[href*=\'/product-category/lanch\']").closest("li.cat-item").remove(); })</script>';
       //$p = new WC_Product(23123);
       //print_r($p->get_category_ids());
       //print_r(get_term(19));
       //echo '<script>alert("'.print_r($p->get_category_ids()).'");</script>';
    }
}
?>