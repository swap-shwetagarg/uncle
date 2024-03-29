<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme's Functions and Definitions
 *
 *
 * @file           functions.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.2.1
 * @filesource     wp-content/themes/responsive/includes/functions.php
 * @link           http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          available since Release 1.0
 */
?>
<?php
/*
 * Globalize Theme options
 */
$responsive_options = responsive_get_options();

/**
 * Add plugin automation file
 */
require_once( dirname( __FILE__ ) . '/classes/class-tgm-plugin-activation.php' );

/*
 * Hook options
 */
add_action( 'admin_init', 'responsive_theme_options_init' );
add_action( 'admin_menu', 'responsive_theme_options_add_page' );

/**
 * Remove Wordpress update Notification 
 */

// function remove_core_updates(){
// global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
// }
// add_filter('pre_site_transient_update_core','remove_core_updates');
// add_filter('pre_site_transient_update_plugins','remove_core_updates');
// add_filter('pre_site_transient_update_themes','remove_core_updates');


/**
 * Retrieve Theme option settings
 */
function responsive_get_options() {
	// Globalize the variable that holds the Theme options
	global $responsive_options;
	// Parse array of option defaults against user-configured Theme options
	$responsive_options = wp_parse_args( get_option( 'responsive_theme_options', array() ), responsive_get_option_defaults() );

	// Return parsed args array
	return $responsive_options;
}

/**
 * Responsive Theme option defaults
 */
function responsive_get_option_defaults() {
	$defaults = array(
		'breadcrumb'                      => false,
		'cta_button'                      => false,
		'minified_css'                    => false,
		'front_page'                      => 1,
		'home_headline'                   => null,
		'home_subheadline'                => null,
		'home_content_area'               => null,
		'cta_text'                        => null,
		'cta_url'                         => null,
		'featured_content'                => null,
		'google_site_verification'        => '',
		'bing_site_verification'          => '',
		'yahoo_site_verification'         => '',
		'site_statistics_tracker'         => '',
		'twitter_uid'                     => '',
		'facebook_uid'                    => '',
		'linkedin_uid'                    => '',
		'youtube_uid'                     => '',
		'stumble_uid'                     => '',
		'rss_uid'                         => '',
		'google_plus_uid'                 => '',
		'instagram_uid'                   => '',
		'pinterest_uid'                   => '',
		'yelp_uid'                        => '',
		'vimeo_uid'                       => '',
		'foursquare_uid'                  => '',
		'responsive_inline_css'           => '',
		'responsive_inline_js_head'       => '',
		'responsive_inline_js_footer' => '',
		'responsive_inline_css_js_footer' => '',
		'static_page_layout_default'      => 'default',
		'single_post_layout_default'      => 'default',
		'blog_posts_index_layout_default' => 'default',
	);

	return apply_filters( 'responsive_option_defaults', $defaults );
}

/**
 * Fire up the engines boys and girls let's start theme setup.
 */
add_action( 'after_setup_theme', 'responsive_setup' );

if ( !function_exists( 'responsive_setup' ) ):

	function responsive_setup() {

		global $content_width;

		$template_directory = get_template_directory();

		/**
		 * Global content width.
		 */
		if ( !isset( $content_width ) ) {
			$content_width = 605;
		}

		/**
		 * Responsive is now available for translations.
		 * The translation files are in the /languages/ directory.
		 * Translations are pulled from the WordPress default lanaguge folder
		 * then from the child theme and then lastly from the parent theme.
		 * @see http://codex.wordpress.org/Function_Reference/load_theme_textdomain
		 */

		$domain = 'responsive';

		load_theme_textdomain( $domain, WP_LANG_DIR . '/responsive/' );
		load_theme_textdomain( $domain, get_stylesheet_directory() . '/languages/' );
		load_theme_textdomain( $domain, get_template_directory() . '/languages/' );

		/**
		 * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
		 * @see http://codex.wordpress.org/Function_Reference/add_editor_style
		 */
		add_editor_style();

		/**
		 * This feature enables post and comment RSS feed links to head.
		 * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * This feature enables post-thumbnail support for a theme.
		 * @see http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * This feature enables woocommerce support for a theme.
		 * @see http://www.woothemes.com/2013/02/last-call-for-testing-woocommerce-2-0-coming-march-4th/
		 */
		add_theme_support( 'woocommerce' );

		/**
		 * This feature enables custom-menus support for a theme.
		 * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus( array(
			'top-menu'        => __( 'Top Menu', 'responsive' ),
			'header-menu'     => __( 'Header Menu', 'responsive' ),
			'footer-menu'     => __( 'Footer Menu', 'responsive' )
		) );

		//add_theme_support( 'custom-background' );

		add_theme_support( 'custom-header', array(
			// Header text display default
			'header-text'         => false,
			// Header image flex width
			'flex-width'          => true,
			// Header image width (in pixels)
			'width'               => 300,
			// Header image flex height
			'flex-height'         => true,
			// Header image height (in pixels)
			'height'              => 100,
			// Admin header style callback
			'admin-head-callback' => 'responsive_admin_header_style'
		) );

		// gets included in the admin header
		function responsive_admin_header_style() {
			?>
			<style type="text/css">
				.appearance_page_custom-header #headimg {
					background-repeat: no-repeat;
					border: none;
				}
			</style><?php
		}
		
		// While upgrading set theme option front page toggle not to affect old setup.
		$responsive_options = get_option( 'responsive_theme_options' );
		if ( $responsive_options && isset( $_GET['activated'] ) ) {

			// If front_page is not in theme option previously then set it.
			if ( !isset( $responsive_options['front_page'] ) ) {

				// Get template of page which is set as static front page
				$template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );

				// If static front page template is set to default then set front page toggle of theme option to 1
				if ( 'page' == get_option( 'show_on_front' ) && $template == 'default' ) {
					$responsive_options['front_page'] = 1;
				} else {
					$responsive_options['front_page'] = 0;
				}
				update_option( 'responsive_theme_options', $responsive_options );
			}
		}
	}

endif;

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 */
function responsive_content_width() {
	global $content_width;
	$full_width = is_page_template( 'full-width-page.php' ) || is_404() || 'full-width-page' == responsive_get_layout();
	if ( $full_width ) {
		$content_width = 918;
	}
	$half_width = is_page_template( 'sidebar-content-half-page.php' ) || is_page_template( 'content-sidebar-half-page.php' ) || 'sidebar-content-half-page' == responsive_get_layout() || 'content-sidebar-half-page' == responsive_get_layout();
	if ( $half_width ) {
		$content_width = 449;
	}
}
add_action( 'template_redirect', 'responsive_content_width' );

/**
 * Set a fallback menu that will show a home link.
 */
function responsive_fallback_menu() {
	$args    = array(
		'depth'       => 0,
		'sort_column' => 'menu_order, post_title',
		'menu_class'  => 'menu',
		'include'     => '',
		'exclude'     => '',
		'echo'        => false,
		'show_home'   => true,
		'link_before' => '',
		'link_after'  => ''
	);
	$pages   = wp_page_menu( $args );
	$prepend = '<div class="main-nav">';
	$append  = '</div>';
	$output  = $prepend . $pages . $append;
	echo $output;
}

/**
 * A safe way of adding stylesheets to a WordPress generated page.
 */
if ( !function_exists( 'responsive_css' ) ) {

	function responsive_css() {
		$theme      = wp_get_theme();
		$responsive = wp_get_theme( 'responsive' );
		$responsive_options = responsive_get_options();
		if ( 1 == $responsive_options['minified_css'] ) {
			wp_enqueue_style( 'responsive-style', get_template_directory_uri() . '/core/css/style.min.css', false, $responsive['Version'] );
		} else {
			wp_enqueue_style( 'responsive-style', get_template_directory_uri() . '/core/css/style.css', false, $responsive['Version'] );
			wp_enqueue_style( 'responsive-media-queries', get_template_directory_uri() . '/core/css/responsive.css', false, $responsive['Version'] );
		}

		if ( is_rtl() ) {
			wp_enqueue_style( 'responsive-rtl-style', get_template_directory_uri() . '/rtl.css', false, $responsive['Version'] );
		}
		if ( is_child_theme() ) {
			wp_enqueue_style( 'responsive-child-style', get_stylesheet_uri(), false, $theme['Version'] );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'responsive_css' );

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */
if ( !function_exists( 'responsive_js' ) ) {

	function responsive_js() {
		$suffix                 = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$directory              = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? 'js-dev' : 'js';
		$template_directory_uri = get_template_directory_uri();

		// JS at the bottom for fast page loading.
		// except for Modernizr which enables HTML5 elements & feature detects.
		wp_enqueue_script( 'modernizr', $template_directory_uri . '/core/' . $directory . '/responsive-modernizr' . $suffix . '.js', array( 'jquery' ), '2.6.1', false );
		wp_enqueue_script( 'responsive-scripts', $template_directory_uri . '/core/' . $directory . '/responsive-scripts' . $suffix . '.js', array( 'jquery' ), '1.2.6', true );
		if ( !wp_script_is( 'tribe-placeholder' ) ) {
			wp_enqueue_script( 'jquery-placeholder', $template_directory_uri . '/core/' . $directory . '/jquery.placeholder' . $suffix . '.js', array( 'jquery' ), '2.0.7', true );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'responsive_js' );

/**
 * A comment reply.
 */
function responsive_enqueue_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'responsive_enqueue_comment_reply' );

/**
 * Front Page function starts here. The Front page overides WP's show_on_front option. So when show_on_front option changes it sets the themes front_page to 0 therefore displaying the new option
 */
function responsive_front_page_override( $new, $orig ) {
	global $responsive_options;

	if ( $orig !== $new ) {
		$responsive_options['front_page'] = 0;

		update_option( 'responsive_theme_options', $responsive_options );
	}

	return $new;
}

add_filter( 'pre_update_option_show_on_front', 'responsive_front_page_override', 10, 2 );

/**
 * Funtion to add CSS class to body
 */
function responsive_add_class( $classes ) {

	// Get Responsive theme option.
	global $responsive_options;
	if ( $responsive_options['front_page'] == 1 && is_front_page() ) {
		$classes[] = 'front-page';
	}

	return $classes;
}

add_filter( 'body_class', 'responsive_add_class' );


/**
 * This function prints post meta data.
 *
 * Ulrich Pogson Contribution
 *
 */
if ( !function_exists( 'responsive_post_meta_data' ) ) {

	function responsive_post_meta_data() {
		printf( __( '<span class="%1$s">Posted on </span>%2$s<span class="%3$s"> by </span>%4$s', 'responsive' ),
				'meta-prep meta-prep-author posted',
				sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="timestamp updated" datetime="%3$s">%4$s</time></a>',
						 esc_url( get_permalink() ),
						 esc_attr( get_the_title() ),
						 esc_html( get_the_date('c')),
						 esc_html( get_the_date() )
				),
				'byline',
				sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
						 get_author_posts_url( get_the_author_meta( 'ID' ) ),
						 sprintf( esc_attr__( 'View all posts by %s', 'responsive' ), get_the_author() ),
						 esc_attr( get_the_author() )
				)
		);
	}

}


/**
 * Added the footer copyright setting to the theme customizer - starts
 */

function fetch_copyright(){
	global $responsive_options;
	?>
	<script>
		jQuery(document).ready(function(){
		var copyright_text = "<?php if (isset($responsive_options['copyright_textbox'])) { echo $responsive_options['copyright_textbox']; } ?>";
		var cyberchimps_link = "<?php if (isset($responsive_options['poweredby_link'])) { echo $responsive_options['poweredby_link']; } ?>";
		var siteurl = "<?php echo site_url(); ?>"; 
		if(copyright_text == "")
		{
			jQuery(".copyright #copyright_link").text(" "+"Default copyright text");
		}
		else{ 
			jQuery(".copyright #copyright_link").text(" "+copyright_text);
		}
		jQuery(".copyright #copyright_link").attr('href',siteurl);
		if(cyberchimps_link == 1)
		{
			jQuery(".powered").css("display","block");
		}
		else{
			jQuery(".powered").css("display","none");
		}
		});
	</script>
<?php
}
add_action('wp_head','fetch_copyright');

/**
 * Added the footer copyright setting to the theme customizer - ends
 */
if ( function_exists( 'add_image_size' ) ) {

	add_image_size( 'resize-275x190', 275, 190, true );
	add_image_size( 'resize-856x380', 856, 380, true );
}

function wpb_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;
return $fields;
}
 
add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );



//change text to leave a reply on comment form
function isa_comment_reform ($arg) {
$arg['title_reply'] = __('Leave a Comment');
return $arg;
}
add_filter('comment_form_defaults','isa_comment_reform');


add_filter( 'comment_form_default_fields', 'wpse_62742_comment_placeholders' );

/**
 * Change default fields, add placeholder and change type attributes.
 *
 * @param  array $fields
 * @return array
 */
function wpse_62742_comment_placeholders( $fields )
{
    $fields['author'] = str_replace(
        '<input',
        '<input placeholder="'
        /* Replace 'theme_text_domain' with your theme’s text domain.
         * I use _x() here to make your translators life easier. :)
         * See http://codex.wordpress.org/Function_Reference/_x
         */
            . _x(
                'Name',
                'comment form placeholder',
                'theme_text_domain'
                )
            . '"',
        $fields['author']
    );
    $fields['email'] = str_replace(
        '<input id="email" name="email" type="text"',
        /* We use a proper type attribute to make use of the browser’s
         * validation, and to get the matching keyboard on smartphones.
         */
        '<input type="email" placeholder="Email"  id="email" name="email"',
        $fields['email']
    );
    $fields['url'] = str_replace(
        '<input id="url" name="url" type="text"',
        // Again: a better 'type' attribute value.
        '<input placeholder="Website" id="url" name="url" type="url"',
        $fields['url']
    );

    return $fields;
}

function my_update_comment_field( $comment_field ) {

  $comment_field =
    '<p class="comment-form-comment">
            <label for="comment">' . __( "Comment", "text-domain" ) . '</label>
            <textarea required id="comment" name="comment" placeholder="' . esc_attr__( "Comment", "text-domain" ) . '" cols="45" rows="8" aria-required="true"></textarea>
        </p>';

  return $comment_field;
}
add_filter( 'comment_form_field_comment', 'my_update_comment_field' );