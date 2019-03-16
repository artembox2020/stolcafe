<?php
define('WP_AUTO_UPDATE_CORE', false);// Эта настройка требуется для того, чтобы убедиться, что обновлениями WordPress можно корректно управлять в WordPress Toolkit. Удалите эту строку, если этот экземпляр WordPress больше не управляется WordPress Toolkit.
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
define('DB_NAME', 'r985541p_stolcaf');

/** MySQL database username */
define('DB_USER', 'r985541p_stolcaf');

/** MySQL database password */
define('DB_PASSWORD', 'ab123467');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',         'h3jsca0cln1T4eUZa#4q@j#quNu^ai4Hz^r%qqb8eqEY!e4yHq@OOOXz#BfS6yTe');
define('SECURE_AUTH_KEY',  '2aUv7xnP2qL(0h%gwAxKX06Eojd#)a!IqKlAei(WHPPkfXeaa8BqAPd8h@S!d50M');
define('LOGGED_IN_KEY',    'x*fq5n%xYGsb^du)5iKQ#gEcfkKCNg3rTsf3TKAHFKUYc4CCIQm^%rf8&(sj9K)i');
define('NONCE_KEY',        'OnOkQ(4MVgGksGq!2ASGx@QKX(tiYpQR0^JiQ0al3Jzqpf62Fz4v8I#RtZwITTlP');
define('AUTH_SALT',        'DJq&UQx829I%9SRXMU0CdQ8zc93m&wsC*&mqBu%f5UQoyeePfk3Cm)wep7yPY7It');
define('SECURE_AUTH_SALT', 'u2ydvWDYs!hOQKU%qy9X#)UfG2t6(*ucKAx%NQp)&n0u%vFiWjh0I5zYiv)1nsDo');
define('LOGGED_IN_SALT',   '&C)7%rZTwX%jH(InDsfNY6g9Ph(@HvzMexpVbbgWNxiGSornuUPcGF5LX#@GKs5^');
define('NONCE_SALT',       '0zKwJ4XwoBDaj%#SBUu)kLJ%CEPR&QPoeTzDAPg%37L9MImR1N%@CWMOn@zsYvN#');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'zY2O3xj_';

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

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
