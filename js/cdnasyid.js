(function(){!function($){var t,r,o;return o=["accent","turquoise","green","blue"],$(".woocommerce .widget").each(function(t){var r;return r=$(this),r.addClass("cdnclr-"+o[t%4])}),r=$("body").hasClass("rtl"),t=$(window),SWIFT.woocommerce._fullWidthShopSetSidebarHeight=SWIFT.woocommerce.fullWidthShopSetSidebarHeight,SWIFT.woocommerce.fullWidthShopSetSidebarHeight=function(){},SWIFT.woocommerce._shopLayoutSwitch=SWIFT.woocommerce.shopLayoutSwitch,SWIFT.woocommerce.shopLayoutSwitch=function(){var t;return t=!1,jQuery(document).on("click","a.layout-opt",function(r){var o,e,i,n;return i=jQuery("#products"),n=jQuery(this).data("layout"),o=i.find(".product").first().data("width"),e=jQuery(".inner-page-wrap").hasClass("has-no-sidebar")?"col-sm-sf-5":"col-sm-3",("gallery"===jQuery(this).parent().data("display-type")||"gallery-bordered"===jQuery(this).parent().data("display-type"))&&(e="col-sm-2"),t?void 0:(t=!0,i.animate({opacity:0},400),setTimeout(function(){return i.find(".product").removeClass("product-layout-standard product-layout-list product-layout-grid product-layout-solo"),i.find(".product").addClass("product-layout-"+n),jQuery(".product-grid").length>0&&(jQuery(".product-grid").children().css("min-height","0"),"grid"===n&&(i.find(".product").removeClass(o).addClass(e),i.find(".product").css("min-height","0")),("standard"===n||"solo"===n)&&i.find(".product").removeClass(e).addClass(o),"list"===n&&i.find(".product").css("height","auto"),"list"!==n&&"solo"!==n&&jQuery(".product-grid").children().matchHeight({target:jQuery(".product-grid").children().first()})),i.isotope("layout"),i.animate({opacity:1},400),t=!1},500),r.preventDefault())})}}(jQuery),jQuery(function($){var t,r;return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)||$("#home-hero").append($('<div class="mouse"><div class="mouse-icon"><span class="mouse-wheel"></span></div></div>')),$().select2&&($("select.orderby").select2({minimumResultsForSearch:1/0}),$(".shipping-calculator-form select").select2(),$(".woocommerce .widget select").select2()),$("figure .cart-overlay .shop-actions > *").addClass("shop-action"),r=function(){return $(".woocommerce .products .product").each(function(){var t,r,o,e,i,n;return t=$(this).find(".product-by"),e=t.find(".product-by-by"),r=t.find(".product-by-artist"),t.length?(n=t.outerWidth(),i=e.outerWidth(),o=n-i-2,r.css({"max-width":o+"px"})):void 0})},r(),$(window).smartresize(r),t=$(".tax-product_cat .term-description"),t.length&&$(".tax-product_cat h1.entry-title").after("<h3>"+t.html()+"</h3>"),$(".search-results .heading-text h1.entry-title").each(function(){var t;return $(this).data("orig-text",$(this).text()),t=$(this).text().split(/:\s/),$(this).text(t[0]).append($("<h3>For the keyword <em>"+t[1]+"</em></h3>"))}),$(".form-group input, .form-group textarea").each(function(){var t;return t=$(this),t.focus(function(){return t.closest(".form-group").addClass("focus")}),t.blur(function(){return t.closest(".form-group").removeClass("focus")})}),$(".wpcf7-form-control-wrap input").each(function(){return $(this).parent().before(this)})}),jQuery(function($){var t,r,o,e,i,n,c,a,s,u;return tinycolor.prototype.isHalfDark=function(){return this.getBrightness()<192},tinycolor.prototype.isHalfLight=function(){return!this.isHalfDark()},u=function(t){return t.sort(function(t,r){return t.getLuminance()>r.getLuminance()}).reverse()},r=function(t){var r;return r=u(t),r.pop()},n=function(t){return u(t)[0]},o=function(t){var o;return o=null,$.each(t,function(t,r){return r.isDark()?(o=r,!1):void 0}),null===o&&(o=r(t)),o},e=function(t){var r;return r=null,$.each(t,function(t,o){return o.isLight()?(r=o,!1):void 0}),null===r&&(r=n(t)),r},c=function(t,r){var o,e;return o=new ColorThief,e=o.getPalette(t,r),null!==e?e.map(function(t){return tinycolor({r:t[0],g:t[1],b:t[2]})}):!1},t=function(t){var r;return r=t[0],r.isLight()&&(r=o(t)),r},i=function(t){var r;return r=t[0],r.isDark()&&(r=e(t)),r},a=function(){return $(".bg-dark .products .product").addClass("dark"),$(".woocommerce .products .product").each(function(){var r,o,e;return r=$(this),e=r.hasClass("dark"),o=r.find(".first-image img")[0],null!=o?$(o).imagesLoaded(function(){var n,a,s,u,d,l;return u=r.find(".product-details"),d=r.find(".product-details h3 a"),n=r.find(".product-details h3 a small strong"),(l=c(o,4))?(s='<div class="colorful-bar clearfix">',l.forEach(function(t){return s+='<div class="col-xs-3" style="background: '+tinycolor(t).toRgbString()+'"></div>'}),s+="</div>",u.before(s),a=e?i(l):t(l),u.css({color:a.toRgbString()}),n.css({"border-color":a.setAlpha(.5).toRgbString()})):void 0}):void 0})},a(),(s=function(){return $(".woocommerce.single-product").each(function(){var r,o;return r=$(this).addClass("product-fw-split"),o=r.find("#product-img-slider img:first")[0],null!=o?$(o).imagesLoaded(function(){var e,i,n,a,s,u,d,l;return u=$(".product-fw-split .product-main"),l=r.find(".summary"),d=r.find("h1.product_title"),s=d.find("small strong"),e=r.find(".woocommerce-breadcrumb"),(a=c(o,4))?(n='<div class="colorful-bar clearfix">',a.forEach(function(t){return n+='<div class="col-xs-3" style="background: '+tinycolor(t).toRgbString()+'"></div>'}),n+="</div>",l.prepend(n),i=t(a),u.css({cssText:"background-color: "+a[0].toRgbString()+" !important; "}),l.css({color:i.toRgbString()}),d.css({color:i.toRgbString()}),l.find(".nav-previous, .nav-next").css({"border-color":i.lighten(40).toRgbString()}),l.addClass("colored")):void 0}):void 0})})()})}).call(this);