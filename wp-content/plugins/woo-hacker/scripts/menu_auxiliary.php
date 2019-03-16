<!--<script>-->
    console.log('ttt');
    function make_tab_days(name,id,catid,active) {
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

                var li2 = make_tab_days('ПН','Mn', cat_id, 0, -1);
                var li3 = make_tab_days('ВТ','Tu', cat_id, 0, -2);

                /*$(li2).click(function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    console.log('day query');
                    return true;

                });*/

                $(li2).appendTo(tabsList);
                $(li3).appendTo(tabsList);
                tabsList.insertBefore(sel2);
           }
});

<!--</script>--> 