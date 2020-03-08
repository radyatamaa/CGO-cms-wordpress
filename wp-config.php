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
define( 'DB_NAME', 'cgo' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'e{?q1Np,5S9GQi 5IAeyK:`G?bjQr*Q(%Y 1tAry%]5J7Z~Y6-wN8@qnK?2|(Qsp' );
define( 'SECURE_AUTH_KEY',  'qa*eS2?_h|]MgF6u2Yu sif~#^}*qSDt#_5L/;tVJr<R(0C>[oe3h?*^W.XkBkVk' );
define( 'LOGGED_IN_KEY',    ']`QQH5G)z,9Z`J)t!g6]ltY(Y#qm9;#3o-15(!CBN:(q1qV)Q7TpQ.P+gGK| J7e' );
define( 'NONCE_KEY',        'D{&<%u;O@usx7S,>Cfic![U;y=YQAv>wD+6?dVW~?gN?,lm<KE9a!R`=5c)8$YaR' );
define( 'AUTH_SALT',        'AEVa.h[bZ_P^WBmMh{6}2.jFm>Y,vpaQtQN_n_[szZ%ke7$4pVop|AW`c]}&@.;[' );
define( 'SECURE_AUTH_SALT', 'YdVNTz6XFy^(YDv!),TuQ9.>0Pc7Ny}2t_$1pY$T^;|Ha^|Z%2T`s;WJn66dr0io' );
define( 'LOGGED_IN_SALT',   'Z@?{AMf,I2!+]&LsdrvJt$XU;03ohRa}tA!m8M]%&7}CSf6sD7|y(|7J,;]O+7={' );
define( 'NONCE_SALT',       '-O=h{2/g3$|>Iqbr^w0Iw[K5:F:<_=3L^I FeRUM-kH:xvX7x!;t/O_JP;_nz>R]' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
