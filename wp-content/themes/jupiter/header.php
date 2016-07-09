<!DOCTYPE html>

<html <?php echo language_attributes();?> >

<head>

    <?php wp_head(); ?>

    

    <style>

	.shop-flat-btn{

color: #ffffff !important;

text-decoration: none !important;

background-color:#999 !important;

}



.woocommerce .widget_shopping_cart .buttons .mk-button.cart-widget-btn, .woocommerce-page .widget_shopping_cart .buttons .mk-button.cart-widget-btn, .woocommerce-page.widget_shopping_cart .buttons .mk-button.cart-widget-btn, .woocommerce.widget_shopping_cart .buttons .mk-button.cart-widget-btn {

color: #ffffff !important;

text-decoration: none !important;

background-color:#999 !important;

}

.order-status{

font-size:12px !important;

}

</style>



<script>

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');



  ga('create', 'UA-77302246-1', 'auto');

  ga('send', 'pageview');



</script>





<!-- Hotjar Tracking Code for http://www.purgeorsplurge.com -->

<script>

    (function(h,o,t,j,a,r){

        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};

        h._hjSettings={hjid:241194,hjsv:5};

        a=o.getElementsByTagName('head')[0];

        r=o.createElement('script');r.async=1;

        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;

        a.appendChild(r);

    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');

</script>

</head>



<body <?php body_class(mk_get_body_class(global_get_post_id())); ?> <?php echo get_schema_markup('body'); ?> data-adminbar="<?php echo is_admin_bar_showing() ?>">



	<?php

		// Hook when you need to add content right after body opening tag. to be used in child themes or customisations.

		do_action('theme_after_body_tag_start');

	?>



	<!-- Target for scroll anchors to achieve native browser bahaviour + possible enhancements like smooth scrolling -->

	<div id="top-of-page"></div>



		<div id="mk-boxed-layout">



			<div id="mk-theme-container" <?php echo is_header_transparent('class="trans-header"'); ?>>



				<?php mk_get_header_view('styles', 'header-'.get_header_style());