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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** Database username */
define('DB_USER', 'wordpress');

/** Database password */
define('DB_PASSWORD', 'Pa$$word1234');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY', 'x&F(UbB7XsRc^^>jD[8C>.3IPF&hi>r2TSwQ&VlCY01U[9:2zX9F@BY3Kjgm@b/e');
define('SECURE_AUTH_KEY', '1Y1Zn.YMDWUy*{hA Cm=2&{h=;6+=dzZCEVWWzSml0)I;6/wfT?3vYW+;nNfel`0');
define('LOGGED_IN_KEY', 'nP|0UTPE]3{w^c}NKCS~HI2<XX.0.%VKV~|s/saV$xm3D,Kf?x8X6JKuewgFT<9R');
define('NONCE_KEY', 'j<B7T>VoOiQ6%/}6a+(|x_WxIKti37k_5t3o)V+S~klL s@A|s0p]X</ks#iUSrB');
define('AUTH_SALT', 'n|:Y=6FXx]etyYV6C0V{tkDTTyM}BHg:x*e%$jPBPS:97c7uJPeJ2P$IgpX~J+En');
define('SECURE_AUTH_SALT', 'TYD^LojXAsHq]nU~7[[e[s{RNa@.TW01.D>J>Z2XZZ~I[6ns0qMGoI 8/Na ^XZp');
define('LOGGED_IN_SALT', '%)=@`1TvbK*C!+O7LgyyvyXK*QX0UTaH_a@&FqP2R/08RdHeQ.)_Bmb2)G8Gt3/8');
define('NONCE_SALT', 'IXgy0x,E?c;0DFJIf*z,6$,8Z%g{c@R,=X(G;}]5F`H# YN?N_drPO~]p8u7B72X');

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
