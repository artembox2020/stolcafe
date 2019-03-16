<?php     if( wpmd_is_notphone() ):  ?>
<script>
    //alert(parseInt("10px;"));
</script>
<?php 
    //print_r($prods['cats']);
    if(isset($_GET['cat_id'])):
    function filter_arr($var) {
        return ($var['ids'][0] == $_GET['cat_id'] );
    }
    $prods2 =$prods['cats'];
    $prods = array_values( array_filter($prods,'filter_arr') );
    $prods['cats'] = $prods2;
    //echo "<br/>---prods2---<br/>";
    //print_r($prods);
    endif;
    //echo "Number posts : ".count($prods)."<br/>";
    $number_posts = count($prods) < 8 ? count($prods) - 1 : 7;
?>
<?php if(!empty($prods)  ): ?>
    <style>
        .dfd-price-block, .vc_tta-tab { display:none!important;  }
        .dfd-price-block-id { display:block!important; }
        .vc_tta-tab-id { display:inline-block!important; }
        .vc_tta-panel-body .columns.six .dfd-price-wrap: hover {
            
        }
    </style>
    <script>
        jQuery(function($){
            
        var hInt = setInterval(function() { $(window).resize(); }, 400);
        //setTimeout(function() { clearInterval(hInt); setTimeout(function(){   $(window).resize(); }, 1000);  }, 3000);
        function get_add_to_cart(id,style) {
          var form = $('<form  class="cart" style="background:transparent!important;" method="post" enctype="multipart/form-data">');
          $('<div style="background:transparent!important;" class="single-product-buttons"><div style="background:transparent!important;" class="single_add_to_cart_button_wrap">	<div style="background:transparent!important;" class="quantity"><i style="background:transparent!important; font-weight:bold!important;" class="dfd-socicon-minus-symbol minus"></i><input type="number" style="font-weight:bold!important;" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric"><i style="font-weight:bold!important;" class="dfd-socicon-plus-black-symbol plus"></i></div><button type="submit" name="add-to-cart" value="'+id+'" class="single_add_to_cart_button button alt" data-quantity="1">Добавить в корзину</button></div></div>').appendTo(form);
          
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
          
          form.on('submit',function(e){
            e.stopPropagation();  
            e.preventDefault();
            var a =$('<a style="display:none!important;" rel="nofollow" href="/shop/?add-to-cart='+id+'" data-quantity="'+$(this).find(".input-text.qty").val()+'" data-product_id="'+id+'" data-product_sku="" class="add_to_cart_button_al button product_type_simple add_to_cart_button ajax_add_to_cart added">Добавить в корзину</a>');
            a.appendTo($(this));
            $(this).find("a.add_to_cart_button_al").click();
            $(this).find("a.add_to_cart_button_al").remove(); 
            setTimeout(function() { 

            $.get("/apis/get_cart_items.php", function(res) {
  var r = JSON.parse(res);
  var cart = $(".total_cart_header");
  cart.find(".woo-cart-details").html(r.total);
  $("ul.cart_list.product_list_widget li").remove();
  $(".shopping-cart-box-content ul.cart_list.product_list_widget li.empty").remove();
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
var remove = $('<a data-id="'+r[t].id+'" href="http://restaurant.ecreater.ru/cart/?remove_item=74d1420077a5da8ed985b0c26f128c27&amp;_wpnonce=90e7d1f335" class="remove" title="Удалить эту позицию" data-product_id="23160" data-product_sku="">×</a>');

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

var btn = form.find('button'); 
btn.removeAttr('disabled'); 
btn.find("a").css('pointerEvents','auto'); 
btn.find("a").html('Просмотр корзины'); 
                
            },400);
             $(this).find("button").on('click', function(e) { e.stopPropagation(); e.preventDefault(); location.href = "<?php echo wc_get_cart_url(); ?>";  } );
            $(this).find("button").attr('disabled','disabled');
            $(this).find("button").html("<a style='pointer-events:none;'>Обработка...</a>");
          });
           var container = $('<div class="addtocartcontainer" data-id="'+id+'-add-to-cart" style="'+style+'">');
           form.appendTo(container);
           return container;
        }
 
           var click_id = -1;
           var processLoading = false;
           function make_tab(name,id,catid,active, day) {
             var span = $('<span class="vc_tta-title-text">');
             span.html(name);
             var a = $('<a style="z-index:1;" href="#'+id+'" catid="'+catid+'" data-vc-tabs="" data-vc-container=".vc_tta">');
             var li =$('<li class="vc_tta-tab vc_tta-tab-id" data-vc-tab="">');
             if(active) li.addClass('vc_active');
             span.appendTo(a); a.appendTo(li);
             var style = $('.dfd-price-block-id').attr('style');
             li.click(function(e){
                   if(click_id != -1) return false;
                   click_id = id;
                   e.stopPropagation();
                   e.preventDefault();
                   $('nav.page-nav.text-center').remove();
                   hInt = setInterval(function() { $(window).resize(); }, 400);
                   this.setAttribute('disabled','disabled');
                   //this.closest(".vc_tta-tabs-container").find("li a").setAttribute('disabled', 'disabled');
                   $('.vc_tta-tab-id').removeClass('vc_active');
                   $(this).addClass('vc_active');
                   
                   $(".dfd-price-block-id").addClass("my-cls");
                   
                   animateMargins($(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper"));
                   var catid = li.find("a").attr('catid');
                   var dayid = $(".vc_tta-tabs-list-days li.vc_active");

                   if (typeof dayid != 'undefined' && dayid != null) {
                      dayid = dayid.attr('dayid'); 
                   } else {
                       dayid = 0;
                   }
                   
                   //$(".vc_tta-panel-body .columns.six:eq(0)").html('<div style="text-align:right"><h4 align=right>Загрузка...</h4></div>');
                   make_body2(catid,0,false,dayid);
                  
             });
             return li;
           }
           
           <?php /*include_once("menu_auxiliary.php");*/ ?>

           function make_tab_days(name,id,catid,active, day) {
             var span = $('<span class="vc_tta-title-text">');
             span.html(name);
             var a = $('<a style="z-index:1;" href="#'+id+'" catid="'+catid+'" data-vc-tabs="" data-vc-container=".vc_tta">');
             var li =$('<li style="display:inline-block!important;" class="vc_tta-tab vc_tta-tab-id-days" data-vc-tab="" dayid="'+day+'">');
             if(active) li.addClass('vc_active');
             span.appendTo(a); a.appendTo(li);
             var style = $('.dfd-price-block-id').attr('style');
             li.click(function(e){
                   if(click_id != -1) return false;
                   click_id = id;
                   e.stopPropagation();
                   e.preventDefault();
                   var sel2 = ".vc_tta-tabs-list:eq(0)";
                   var a = $(".vc_tta-tabs-list:eq(0) li.vc_active a[catid]");

                   if (a.length > 0) {
                        var cat_id = a.attr('catid');
                   } else {
                        var cat_id = 0;
                   }
                   
                   console.log(a.attr('catid'));

                   $('nav.page-nav.text-center').remove();
                   hInt = setInterval(function() { $(window).resize(); }, 400);
                   this.setAttribute('disabled','disabled');
                   $('.vc_tta-tabs-list-days li').removeClass('vc_active');
                   //this.closest(".vc_tta-tabs-container li a").setAttribute('disabled', 'disabled');
                   //$('.vc_tta-tab-id').removeClass('vc_active');
                   $(this).closest('li').addClass('vc_active');
                   
                   $(".dfd-price-block-id").addClass("my-cls");
                   
                   animateMargins($(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper"));
                   var catid = li.find("a").attr('catid');
                   
                   //$(".vc_tta-panel-body .columns.six:eq(0)").html('<div style="text-align:right"><h4 align=right>Загрузка...</h4></div>');
                   make_body2(cat_id, 0, false, day);
                  
             });
             return li;
           }
           
           function make_days_tab()
           {
                var sel2 = ".vc_tta-tabs-list:eq(0)";
                var tabsList = $("<ul class='vc_tta-tabs-list-days'>");
                var a = $(sel2).find("li.vc_active a");

                if (a.length > 0) {
                    var cat_id = a.attr('catid');
                } else {
                    var cat_id = 0;
                }

                console.log(a.attr('catid'));

                var li1 = make_tab_days('ПН','Mn', cat_id, 0, -1);
                var li2 = make_tab_days('ВТ','Tu', cat_id, 0, -2);
                var li3 = make_tab_days('СР','Wd', cat_id, 0, -3);
                var li4 = make_tab_days('ЧТ','Th', cat_id, 0, -4);
                var li5 = make_tab_days('ПТ','Fr', cat_id, 0, -5);

                $(li1).appendTo(tabsList);
                $(li2).appendTo(tabsList);
                $(li3).appendTo(tabsList);
                $(li4).appendTo(tabsList);
                $(li5).appendTo(tabsList);

                tabsList.insertBefore(sel2);
           }
           
           function animateStyle(elem, inout, style) {
               if(inout == 'in') {
                   elem.fadeIn(400);
                   setTimeout(function(){ elem.attr('style',style+"; display:block!important;");  },360);
               }
               else {
                   elem.fadeOut(400);
                   setTimeout(function(){ elem.attr('style',style+"; display:none!important;");  },360);
               }
           }
           
           var animateStatus = {".vc_tta-panel-body .columns.six":'true',"900":"yes" };
           var animateH ;
           
           //alert(animateStatus[".vc_tta-panel-body .columns.six"]);
           
           function animateMargins(selector) {
               selector.attr('style',selector.attr('style')+";backgroundColor:transparent!important;");
               animateH = setInterval(function(){
                   if(parseInt(selector.css('marginLeft')) < -46) { 
                       clearInterval(animateH); 
                       selector.find(".dfd-price-block-id").fadeOut("400");
                       setTimeout(function() { 
                           selector.css('marginLeft','0'); 
                           var style = $('.dfd-price-block-id').attr('style');
                           //$('.dfd-price-block-id').attr({"style":style+";display:none!important"});
                           $(".vc_tta-panel-body .columns.six .dfd-price-wrap").css('visibility','hidden');
                           $(".my-cls").remove();
                           //selector.find(".dfd-price-block-id").attr('style',style+";visibility:hidden!important;");
                       } , 300);
                       return true; 
                   }
                   selector.css('marginLeft', ( parseInt( selector.css('marginLeft') ) - 16 )+"px" );
               },40);
           }
           
           function animateMargins2(selector) {
               selector.attr('style',selector.attr('style')+";backgroundColor:transparent!important;");
               animateH = setInterval(function(){
                   if(parseInt(selector.css('marginLeft')) < -46) { 
                       clearInterval(animateH); 
                       selector.find(".dfd-price-block-id").fadeOut("400");
                       setTimeout(function() { 
                           selector.css('marginLeft','0'); 
                           var style = $('.dfd-price-block-id').attr('style');
                           //$('.dfd-price-block-id').attr({"style":style+";display:none!important"});
                           $(".vc_tta-panel-body .columns.six .dfd-price-wrap").css('visibility','hidden');
                           $(".my-cls").remove();
                           //$(".vc_tta-panel-body .columns.six .dfd-price-wrap").css('visibility','hidden'); 
                           $(".vc_tta-panel-body .columns.six .dfd-price-wrap").html('');
                           selector.find(".dfd-price-block-id").attr('style',style+";visibility:hidden!important;");
                       } , 300);
                       return true; 
                   }
                   selector.css('marginLeft', ( parseInt( selector.css('marginLeft') ) - 16 )+"px" );
               },40);
           }

           function make_body2(cat_id,page_id,is_navbar, day_id){
           mrg_columns =$(".vc_tta-panel-body .columns.six").css('marginLeft');
           
           var sel = ".vc_tta-panel-body .columns.six .dfd-price-wrap";
           //$(sel).html('');
           //$(window).resize();
           if(!is_navbar)  { $("div.page-nav.text-center").addClass('page-nav-oldone'); $('.page-nav-oldone').css('visibility','hidden');  }
           //$('nav.page-nav.text-center').remove();
           if(cat_id == -1) var pars = {}; else var pars = {"cat_id":cat_id};

           if (typeof day_id != 'undefined' && day_id != null) {
               pars['day_id'] = day_id;
           }
           $(".vc_tta-tabs-container li a").prop('disabled', true);
           $.get("/apis/get_prods.php",pars, function(r){
               var res = JSON.parse(r);
               var offset = 8 * page_id;
               <?php if(isset($_GET['pg']) && false): ?>
                 offset = 8 * <?php echo (intval($_GET['pg']) - 1); ?> ; 
               <?php endif; ?>
               
               var length = res.length;
               //$(".vc_tta-panel-body .columns.six")
               //$(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper").css('opacity','0');
               var nmb_steps = 8;
               if(length < offset +8) { nmb_steps = length -offset;  }
               var plus_op = parseFloat(1/nmb_steps);
               $(sel).attr('style',$(sel).attr('style')+"; visibility:hidden!important;");
               for(var i = offset; i<length; ++i) {
                  if(i == offset +8) break; 
                  
                   res[i].description = res[i].description.replace(/oiionqs1ww1s/gi,"'");
                   res[i].description = res[i].description.replace(/89h2sxbxuwiw1q/gi,'"');
                   res[i].short = res[i].short.replace(/oiionqs1ww1s/gi,"'");
                   res[i].short = res[i].short.replace(/89h2sxbxuwiw1q/gi,'"');
                  
                  var a = $('<a style="position:static;" href="'+res[i].permalink+'">');
                  var priceblock = '<div style="overflow-y:visible!important; margin-bottom:24px!important; z-index:999999!important;" class="dfd-price-block dfd-price-block-id" prod-cat-id="'+res[i].ids+'" prod-id="'+res[i].id+'" style="height: 80px;"><div class="thumb-wrap"><img src="'+res[i].image+'" alt="Список цен"></div><div class="text-wrap small-img"><div class="dfd-price-cover clearfix"><div class="price-title dfd-content-title-big" style="font-family:Merriweather; font-weight:700; font-style:normal; color: #3f3f3f !important; "> '+res[i].title+' </div><div class="price-delimeter" style="left: 152px; right: 54px; bottom: 5.4px;"></div><div class="amount-price amount dfd-content-title-big" style="font-family:Merriweather; font-weight:700; font-style:normal; color: #3f3f3f !important; "> '+res[i].price+' р. </div></div><div class="dfd-price-cover"><div class="dfd-content-subtitle" style="font-size: 14px; color: #999999 !important; font-family:Marck Script!important; "> '+res[i].short+' </div></div></div></div>';
                  $(priceblock).prependTo(a);
                  var div = $("<div style='position:relative;'>");
                  var add_cart = get_add_to_cart(res[i].id," display:none!important; position:absolute; top:10%;  left:17%; z-index:1000; background:#fff; opacity:1.0; width:290px; overflow:visible!important; white-space:nowrap!important; display:inline-block; padding:4px;");
                  var style2 = add_cart.attr('style');
                  if (true || res[i].active == 1) {
                      add_cart.prependTo(div);
                  }

                  var eq = 0;
                  var length2 = length;
                  if(length2 > offset+8) length2 = offset +8;
                  if( offset + (length2-offset)/2 <= i ) eq = 1;
                  a.prependTo(sel+":eq("+eq+")");
                  div.prependTo(sel+":eq("+eq+")");
                  var selstyle = $(sel).attr('style');
                  $(sel).attr('style',selstyle+";overflow-y:visible!important;padding-top:20px!important;");
                  $(a).hover(function() {
                     $(".addtocartcontainer").attr('style',style2+"; display:none!important;");
                     $(this).prev().find(".addtocartcontainer").eq(0).attr('style',style2+"; display:block!important;");
                  });
                  $(".addtocartcontainer").mouseleave(function() {
                     $(this).attr('style',style2+"; display:none!important;");
                  });
                  $(sel).mouseleave(function(){
                     $(".addtocartcontainer").attr('style',style2+"; display:none!important;");
                  });
                  //$(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper").css('opacity',parseFloat($(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper").css('opacity'))+ plus_op );  
               }
                //$(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper").css('opacity',1);
               //$('nav.page-nav.text-center').remove();
               var number_pages = Math.ceil(length / 8 );
               
               if(number_pages > 1) {
                   var lis = "";
                   var current_page = parseInt(page_id) +1 ;
                   var arf = [] ;
                   
                   for(var j = 1; j <= number_pages; ++j ) {
                       if(j == current_page) {
                         lis += '<li arfid="'+j+'"><span class="page-numbers current">'+j+'</span></li>';
                       }
                       else {
                         arf[j] = $('<a pgid="'+(j-1)+'" href="/?pg='+current_page+'&cat_id='+cat_id+'" catid="'+cat_id+'" >');
                         arf[j].html(j);
                         arf[j].on('click',function(e){
                             e.stopPropagation();
                             e.preventDefault();
                             if(click_id != -1) return false;
                             click_id = $(this).attr('pgid');
                             //animateMargins2($(".vc_tta-panel-body .columns.six"));
                             $(".vc_tta-panel-body .columns.six .dfd-price-wrap").css('visibility','hidden'); 
                             $(".vc_tta-panel-body .columns.six .dfd-price-wrap").html('');
                             var dayid = $(".vc_tta-tabs-list-days li.vc_active");

                             if (typeof dayid != 'undefined' && dayid != null) {
                              dayid = dayid.attr('dayid'); 
                            } else {
                               dayid = 0;
                            }
                             make_body2($(this).attr('catid'),$(this).attr('pgid'),true,dayid);
                         });
                         lis+= '<li arfid="'+j+'"></li>';
                       }
                   }
               if(current_page > 1) { 
                   var prv = $('<a pgid="'+(current_page -2)+'" catid="'+cat_id+'" href="/?pg='+(current_page - 1)+'&cat_id='+cat_id+'">Пред.</a>');
                   prv.on('click',function(e){
                        e.stopPropagation();
                        e.preventDefault();
                        if(click_id != -1) return false;
                        click_id = $(this).attr('pgid');
                        //animateMargins2($(".vc_tta-panel-body .columns.six"));
                        //$(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper").css('visibility','hidden'); 
                        $(".vc_tta-panel-body .columns.six .dfd-price-wrap").css('visibility','hidden');
                        $(".vc_tta-panel-body .columns.six .dfd-price-wrap").html('');
                        var dayid = $(".vc_tta-tabs-list-days li.vc_active");

                   if (typeof dayid != 'undefined' && dayid != null) {
                      dayid = dayid.attr('dayid'); 
                   } else {
                       dayid = 0;
                   }
                        make_body2($(this).attr('catid'),$(this).attr('pgid'),true, dayid);
                   });
               }
               else {
                   var prv = $('<a>Пред.</a>');
               }
               if(current_page < number_pages) { 
                   var nxt = $('<a pgid="'+(current_page)+'" catid="'+cat_id+'" href="/?pg='+(current_page + 1)+'&cat_id='+cat_id+'">След.</a>');
                   nxt.on('click',function(e){
                        e.stopPropagation();
                        e.preventDefault();
                        if(click_id != -1) return false;
                        click_id = $(this).attr('pgid');
                        //animateMargins2($(".vc_tta-panel-body .columns.six"));
                        $(".vc_tta-panel-body .columns.six .dfd-price-wrap").html('');
                        $(".vc_tta-panel-body .columns.six .dfd-price-wrap").css('visibility','hidden');
                        var dayid = $(".vc_tta-tabs-list-days li.vc_active");

                   if (typeof dayid != 'undefined' && dayid != null) {
                      dayid = dayid.attr('dayid'); 
                   } else {
                       dayid = 0;
                   }
                        //$(".vc_tta-panel-body .columns.six").closest(".vc-row-wrapper").css('visibility','hidden'); 
                        
                        make_body2($(this).attr('catid'),$(this).attr('pgid'),true, dayid);
                   });
               }
               else {
                   var nxt = $('<a>След.</a>');
               }
               var nav = $('<div style="clear:both; z-index:99!important; background-color:transparent!important; margin-top:2px!important; margin-bottom:12px!important;" class="page-nav text-center">');
               $('<div class="dfd-pagination dfd-pagination-style-1"><div class="dfd-prev-page"><span prvblock="prv">'+'</span><i class="dfd-socicon-arrow-left-01"></i></div>'+
	'<nav class="navigation pagination" role="navigation">'+
		'<h2 class="screen-reader-text">Навигация по записям</h2>'+
		'<div class="nav-links">'+
		'<ul class="page-numbers">'+ lis+
	      //'<li><span class="page-numbers current">1</span></li>'+
	      //'<li><a href="/page=2">2</a></li>'+
	      //'<li><a href="/page=3">3</a></li>'+
        '</ul>'+
        '</div>'+
	'</nav><div class="dfd-next-page"><span prvblock="nxt">'+'</span><i class="dfd-socicon-arrow-right-01"></i></a></div></div>').appendTo(nav);
	           for(var v =1; v<= number_pages; ++v) {
	               if(v != current_page) {
	                   arf[v].appendTo(nav.find("ul.page-numbers li[arfid='"+v+"']"));
	               }
	           }
	           prv.appendTo(nav.find("span[prvblock='prv']"));
	           nxt.appendTo(nav.find("span[prvblock='nxt']"));
	           if(is_navbar) { $("div.page-nav.text-center").replaceWith(nav);  }
	           else { $('.page-nav-oldone').remove(); nav.insertBefore(".vc_tta-panel-body .columns.six:eq(0)"); }
	          
               }
             
             click_id = -1;
             clearInterval(hInt);
             //$(".vc_tta-panel-body .columns.six").css('visibility','hidden');
             $(sel).fadeIn(400);
             setTimeout(function(){   $(window).resize(); $(".vc_tta-panel-body .columns.six .dfd-price-wrap").css('visibility','visible'); var selector = $('.vc_tta-panels-container .vc_tta-panels .vc_tta-panel');selector.attr('style',selector.attr('style')+"; visibility:visible!important;"); }, 400);  
           });
          
          $(".vc_tta-panel-body .columns.six").css('backgroundColor','white');
          $(".vc_tta-tabs-container li a").prop('disabled', false);
           } 
           
           
           
           
           var sel2 = ".vc_tta-tabs-list:eq(0)";
           
           //var li2 = make_tab('ПН','Mn', '1', 0);
           //$(li2).appendTo(sel2);
           
           make_days_tab();
           
           <?php  for($i=0;$i<count($prods['cats']);++$i): ?>
               li = make_tab("<?= $prods['cats'][$i]['name'] ?>","<?= $prods['cats'][$i]['slug'].'-'.$prods['cats'][$i]['id'] ?>","<?= $prods['cats'][$i]['id'] ?>",<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] == $prods['cats'][$i]['id'] ) echo true; else echo false; ?>);
              
               $(li).appendTo(sel2);
              
           <?php endfor; ?>
           $("div.page-nav.text-center").remove();
           make_body2(<?php if(isset($_GET['cat_id'])) echo $_GET['cat_id']; else echo '-1'; ?>,<?php if(isset($_GET['pg'])) echo (intval($_GET['pg']) -1); else echo '0';  ?>,false);
           
        });
    </script>
<?php else: ?>
<script>
    alert("Prods are not set");
</script>
<?php endif; ?>





<?php else: ?>



<?php 
    if(isset($_GET['cat_id']) && $_GET['cat_id']!='-1'):
    function filter_arr($var) {
        return ($var['ids'][0] == $_GET['cat_id'] );
    }
    $prods2 =$prods['cats'];
    $prods = array_values( array_filter($prods,'filter_arr') );
    $prods['cats'] = $prods2;
    //echo "<br/>---prods2---<br/>";
    //print_r($prods);
    endif;
    //echo "Number posts : ".count($prods)."<br/>";
    $number_posts = count($prods) < 8 ? count($prods) - 1 : 7;
?>
<?php if(!empty($prods)  ): ?>
    <style>
        .dfd-price-block, .vc_tta-tab { display:none!important;  }
        .dfd-price-block-id { display:block!important; }
        .vc_tta-tab-id { display:inline-block!important; }
        .vc_tta-panel-body .columns.six .dfd-price-wrap: hover {
            
        }
    </style>
    <script>
        jQuery(function($){
            
        var hInt = setInterval(function() { $(window).resize(); }, 400);
        //setTimeout(function() { clearInterval(hInt); setTimeout(function(){   $(window).resize(); }, 1000);  }, 3000);
        function get_add_to_cart(id,style) {
          var form = $('<form  class="cart" style="background:transparent!important;" method="post" enctype="multipart/form-data">');
          $('<div style="background:transparent!important;" class="single-product-buttons"><div style="background:transparent!important;" class="single_add_to_cart_button_wrap">	<div style="background:transparent!important;" class="quantity"><i style="background:transparent!important; font-weight:bold!important;" class="dfd-socicon-minus-symbol minus"></i><input type="number" style="font-weight:bold!important;" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Кол-во" size="4" pattern="[0-9]*" inputmode="numeric"><i style="font-weight:bold!important;" class="dfd-socicon-plus-black-symbol plus"></i></div><button type="submit" name="add-to-cart" value="'+id+'" class="single_add_to_cart_button button alt" data-quantity="1">Добавить в корзину</button></div></div>').appendTo(form);
          
          form.find(".minus").click(function(e) {
               e.stopPropagation();
                   e.preventDefault();
            var qty = $(this).parents("form").eq(0).find(".input-text.qty");
            var value = parseInt(qty.val());
            if(value != undefined && value != null && value != NaN && value > 1) value = --value;
            else value = 1;
            qty.val(value);
          });
        
          form.find(".plus").click(function(e){
               e.stopPropagation();
                   e.preventDefault();
            var qty = $(this).parents("form").eq(0).find(".input-text.qty");
            var value = parseInt(qty.val());
            if(value != undefined && value != null && value != NaN && value > 0) value = ++value;
            else value = 1;
            qty.val(value);
          });    
          
          form.find("button").click(function(e) {  e.stopPropagation(); });
          
          form.on('submit',function(e){
            e.stopPropagation();  
            e.preventDefault();
            //alert($(this).serialize());
            var a =$('<a style="display:none!important;" rel="nofollow" href="/shop/?add-to-cart='+id+'" data-quantity="'+$(this).find(".input-text.qty").val()+'" data-product_id="'+id+'" data-product_sku="" class="add_to_cart_button_al button product_type_simple add_to_cart_button ajax_add_to_cart added">Добавить в корзину</a>');
            a.appendTo($(this));
            $(this).find("a.add_to_cart_button_al").click();
            $(this).find("a.add_to_cart_button_al").remove(); 
            
            setTimeout(function() { 

               $.get("/apis/get_cart_items.php", function(res) {
  var r = JSON.parse(res);
  var cart = $(".total_cart_header");
  cart.find(".woo-cart-details").html(r.total);
  $("ul.cart_list.product_list_widget li").remove();
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
var remove = $('<a data-id="'+r[t].id+'" href="http://restaurant.ecreater.ru/cart/?remove_item=74d1420077a5da8ed985b0c26f128c27&amp;_wpnonce=90e7d1f335" class="remove" title="Удалить эту позицию" data-product_id="23160" data-product_sku="">×</a>');

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

var btn = form.find('button'); btn.removeAttr('disabled'); btn.find("a").css('pointerEvents','auto'); btn.find("a").html('Просмотр корзины'); },400);
             $(this).find("button").on('click', function(e) { e.stopPropagation(); e.preventDefault(); location.href = "<?php echo wc_get_cart_url(); ?>";  } );
            $(this).find("button").attr('disabled','disabled');
            $(this).find("button").html("<a style='pointer-events:none;'>Обработка...</a>");
          });
           var container = $('<div class="addtocartcontainer" data-id="'+id+'-add-to-cart" style="'+style+'">');
           form.appendTo(container);
           return container;
        }
            
           var click_id = -1;
           
           function make_tab2(name,id,catid,active) {
             var span = $('<span class="vc_tta-title-text">');
             span.html(name);
             var a = $('<a style="z-index:1;" href="#'+id+'" catid="'+catid+'" data-vc-tabs="" data-vc-container=".vc_tta-container">');
             var h4 =$("<h4 class='vc_tta-panel-title'>");
             span.appendTo(a);
             a.appendTo(h4);
             var dv = $("<div class='vc_tta-panel-heading'>");
             h4.appendTo(dv);
             if(active) {  $(".vc_tta-panel").removeClass('vc_active');    dv.parent().addClass('vc_active'); }
             
             dv.click(function(e){
                  e.stopPropagation();
                   e.preventDefault();
                 $(".vc_tta-panel").removeClass('vc_active');  
                 $(this).parent().addClass('vc_active');
                 $(".vc_tta-panel .vc_tta-panel-body").attr('style','display:none!important; opacity:0!important');
                 var panel_body = $(this).parents(".vc_tta-panel").eq(0).find(".vc_tta-panel-body");
                 panel_body.attr('style',panel_body.attr('style')+"; display:inline-block!important; opacity:1!important;");
             });
             return dv;
           }
           
           function make_body_back(number_pages,page_id,cat_id) {
               var panel_body = $("<div class='vc_tta-panel-body'>");
               var div = $('<div class="dfd-spacer-module" data-units="px" data-wide_size="25" data-normal_resolution="1024" data-normal_size="" data-tablet_resolution="800" data-tablet_size="" data-mobile_resolution="480" data-mobile_size="" style="height: 25px;"></div>');
               var columns = $("<div class='columns six'>");
               var wrap = $("<div class='row wpb_row'>");
               var wrapper = $("<div class='wpb_wrapper'>");
               var price_wrap = $("<div class='dfd-price-wrap'>");
               var fluid =$("<div class='vc-row-wrapper vc_inner vc_row-fluid'>");
               price_wrap.appendTo(wrapper);
               wrapper.appendTo(columns);
               columns.appendTo(wrap);
               wrap.appendTo(fluid);
               fluid.appendTo(panel_body);
               div.prependTo(panel_body);
               
                if(number_pages > 1 && false ) {
                   var lis = "";
                   var current_page = page_id +1 ;
                   for(var j = 1; j <= number_pages; ++j ) {
                       if(j == current_page)
                         lis += '<li><span class="page-numbers current">'+j+'</span></li>';
                       else
                         lis+= '<li><a href="/?pg='+j+'&cat_id='+cat_id+'">'+j+'</a></li>';
                   }
                   alert(lis);
               if(current_page > 1) var prv = '<a href="/?pg='+(current_page - 1)+'&cat_id='+cat_id+'">Пред.</a>'; else var prv = 'Пред.';
               if(current_page < number_pages) var nxt = '<a href="/?pg='+(current_page + 1)+'&cat_id='+cat_id+'">След.</a>'; else var nxt = 'След.';
               var nav = $('<div style="clear:both; text-align:center!important; z-index:99999!important; background-color:white;" class="page-nav text-center">');
              $('<div class="dfd-pagination dfd-pagination-style-1"><div class="dfd-prev-page"><span>'+prv+'</span><i class="dfd-socicon-arrow-left-01"></i></div>'+
	'<nav class="navigation pagination" role="navigation">'+
		'<h2 class="screen-reader-text">Навигация по записям</h2>'+
		'<div class="nav-links">'+
		'<ul class="page-numbers">'+ lis+
	      //'<li><span class="page-numbers current">1</span></li>'+
	      //'<li><a href="/page=2">2</a></li>'+
	      //'<li><a href="/page=3">3</a></li>'+
        '</ul>'+
        '</div>'+
	'</nav><div class="dfd-next-page"><span>'+nxt+'</span><i class="dfd-socicon-arrow-right-01"></i></a></div></div>').appendTo(nav);
	           nav.appendTo(panel_body);
	           //alert(body_back.find('nav').css('color'));
               }
               
               
               return panel_body;
           }
        
        var prodsLoading = false;    
           function make_tab(name,id,catid,active) {
  var span = $('<span class="vc_tta-title-text">');
             span.html(name);
             var a = $('<a style="z-index:1;" href="#'+id+'" catid="'+catid+'" data-vc-tabs="" data-vc-container=".vc_tta">');
             var li =$('<li class="vc_tta-tab vc_tta-tab-id" data-vc-tab="">');
             if(active) li.addClass('vc_active');
             span.appendTo(a); a.appendTo(li);
             var style = $('.dfd-price-block-id').attr('style');
             li.click(function(e){
                   if(click_id != -1) return false;
                   click_id = id;
                   e.stopPropagation();
                   e.preventDefault();
                   $('nav.page-nav.text-center').remove();
                   hInt = setInterval(function() { $(window).resize(); }, 400);
                   this.setAttribute('disabled','disabled');
                   $('.vc_tta-tab-id').removeClass('vc_active');
                   $(this).addClass('vc_active');
                   $('.dfd-price-block-id').attr({"style":style+";display:none!important"});
                   var catid = li.find("a").attr('catid');
                   //$(".vc_tta-panel-body .columns.six:eq(0)").html('<div style="text-align:right"><h4 align=right>Загрузка...</h4></div>');
                   prodsLoading = true;
                  
                   $(this).closest('.vc_tta-tabs-container').prop('disabled', 'true');
                   make_body2(catid,0);
                  
             });
             return li;
           } 
           
            
           
           function animateStyle(elem, inout, style) {
               if(inout == 'in') {
                   elem.fadeIn(400);
                   setTimeout(function(){ elem.attr('style',style+"; display:block!important;");  },360);
               }
               else {
                   elem.fadeOut(400);
                   setTimeout(function(){ elem.attr('style',style+"; display:none!important;");  },360);
               }
           }

        function make_body2(cat_id,page_id,selector){
           var body_back = $("<span class='spec_class'>");
           //return body_back;
           if(cat_id == -1) var pars = {}; else var pars = {"cat_id":cat_id};
           $.ajax({ url:"/apis/get_prods.php", data:pars, method: "GET", async:false, success: function(r){
               var res = JSON.parse(r);
               
              
               
               var offset = 0;
               offset = 8 * page_id ;
               
               var length = res.length;
               //alert("length");
               for(var i = offset; i<length; ++i) {
                  if(i == offset +8) break; 
                  
                   res[i].description = res[i].description.replace(/oiionqs1ww1s/gi,"'");
                   res[i].description = res[i].description.replace(/89h2sxbxuwiw1q/gi,'"');
                   res[i].short = res[i].short.replace(/oiionqs1ww1s/gi,"'");
                   res[i].short = res[i].short.replace(/89h2sxbxuwiw1q/gi,'"');
                  
                  var a = $('<a style="position:static;" href="'+res[i].permalink+'">');
                  var price_amount = $('<div class="amount-price amount dfd-content-title-big" style="font-family:Merriweather; font-weight:700; font-style:normal; color: #3f3f3f !important;display:block!important; margin-right:40px!important; "> '+res[i].price+' р. </div>');
                  var priceblock = $('<div class="dfd-price-block dfd-price-block-id" prod-cat-id="'+res[i].ids+'" prod-id="'+res[i].id+'" style="height: 80px; margin-bottom:20px!important;"><div class="thumb-wrap"><img style="width:70px!important; height:80px!important;" src="'+res[i].image+'" alt="Список цен"></div><div style="" class="text-wrap small-img"><div class="dfd-price-cover clearfix"><div class="price-title dfd-content-title-big" style="font-family:Merriweather; font-weight:700; font-style:normal; color: #3f3f3f !important; margin-left:0px!important; overflow:visible!mportant; float:left!important; width:300px!important; "> '+res[i].title+' </div><div style=""></div><div class="price-delimeter" style="left: 152px; right: 54px; bottom: 5.4px;"></div>    </div><div class="dfd-price-cover"><div class="dfd-content-subtitle" style="font-size: 14px; color: #999999 !important; font-family:Marck Script!important; "> '+res[i].short+' </div></div></div></div>');
                  price_amount.appendTo(priceblock.find(".dfd-price-cover.clearfix"));
                  priceblock.prependTo(a);
                  price_amount.click(function(e){
                      e.stopPropagation();
                      e.preventDefault();
                      var element = $(this).parents("a").eq(0).prev().find(".addtocartcontainer").eq(0);
                      var style2 = element.attr('style');
                      if(element.css('display') == 'none') {
                        $(".addtocartcontainer").attr('style',style2+"; display:none!important;");
                        element.attr('style',style2+"; display:block!important;");
                      }
                      else {
                        element.attr('style',style2+"; display:none!important;");  
                      }
                  });
                  var div = $("<div style='position:relative;'>");
                  var add_cart = get_add_to_cart(res[i].id," display:none!important; position:absolute; top:6%;  left:0%; z-index:1000; background:#fff; opacity:1.0; width:290px; overflow:visible!important; white-space:nowrap!important; display:inline-block; padding:4px;");
                  var style2 = add_cart.attr('style');
                  add_cart.prependTo(div);
                  var eq = 0;
                  var length2 = length;
                  if(length2 > offset+8) length2 = offset +8;
                  if( offset + (length2-offset)/2 <= i ) eq = 1;
                  a.prependTo(body_back);
                  div.prependTo(body_back);
                  $(a).hover(function() {
                    
                  });
                  $(".addtocartcontainer").mouseleave(function() {
                     $(this).attr('style',style2+"; display:none!important;");
                  });
                  $(selector).mouseleave(function(){
                     $(".addtocartcontainer").attr('style',style2+"; display:none!important;");
                  });
                   
               }
              
               $('nav.page-nav.text-center').remove();
               var number_pages = Math.ceil(length / 8 );
               //alert(number_pages);
               
               if(number_pages > 1) {
                   var lis = "";
                   var current_page = parseInt(page_id) +1 ;
                   var arf = [] ;
                   for(var j = 1; j <= number_pages; ++j ) {
                       if(j == current_page)
                         lis += '<li arfid="'+j+'"><span class="page-numbers current">'+j+'</span></li>';
                       else {
                         //lis+= '<li><a href="/?pg='+j+'&cat_id='+cat_id+'">'+j+'</a></li>';
                         var j1 = parseInt(j)-1;
                         arf[j] = $('<a pgid="'+j1+'" href="/?pg='+current_page+'&cat_id='+cat_id+'" catid="'+cat_id+'" >');
                         arf[j].html(j);
                         arf[j].on('click',function(e){
                             e.stopPropagation();
                             e.preventDefault();
                             if(click_id != -1) return false;
                             click_id = $(this).attr('pgid');
                             var selecto2 = make_body2($(this).attr('catid'),$(this).attr('pgid'),"<div>");
                             //$("<div class='erreerre'>").appendTo(selecto2);
                             $(this).closest(".spec_class").replaceWith(selecto2);
                             //selecto2.insertAfter($(this).parents(".spec_class").eq(0));
                             //alert(selecto2.html());
                         });
                         lis+= '<li arfid="'+j+'"></li>';
                       }
                   }
                   //alert(lis);
               //if(current_page > 1) var prv = '<a href="/?pg='+(current_page - 1)+'&cat_id='+cat_id+'">Пред.</a>'; else var prv = 'Пред.';
               //if(current_page < number_pages) var nxt = '<a href="/?pg='+(current_page + 1)+'&cat_id='+cat_id+'">След.</a>'; else var nxt = 'След.';
                if(current_page > 1) { 
                   var prv = $('<a pgid="'+(current_page -2)+'" catid="'+cat_id+'" href="/?pg='+(current_page - 1)+'&cat_id='+cat_id+'">Пред.</a>');
                   prv.on('click',function(e){
                        e.stopPropagation();
                        e.preventDefault();
                        if(click_id != -1) return false;
                        click_id = $(this).attr('pgid');
                        var selecto = make_body2($(this).attr('catid'),$(this).attr('pgid'),make_body_back(2,0,23));
                        $(this).parents(".spec_class").eq(0).replaceWith(selecto);
                   });
               }
               else {
                   var prv = $('<a>Пред.</a>');
               }
               if(current_page < number_pages) { 
                   var nxt = $('<a pgid="'+(current_page)+'" catid="'+cat_id+'" href="/?pg='+(current_page + 1)+'&cat_id='+cat_id+'">След.</a>');
                   nxt.on('click',function(e){
                        e.stopPropagation();
                        e.preventDefault();
                        if(click_id != -1) return false;
                        click_id = $(this).attr('pgid');
                        var selecto = make_body2($(this).attr('catid'),$(this).attr('pgid'),make_body_back(2,0,23));
                        $(this).parents(".spec_class").eq(0).replaceWith(selecto);
                   });
               }
               else {
                   var nxt = $('<a>След.</a>');
               }
               var nav = $('<div style="clear:both; width:300px!important; margin-right:10%!important; z-index:99999!important; background-color:white;" class="page-nav text-center">');
               $('<div class="dfd-pagination dfd-pagination-style-1"><div class="dfd-prev-page"><span prvblock="prv">'+'</span><i class="dfd-socicon-arrow-left-01"></i></div>'+
	'<nav class="navigation pagination" role="navigation">'+
		'<h2 class="screen-reader-text">Навигация по записям</h2>'+
		'<div class="nav-links">'+
		'<ul class="page-numbers">'+ lis+
	      //'<li><span class="page-numbers current">1</span></li>'+
	      //'<li><a href="/page=2">2</a></li>'+
	      //'<li><a href="/page=3">3</a></li>'+
        '</ul>'+
        '</div>'+
	'</nav><div class="dfd-next-page"><span prvblock="nxt">'+'</span><i class="dfd-socicon-arrow-right-01"></i></a></div></div>').appendTo(nav);
	           for(var v =1; v<= number_pages; ++v) {
	               if(v != current_page) {
	                   arf[v].appendTo(nav.find("ul.page-numbers li[arfid='"+v+"']"));
	               }
	           }
	           prv.appendTo(nav.find("span[prvblock='prv']"));
	           nxt.appendTo(nav.find("span[prvblock='nxt']"));
	           nav.prependTo(body_back);
	           //alert(body_back.find('nav').css('color'));
               }
             click_id = -1;
             clearInterval(hInt); setTimeout(function(){   $(window).resize(); }, 400);  
           } });
          return body_back;
           }
           
          var panel = ".vc_tta-panel:eq(0)";
          var dvb = $("<div class='vc_tta-panel vc_tta-panel-new'>");
          var item = $("<div>hgghghgh</div>");
          //item.appendTo(dvb);
           <?php  for($i=0;$i<count($prods['cats']);++$i): ?>
               
               li = make_tab2("<?= $prods['cats'][$i]['name'] ?>","<?= $prods['cats'][$i]['slug'].'-'.$prods['cats'][$i]['id'] ?>","<?= $prods['cats'][$i]['id'] ?>",<?php if(isset($_GET['cat_id']) && $_GET['cat_id'] == $prods['cats'][$i]['id'] ) echo true; else echo false; ?>);
              
               li.appendTo(dvb);
               var selecto = make_body2(<?= $prods['cats'][$i]['id'] ?>,<?php if(isset($_GET['pg'])) echo (intval($_GET['pg']) -1); else echo '0';  ?>,make_body_back(2,0,23));
               var body_back = make_body_back(2,0,23);
               
               selecto.appendTo(body_back.find(".vc_row-fluid .columns.six .dfd-price-wrap"));

               
               
              
               body_back.appendTo(dvb);
               dvb.insertBefore(panel);
               
             <?php if(isset($_GET['cat_id']) && $prods['cats'][$i]['id'] == $_GET['cat_id'] ): ?>
               
                   //alert('iuui');
                 //$(".vc_tta-panel").removeClass('vc_active');  
                 li.parents(".vc_tta-panel").addClass('vc_active');
                 //$(".vc_tta-panel-body").attr('style',$(".vc_tta-panel-body").attr('style')+";display:none!important;opacity:0!important;");
                 var panel_body = li.parent().eq(0).find(".vc_tta-panel-body");
                 panel_body.attr("style","display:inline-block!important; opacity:1!important;");
              
             <?php endif; ?>
               
           <?php endfor; ?>
           $(".vc_tta-panel").hide();
           $(".vc_tta-panel-new").css({'display':'block'});
           
        });
    </script>
<?php else: ?>
<script>
    alert("Prods are not set");
</script>
<?php endif; ?>

<?php endif; ?>
