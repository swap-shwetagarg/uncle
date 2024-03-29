<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme options upgrade bar
 */



/**
 * Theme Options Support and Information
 */

function responsive_install_plugins() {
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     => 'Contact From 7', // The plugin name
			'slug'     => 'contact-form-7', // The plugin slug (typically the folder name)
			'required' => false
		),
		array(
			'name'     => 'custom post type', // The plugin name
			'slug'     => 'custom-post-type-ui', // The plugin slug (typically the folder name)
			'required' => false
		),
		array(
			'name'     => 'Advance Custom Field', // The plugin name
			'slug'     => 'advanced-custom-fields', // The plugin slug (typically the folder name)
			'required' => false
		),

		array(
			'name'     => 'PHP Code Widget', // The plugin name
			'slug'     => 'php-code-widget', // The plugin slug (typically the folder name)
			'required' => false
		),

		array(
			'name'     => 'Custom Field Suite', // The plugin name
			'slug'     => 'custom-field-suite', // The plugin slug (typically the folder name)
			'required' => false
		),

		array(
			'name'     => 'visual composur', // The plugin name
			'slug'     => ' ', // The plugin slug (typically the folder name)
			'required' => false
		),

		array(
			'name'     => 'EWWW Image Optimizer', // The plugin name
			'slug'     => 'ewww-image-optimizer', // The plugin slug (typically the folder name)
			'required' => false
		)



	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'responsive';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */

	$config = array(
		'domain'           => $theme_text_domain, // Text domain - likely want to be the same as your theme.
		'default_path'     => '', // Default absolute path to pre-packaged plugins
		'parent_menu_slug' => 'themes.php', // Default parent menu slug
		'parent_url_slug'  => 'themes.php', // Default parent URL slug
		'menu'             => 'install-responsive-addons', // Menu slug
		'has_notices'      => true, // Show admin notices or not
		'is_automatic'     => true, // Automatically activate plugins after installation or not
		'message'          => '', // Message to output right before the plugins table
		'strings'          => array(
			'page_title'                      => __( 'Responsive Add Features', 'responsive' ),
			'menu_title'                      => __( 'Recommended Plugin', 'responsive' ),
			'installing'                      => __( 'Installing Plugin: %s', 'responsive' ), // %1$s = plugin name
			'oops'                            => __( 'Something went wrong with the plugin API.', 'responsive' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'responsive' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'responsive' ), // %1$s = plugin name(s)
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'responsive' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'responsive' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'responsive' ), // %1$s = plugin name(s)
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'responsive' ), // %1$s = plugin name(s)
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'responsive' ), // %1$s = plugin name(s)
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'responsive' ), // %1$s = plugin name(s)
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'responsive' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'responsive' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'responsive' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'responsive' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'responsive' ) // %1$s = dashboard link
		)
	);

	global $pagenow;
	// Add plugin notification only if the current user is admin and on theme.php
	if ( current_user_can( 'manage_options' ) && 'themes.php' == $pagenow ) {
		tgmpa( $plugins, $config );
	}

}
add_action( 'tgmpa_register', 'responsive_install_plugins' );

/*
 * Add notification to Reading Settings page to notify if Custom Front Page is enabled.
 *
 * @since    1.9.4.0
 */

