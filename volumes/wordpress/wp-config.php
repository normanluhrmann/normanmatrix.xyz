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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'exampledb');

/** MySQL database username */
define( 'DB_USER', 'exampleuser');

/** MySQL database password */
define( 'DB_PASSWORD', 'examplepass');

/** MySQL hostname */
define( 'DB_HOST', 'db');

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '561fecff07c6e1ee0c6f13fe7afec2f8dd250f6b');
define( 'SECURE_AUTH_KEY',  '0f02abf7850bf9aac5635b44040c4e80cf75e690');
define( 'LOGGED_IN_KEY',    'b4ccb550e7288ebded013668eb181be0d31208ea');
define( 'NONCE_KEY',        'db06a6983d5c730d4b88f46fd19b057373096772');
define( 'AUTH_SALT',        '0865659f443fc45d7af92fdafe7202e1807cb539');
define( 'SECURE_AUTH_SALT', 'a0f67ffcaa715675630678654b39f30a02c48028');
define( 'LOGGED_IN_SALT',   '1bee556b4f979382aa0ddd3066caa32c60be51ba');
define( 'NONCE_SALT',       '50e6f54034dd7b874d658f1757c6a7fc7e4e5c05');

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}


/**
 * NORMAN: customizations
 */

define('FS_METHOD', 'direct');

define('WP_MEMORY_LIMIT', '256M');

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';