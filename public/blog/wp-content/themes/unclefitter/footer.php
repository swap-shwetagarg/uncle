<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Template
 *
 *
 * @file           footer.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.2
 * @filesource     wp-content/themes/responsive/footer.php
 * @link           http://codex.wordpress.org/Theme_Development#Footer_.28footer.php.29
 * @since          available since Release 1.0
 */

/*
 * Globalize Theme options
 */
global $responsive_options;
$responsive_options = responsive_get_options();
?>
<div id="footer" class="clearfix">
	<?php responsive_footer_top(); ?>

	<div id="footer-wrapper">
       <div class="footer-top clearfix">
           <div class="center-wr">
		      <?php get_sidebar( 'footer' ); ?>
		   </div>
        </div>
       <div class="footer-bottom">
           <div class="center-wr">
	        <div class="ft-bottom-uppersec clearfix">
           	   <div class="ft-bottom-left">
           	   	    <?php dynamic_sidebar( 'footer-right' ); ?>
           	   </div>
           	   <div class="ft-bottom-right">
           	   	   <?php dynamic_sidebar( 'footer-contact' ); ?>
           	   </div>
	        </div>
		
	        <div class="ft-bottom-lowersec clearfix">
				<div class="copyright">
					<?php esc_attr_e( '&copy;', 'responsive' ); ?> <?php echo date( 'Y' ); ?><a id="copyright_link" href="https://www.unclefitter.com/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
						<?php bloginfo( 'name' ); ?>
					</a>All rights reserved.
				</div><!-- end of .copyright -->
				<div class="socialicon social">
					 <?php dynamic_sidebar( 'footer-social' ); ?>
				</div>
	        </div>
          </div>
       </div>
	</div><!-- end #footer-wrapper -->

	<?php responsive_footer_bottom(); ?>
</div><!-- end #footer -->
</div> <!-- site-wr -->
<?php responsive_footer_after(); ?>

<?php wp_footer(); ?>
</body>
</html>
