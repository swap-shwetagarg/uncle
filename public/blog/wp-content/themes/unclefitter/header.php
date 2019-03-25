<?php
/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.3
 * @filesource     wp-content/themes/responsive/header.php
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

?>
	<!doctype html>
	<!--[if !IE]>
	<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7 ]>
	<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8 ]>
	<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 9 ]>
	<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.1">

		<link rel="profile" href="http://gmpg.org/xfn/11"/>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

		<?php wp_head(); ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/core/js/masonry.pkgd.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/core/js/masonry.pkgd.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.author-like').click(function() {
				  jQuery(this).find('a').toggleClass('liked');
				});

                 jQuery(".cat-post-item .cat-post-crop").append('<span class="letestpost-overlay"></span>');

                 jQuery(document).ready(function () {
				    jQuery(document).on('click', 'button.navbar-toggle', function () {
				        jQuery('.menu-overlay').toggleClass('togggle');
				    });
				});
                 jQuery('button.navbar-toggle').on('click', function(){
                 	 jQuery(this).toggleClass('current-icon');
				    jQuery('#myNavbar').toggleClass('current');
				});

			});

			 if (jQuery(window).width() > 649) {
	            jQuery(window).load(function(){
					// event gallery
					jQuery('.postgallery-masonary').masonry({
				    itemSelector: '.grid-item',
				    percentPosition: true
				   
				 });
		       });
	         }
		</script>
	</head>

<body <?php body_class(); ?>>
<div class="site-wr">
 <div class="menu-overlay"></div>
<?php responsive_header(); // before header hook ?>
	<div id="header">
         <div class="center-wr clearfix">
		<?php responsive_header_top(); // before header content hook ?>

		<?php if ( has_nav_menu( 'top-menu', 'responsive' ) ) {
			wp_nav_menu( array(
				'container'      => '',
				'fallback_cb'    => false,
				'menu_class'     => 'top-menu',
				'theme_location' => 'top-menu'
			) );
		} ?>

		<?php responsive_in_header(); // header hook ?>
		<nav class="navbar navbar-inverse">
	         <div class="navbar-header">
				<button class="navbar-toggle" data-target="#myNavbar"  type="button">
				<i class="fa fa-bars" aria-hidden="true"></i>
				<i class="fa fa-times" aria-hidden="true"></i>
				</button>
			</div>
		    <div id="myNavbar" class="navbar-collapse collapse" style="height: 0px;">
								
					<?php wp_nav_menu( array(
						'container'       => 'div',
						'container_class' => 'main-nav',
						'fallback_cb'     => 'responsive_fallback_menu',
						'theme_location'  => 'header-menu'
					) ); ?>

					<?php if ( has_nav_menu( 'sub-header-menu', 'responsive' ) ) {
						wp_nav_menu( array(
							'container'      => '',
							'menu_class'     => 'sub-header-menu',
							'theme_location' => 'sub-header-menu'
						) );
					} ?>
			</div>
		</nav>
		<?php if ( get_header_image() != '' ) : ?>

			<div id="logo">
				<a href="<?php echo home_url( '/' ); ?>"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
			</div><!-- end of #logo -->

		<?php endif; // header image was removed ?>

		<?php if ( !get_header_image() ) : ?>

			<div id="logo">
				<span class="site-name"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
				<span class="site-description"><?php bloginfo( 'description' ); ?></span>
			</div><!-- end of #logo -->

		<?php endif; // header image was removed (again) ?>

		<?php wp_nav_menu( array(
			'container'       => 'div',
			'container_class' => 'main-nav',
			'fallback_cb'     => 'responsive_fallback_menu',
			'theme_location'  => 'header-menu'
		) ); ?>

		<?php if ( has_nav_menu( 'sub-header-menu', 'responsive' ) ) {
			wp_nav_menu( array(
				'container'      => '',
				'menu_class'     => 'sub-header-menu',
				'theme_location' => 'sub-header-menu'
			) );
		} ?>

		<?php responsive_header_bottom(); // after header content hook ?>

	</div><!-- end of #header -->
 </div>
<?php responsive_header_end(); // after header container hook ?>


