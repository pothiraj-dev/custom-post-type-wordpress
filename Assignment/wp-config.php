<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'Assignment' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'uU/A9&U%$Fb/4&8RiBQv4&T%r=o,zA4ZEV)/!^SfqWuO`!xvDK:G$GN.$=lG6G7g' );
define( 'SECURE_AUTH_KEY',  '+zFL[0g6n(7lPvN~1:P_N:jyPeuc)u+@NvFnn9=$@ {VnNc$?ZM/[(.i`>E35-ZT' );
define( 'LOGGED_IN_KEY',    '&@?!<W{w}aN]dq @j{W`LWi[$r%]8T-j+W!O>[.[UD|@DMrib||Sq1@WO0MRmCyQ' );
define( 'NONCE_KEY',        'V*/Dj*vkmV@g4f~b&[&9,FcKK3z3x9SYZuoVU1O-UJ|S-3kbMc!*)Sxo5EH%2;N=' );
define( 'AUTH_SALT',        'U2!F X4(NY&{M6(/9`3UOuDZ38b@*JaLkIG;zzv{%!@YCKxV`kmKDi, >b`oy>$C' );
define( 'SECURE_AUTH_SALT', 'lQU]&*{B_g6gaahO/jWEMm}H ]vCb(eOKBh-i0eZ8HT%ZE398^I^*J=KT[|2}pPi' );
define( 'LOGGED_IN_SALT',   '7B=Uf_.Dt#L`m}},yVDv0kDML12[jhG+H`,lGtSo}en3J%qSuJq^)nRRc|UQcC]3' );
define( 'NONCE_SALT',       ';k1;nou.rh:@o8)Tjd=M_e{^(z;5{E>6}bVzo@Oir=oDgE3qP:K1NI{gBIc/4tOn' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
