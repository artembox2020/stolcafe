<script>
  jQuery(function($) {
     var bzn_lanch_selector = ".vc-row-wrapper.vc_inner.vc_row-fluid .columns.four:first";
  function get_add_to_cart2(id,style) {
          var form = $('<form  class="cart" method="post" enctype="multipart/form-data">');
          $('<?php     if( wpmd_is_notphone() ):  ?><div style="background:transparent!important;" class="single-product-buttons"><div style="background:transparent!important;" class="single_add_to_cart_button_wrap">	<div class="quantity"><i style="color:white!important; font-weight:bold!important;" class="dfd-socicon-minus-symbol minus"></i><input type="number" style="color:white!important; font-weight:bold!important;" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric"><i style="color:white!important; font-weight:bold!important;" class="dfd-socicon-plus-black-symbol plus"></i></div><?php endif;  ?><button type="submit" name="add-to-cart" value="'+id+'" class="single_add_to_cart_button button alt" data-quantity="1"><a  rel="nofollow" style="pointer-events:none;" href="<?php echo wc_get_cart_url(); ?>">Добавить в корзину</a></button></div></div>').appendTo(form);
        <?php     if( wpmd_is_notphone() ):  ?>  
          form.find(".minus").click(function() {
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
       <?php endif; ?>   
          form.on('submit',function(e){
            e.stopPropagation();
            e.preventDefault();
            var a =$('<a style="display:none!important;" rel="nofollow" href="/shop/?add-to-cart='+id+'" data-quantity="'+$(this).find(".input-text.qty").val()+'" data-product_id="'+id+'" data-product_sku="" class="add_to_cart_button_al button product_type_simple add_to_cart_button ajax_add_to_cart added">Добавить в корзину</a>');
            a.appendTo($(this));
            $(this).find("a.add_to_cart_button_al").click();
             $(this).find("a.add_to_cart_button_al").remove(); 
            setTimeout(function() { 
var btn = form.find('button');

$.get("/apis/get_cart_items.php", function(res) {
  var r = JSON.parse(res);
  var cart = $(".total_cart_header");
  cart.find(".woo-cart-details").html(r.total);
 $(".shopping-cart-box-content  .widget_shopping_cart_content  ul.cart_list.product_list_widget li").remove();
for(var t =0; t<r.q;++t) {
  var thumb = $('<div class="thumb">');
var cover = $('<div class="image-cover">');
var img = $('<img width="140" height="140" >');
img.attr('src',r[t].image);

img.appendTo(cover);
cover.appendTo(thumb);

var mini_q = $('<span class="mini-cart-quantity">'+r[t].q+' × <span class="woocommerce-Price-amount amount">'+r[t].price+'<span class="woocommerce-Price-currencySymbol">₽</span></span></span>');
var link = $('<a href="'+r[t].link+'" >');
link.html(r[t].title);
var mini_content = $('<div class="mini-cart-content">');
var remove = $('<a data-id="'+r[t].id+'" href="http://restaurant.ecreater.ru/cart/?remove_item=74d1420077a5da8ed985b0c26f128c27&amp;_wpnonce=90e7d1f3357" class="remove" title="Удалить эту позицию" data-product_id="23160" data-product_sku="">×</a>');

remove.click(function(e) {
  e.stopPropagation();
  e.preventDefault();
  var id = $(this).attr('data-id');
  $.get("/apis/remove_fom_cart.php?id="+id,function() {  location.reload();  } );
});
mini_q.appendTo(mini_content);
link.appendTo(mini_content);

var li = $('<li class="mini_cart_item mini_cart_item_new">');

thumb.appendTo(li);
mini_content.appendTo(li);
remove.appendTo(li);  
$("ul.cart_list.product_list_widget li.mini_cart_item_new").css('display','block');
li.appendTo("ul.cart_list.product_list_widget");
}
//$(" .widget_shopping_cart_content p.total .woocommerce-Price-amount.amount").html(r.price);

var tot = $('<p class="total"><strong>Промежуточный итог:</strong> <span class="woocommerce-Price-amount amount">'+r.price+'<span class="woocommerce-Price-currencySymbol">₽</span></span></p>');

var btns = $('<p class="buttons"><a href="<?php echo WC_Cart::get_cart_url(); ?>" class="button wc-forward">Показать Корзину</a><a href="<?php echo 
 WC_Cart::get_checkout_url(); ?>" class="button checkout wc-forward">Оформить заказ</a></p>');
$('.shopping-cart-box-content .widget_shopping_cart_content').find(".total").remove();
$('.shopping-cart-box-content .widget_shopping_cart_content').find(".buttons").remove();
tot.appendTo(".shopping-cart-box-content .widget_shopping_cart_content");
btns.appendTo(".shopping-cart-box-content .widget_shopping_cart_content");
 $(".shopping-cart-box-content  .widget_shopping_cart_content  ul.cart_list.product_list_widget li.empty").remove();
});

 btn.click( function(){ location.href ="<?php echo wc_get_cart_url(); ?>";  } );
btn.find("a").css('pointerEvents','auto'); btn.find("a").html('Просмотр корзины'); }); 

}, 400);
            $(this).find("button").on('click', function(e) { e.stopPropagation(); e.preventDefault();  } );
            $(this).find("button a").css('opacity','1');
            $(this).find("button a").html("Обработка...");
          });
           var container = $('<div class="addtocartcontainer" data-id="'+id+'-add-to-cart" style="'+style+'">');
           form.appendTo(container);
           return container;
   }
            
<?php
  $prods =array();
  for($k = 0;$k < 3; ++$k) {
      if(!isset($prods22[$k])) break;
      $prods[] = $prods22[$k]['id'];
  }
 foreach($prods as $child): 
  $pr2 = new WC_Product($child);
  $image_src = get_the_post_thumbnail_url( $child, 'shop_catalog' );
?>
    var item = $(bzn_lanch_selector).clone();
    item.find(".dfd-logo-carousel-item .thumb-wrap-front").css('position','relative');
    item.find(".dfd-logo-carousel-item .thumb-wrap-front img").attr({'src':'<?= $image_src ?>','style':'width:320px!important; height:280px!important;cursor:pointer!important;'});
    item.find(".dfd-logo-carousel-item .thumb-wrap a.full-box-link").attr('href',"<?= $pr2->get_permalink() ?>");
    item.find(".dfd-logo-carousel-item .thumb-wrap-back .text-overflow").html("<?= str_replace(array("\r\n","\n","'",'"'),array("<br/>","<br/>","\'",'\"'),$pr2->get_description()) ?>");
    item.find(".dfd-heading-module .dfd-title").text('<?= $pr2->get_title() ?>');
    item.find(".dfd-heading-module .dfd-sub-title").html("<?= str_replace(array("\r\n","\n","'",'"'),array("<br/>","<br/>","\'",'\"'),$pr2->get_short_description()) ?>");
    item.find(".dfd-button-link .dfd-button-text-main").text('<?= $pr2->get_price() ?> р');
    item.find(".dfd-logo-carousel-item a.full-box-link").attr('href','<?= $pr2->get_permalink() ?>');
    item.addClass('today-menu');
    item.find(".dfd-button-link").removeAttr('href');
    item.find(".dfd-button-link").on('mouseover',function(e) {
        $(".today-menu .addtocartcontainer").remove();
        get_add_to_cart2(<?= $child ?>,"position:absolute; <?php     if( wpmd_is_notphone() ):  ?> top:90%; left:8%; <?php else: ?>   top:84%; left: 20%; <?php endif; ?>z-index:1000; background:transparent; font-weight:bold; opacity:1.0; width: 320px!important; white-space: nowrap!important; padding:4px; display:none;").prependTo($(this).parents(".today-menu").eq(0));
        $(this).parents(".today-menu").eq(0).find(".addtocartcontainer").fadeIn(400);
        $(this).parents(".today-menu").eq(0).find(".addtocartcontainer").css('display','block');
        
    });
    
    item.on('mouseleave',function() {  
        $(this).find(".addtocartcontainer").fadeOut(400);  
        $(this).find(".addtocartcontainer").remove();    
        
    });
    
    item.insertBefore(bzn_lanch_selector);
 <?php endforeach; ?>  
    $(".vc-row-wrapper.vc_inner.vc_row-fluid .columns.four").hide();
    $(".vc-row-wrapper.vc_inner.vc_row-fluid .columns.four:eq(-1)").attr('style',$(".vc-row-wrapper.vc_inner.vc_row-fluid .columns.four:eq(-1)").attr('style')+";display:block!important;");
    $('.today-menu').attr('style','display:block!important');
});
</script>