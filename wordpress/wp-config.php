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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'Pa$$word1234' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY', '| jN6Q=e7Zu,OI^b)/N`}|RXVALd2bY0?iU*@C}.>+i@AtK% UC3.FF,Mv&k{CB1' );
define( 'SECURE_AUTH_KEY', '[/CF[H_=Qv,f0/EW`2q9iwoU0Fe)*6gy#775tQB&GAK%vlE|)=$E{m=heR<iQ&v,' );
define( 'LOGGED_IN_KEY', 'P@.=(V(QKvm?u/W#Y|;8eELTOr<pfw*oT?`ut`qo?ML;S[qitux^vaA5jr@CgT]d' );
define( 'NONCE_KEY', '*B,k$-z(?sOJ]p9O?l;yVebEn~[(;mz Oc-oK]pPUW`|O-D%A-,JSVnj5p=bBpMq' );
define( 'AUTH_SALT', 'j} *^S8nlxlvZeNRK(&/W-g5rSw[lYPYEFiZ-;+Ke6zj:&EKbjH=!xuXN{{h9/yH' );
define( 'SECURE_AUTH_SALT', 'nCt@4HoL:lShTiGm7uuS@n]d|cOV*4G*)5rUsI^t *}>uOXT6Aj4&`bUjwlQti1)' );
define( 'LOGGED_IN_SALT', 'J}IKZrXAlZ:>b^+`lx^3*9E@y=[> NX&UB;9AnUYvI/{#9eD%X~ 9/9 T-9eG/jR' );
define( 'NONCE_SALT', 'i>Na$1way2|j8.je-W@!uYTD_}_Qq$O&qW9%JJ)<=||uD8B: `{-3e hlLP@-Lq8' );

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
