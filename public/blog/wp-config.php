<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ufblog_msdb');

/** MySQL database username */
define('DB_USER', 'unclefitter');

/** MySQL database password */
define('DB_PASSWORD', 'Cricket_unclefitter');

/** MySQL hostname */
define('DB_HOST', 'unclefitter.ciatyupbsjav.us-east-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'JAdXb!Oe9}h@V7XkZJVE.`U]T:8DNo}fYA-4*I$r>wkP*po6k[.ECBYjjtp[44uw');
define('SECURE_AUTH_KEY',  '51{%@Cd?Hs)W!Kjn9Q`2;7=*AH=8,J=|_^sYcheg^FR<n) 3O6vspVk$2QH#d/KF');
define('LOGGED_IN_KEY',    'B5DO),EzUp+%Ip$*:&T[DY4 jl!nj3. NID=zGry1!1n[Se{?PKM4tApm^ )SmP)');
define('NONCE_KEY',        'kOgdr/k^`ur5S <>Ji.[z-hk.C?^I+H<$.<W)xJ7` 1IzTqI@tZIS+sz{HEz#@vW');
define('AUTH_SALT',        '^D.5.=g[Ca?G.uXb@H{0}m40[P<vp<+&g>@.mooX% k)cI(Q|1&vTW_:hz?szrZg');
define('SECURE_AUTH_SALT', 'm,3pDo/3Q.rljz%tQ s#!,K}Z%Y>FE5Bn5y4.a6gb%!:XT&f7Qh&/q{w*;)x}5R6');
define('LOGGED_IN_SALT',   'Z3eN#s$4m^ImN8hO2cf62SQx!V2 )nCoH^3>wixBKFJpY&AW8Gmb,jcz5lPp~MCd');
define('NONCE_SALT',       'G]v[/@[Xrw)Gm+>$a1rl^Y,Gz<Tt!J`6aC/^aLD !}[rXf[jHsH!ArJs#WWr9uD;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

define('WP_HOME', 'https://www.unclefitter.com/blog');

define('WP_SITEURL', 'https://www.unclefitter.com/blog');

define('FORCE_SSL_LOGIN', true);
define('FORCE_SSL_ADMIN', true);

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
	$_SERVER['HTTPS']='on';

define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
