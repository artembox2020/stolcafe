<?php
class WooHacker {
    public function __construct() {
       // echo "<style> body { visibility:hidden!important;  }</style>";
       add_action('wp_footer',array($this,'run'));
        
    }
    
    public function run() {
       //$p = new WC_Product(23123);
       //print_r($p->get_category_ids());
       //print_r(get_term(19));
       //echo '<script>alert("'.print_r($p->get_category_ids()).'");</script>';
    }
    
    public function run2() {
        if( is_front_page() ) { ?>
  <style>
   /* .today-menu  { position:relative;  } */
  </style>
  <script>
   jQuery(function($) {
    
      function get_add_to_cart(id,style) {
        var form = $('<form  class="cart" method="post" enctype="multipart/form-data">');
        $('<div class="single-product-buttons"><div class="single_add_to_cart_button_wrap">	<div class="quantity"><i class="dfd-socicon-minus-symbol minus"></i><input type="number" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric"><i class="dfd-socicon-plus-black-symbol plus"></i></div><button type="submit" name="add-to-cart" value="'+id+'" class="single_add_to_cart_button button alt" data-quantity="1">Добавить в корзину</button></div></div>').appendTo(form);
        
        form.find(".minus").click(function(){
          var qty = $(this).parents("form").eq(0).find(".input-text.qty");
          var value = parseInt(qty.val());
          if(value != undefined && value != null && value != NaN && value > 1) value = --value;
          else value = 1;
          qty.val(value);
        });
        
        form.find(".plus").click(function(){
          var qty = $(this).parents("form").eq(0).find(".input-text.qty");
          var value = parseInt(qty.val());
          if(value != undefined && value != null && value != NaN && value > 0) value = ++value;
          else value = 1;
          qty.val(value);
        });
        
        var container = $('<div class="addtocartcontainer" data-id="'+id+'-add-to-cart" style="'+style+'">');
        form.appendTo(container);
        return container;
      }
      
      var bzn_lanch_selector = ".vc-row-wrapper.vc_inner.vc_row-fluid .columns.four:first";
<?php  
  $pr = new WC_Product_Grouped(23107);
 foreach($pr->get_children() as $child): 
  $pr2 = new WC_Product($child);
  $image_text = $pr2->get_image();
  preg_match("/(?:srcset)[' ']*=[' ']*\"([^\"]*)/",$image_text,$srcs);
  //echo("alert('".$srcs[1]."');");
  preg_match("/[^|,]([^,]*)300w/",$srcs[1],$image_src);
   //echo("alert('".$image_src[1]."');");
  if(empty($image_src) || count($image_src) < 2) {
     $image_src = array_pop(explode(",",$srcs[1]));
     $image_src = @split(" ",trim($image_src))[0];
  }
  else $image_src = trim($image_src[1]);
  //var_dump($image_src);
  //var_dump($pr2->get_title());
 //var_dump($pr2->get_description());
  //var_dump($pr2->get_short_description());
  //echo $pr2->get_price();
  /*echo "<br/><br/><br/>";
   echo "<br/><br/><br/>";
    echo "<br/><br/><br/>";
     echo "<br/><br/><br/>";
      echo "<br/><br/><br/>";*/
?>
    var item = $(bzn_lanch_selector).clone();
    item.find(".dfd-logo-carousel-item .thumb-wrap-front img").attr({ 'src':'<?= $image_src ?>','width':'300','height':'300'});
    item.find(".dfd-logo-carousel-item .thumb-wrap-back .text-overflow").html('<?= str_replace(array("\r\n","\n"),array("<br/>","<br/>"),$pr2->get_description()) ?>');
    item.find(".dfd-heading-module .dfd-title").text('<?= $pr2->get_title() ?>');
    item.find(".dfd-heading-module .dfd-sub-title").html('<?= $pr2->get_short_description() ?>');
    item.find(".dfd-button-link .dfd-button-text-main").text('<?= $pr2->get_price() ?> р');
    
    item.addClass('today-menu');
     
    item.find(".dfd-button-link").on('mouseover',function() { 
        get_add_to_cart(<?= $child ?>,"position:absolute; top:75%; left:10%; z-index:1000; background:#fff; opacity:1.0; padding:4px; display:none;").prependTo($(this).parents(".today-menu").eq(0));
        $(this).parents(".today-menu").eq(0).find(".addtocartcontainer").fadeIn(400);
        $(this).parents(".today-menu").eq(0).find(".addtocartcontainer").css('display','block');
        
    });
    
    item.on('mouseleave',function() {  
        $(this).find(".addtocartcontainer").fadeOut(400);  
        $(this).find(".addtocartcontainer").remove();    
        
    });
    
    item.insertBefore($(bzn_lanch_selector).eq(0));
 <?php endforeach; ?>    
   
});
</script>

<?php }
    }
}