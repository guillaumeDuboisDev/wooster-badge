<?php

/**
 * Plugin Name: Badge Wooster
 * Plugin URI: https://wooster.fr/
 * Description: Intègre le badge de partenariat de Wooster.
 * Version: 1.0.1
 * Author: Guillaume Dubois
 * Author URI: https://wooster.fr/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wooster-badge
 * Domain Path: /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Include the main plugin class.
require_once plugin_dir_path(__FILE__) . 'includes/wooster-settings.php';
// Include added functionnalities
include_once plugin_dir_path(__FILE__) . 'includes/wooster-functions.php';
// Include the updater
include_once plugin_dir_path(__FILE__) . 'includes/wooster-updater.php';