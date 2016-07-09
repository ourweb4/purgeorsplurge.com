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
define('DB_NAME', 'i2278893_wp1');

/** MySQL database username */
define('DB_USER', 'i2278893_wp1');

/** MySQL database password */
define('DB_PASSWORD', 'Z&sb(DfPY^14cKxY8Z.59[~5');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'Qheg7h0AQmD4XNG53c8juQp4zPjY2cKzkfqGOpgFpPTGFUrgGA17kd5TZmIXc37K');
define('SECURE_AUTH_KEY',  'hrznn1lSzTA8sytsL2NRfvoOfYs9lDfZDc318ubgRGq95NPkzYi74f3XKaipJkzS');
define('LOGGED_IN_KEY',    'z1PQkhYq2iK1OH4ANKqUF7e8Pws8MgyKxwleGTboHy53nap5rJVxdys26DhZMyF2');
define('NONCE_KEY',        'yLwH87tquR3o159jXMG3tJrhp9ZbAhmllGn20DmgChAXMbFF8iy54nhPBk4UnLdR');
define('AUTH_SALT',        'dq57IJy9UtD1rjV9MiQZxM2i5JMWakVcePdprl17yaFlcbGVvGls8vL4wT6kIf45');
define('SECURE_AUTH_SALT', 'bZ9HnL1RD0aDnAHQJEy1xH3IbjD7OgHWZugpLL9VdjBjjcehXV6AJQjFpIrZeoHa');
define('LOGGED_IN_SALT',   'DcJ5Ftv07jdpFcn0cgxTWb9ybFchO53FvxBXJupqK0PTTjF2uPeH2HKAfiakprHE');
define('NONCE_SALT',       'TagGjHW4ELNsnCufUzkRQPsiLdKCISOOIMNl4kErFzCcOtQEdKMlO4Lxou0oToZ0');

define('WP_MEMORY_LIMIT', '100M');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
