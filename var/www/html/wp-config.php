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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'jVkBqNT7' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'I,~!)E?>Jn^+CePp6^{Pk/wbWVjUtT.|bZ[Xe8=<.v-G-|`/@s`Cf-pl[S.R9n3.' );
define( 'SECURE_AUTH_KEY',   '>5#y(WA3p}dssNf!*I.VEFX2,RcJi@R>T=}qLr?+}T T4!G&5`|6OoOe``yl+<@q' );
define( 'LOGGED_IN_KEY',     'nE,:(xywe%G%y=1uPKO4(5#2yv6&mLE #s9WnzT82o7Qk5d>FUA[A qH>q;*:g0]' );
define( 'NONCE_KEY',         '$)@xj$CkkcfVCjJ Q&Ef_%IuGaG 57wB7&ZH%Y4udIOSv{!leAWd?G[#hqjCXv:<' );
define( 'AUTH_SALT',         '@A86^tts]Zl0%-l#<a ^|D~+0KzqlcyTu6uHy:t2Lc}{xxqrR+gw~zf2Jz6),gZr' );
define( 'SECURE_AUTH_SALT',  'EAf})rs/%.W0js5/zNR7[gD6tkd:;@jY]<b,e 6Gb1MFzqbI9}ks2PN`TI{L]~Jo' );
define( 'LOGGED_IN_SALT',    'Kef]l?Op.yo1^Cw1BOv$wQ!S`&}$Jy4/t0hCn3}{(~Y<Fthn,qW*3MQ1Dzf9,%&U' );
define( 'NONCE_SALT',        '{jV+`Roj$~0N.u;M8Dt<z]HJHj]wRO%VE&vQ7vFDH_ Fbk; r&ihW?X<TwzoljXa' );
define( 'WP_CACHE_KEY_SALT', '`t?Cr0J|0|9|%9ZG,~]8bV#y6].l=8+r}6bbfW+b%[(nnH&2F*Su,Geq/|,t  hJ' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
