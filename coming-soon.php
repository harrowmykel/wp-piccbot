<?php
/**
 * Default Constants
 */
define('PICCBOTT_CSP4_SHORTNAME', 'pcbtt_csp4'); // Used to reference namespace functions.
define('PICCBOTT_CSP4_SLUG', 'picc-bot/picc-bot.php'); // Used for settings link.
define('PICCBOTT_CSP4_TEXTDOMAIN', 'wp-piccbot'); // Your textdomain
define('PICCBOTT_CSP4_PLUGIN_NAME', __('Coming Soon Page & Maintenance Mode by PiccOrg', 'wp-piccbot')); // Plugin Name shows up on the admin settings screen.
define('PICCBOTT_CSP4_VERSION', '5.1.0'); // Plugin Version Number. Recommend you use Semantic Versioning http://semver.org/
define('PICCBOTT_CSP4_PLUGIN_PATH', plugin_dir_path(__FILE__)); // Example output: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/pcbtt_csp4/
define('PICCBOTT_CSP4_PLUGIN_URL', plugin_dir_url(__FILE__)); // Example output: http://localhost:8888/wordpress/wp-content/plugins/pcbtt_csp4/
define('PICCBOTT_CSP4_TABLENAME', 'pcbtt_csp4_subscribers');


/**
 * Load Translation
 */
function pcbtt_csp4_load_textdomain()
{
    load_plugin_textdomain('wp-piccbot', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'pcbtt_csp4_load_textdomain');


/**
 * Upon activation of the plugin, see if we are running the required version and deploy theme in defined.
 *
 * @since 0.1.0
 */
function pcbtt_csp4_activation()
{
    // Store the plugin version when initial install occurred.
    $has_pcbtt_csp4_settings_content =  get_option('pcbtt_csp4_settings_content');
    if (!empty($has_pcbtt_csp4_settings_content)) {
        add_option('pcbtt_csp4_initial_version', 0, '', false);
    } else {
        add_option('pcbtt_csp4_initial_version', PICCBOTT_CSP4_VERSION, '', false);
    }
  

    // Store the plugin version activated to reference with upgrades.
    update_option('pcbtt_csp4_version', PICCBOTT_CSP4_VERSION, false);
    require_once('inc/default-settings.php');
    add_option('pcbtt_csp4_settings_content', unserialize($pcbtt_csp4_settings_deafults['pcbtt_csp4_settings_content']));
    add_option('pcbtt_csp4_settings_design', unserialize($pcbtt_csp4_settings_deafults['pcbtt_csp4_settings_design']));
    add_option('pcbtt_csp4_settings_advanced', unserialize($pcbtt_csp4_settings_deafults['pcbtt_csp4_settings_advanced']));
}
register_activation_hook(__FILE__, 'pcbtt_csp4_activation');



// Welcome Page

register_activation_hook(__FILE__, 'pcbtt_csp4_welcome_screen_activate');
function pcbtt_csp4_welcome_screen_activate()
{
    set_transient('_pcbtt_csp4_welcome_screen_activation_redirect', true, 30);
}


add_action('admin_init', 'pcbtt_csp4_welcome_screen_do_activation_redirect');
function pcbtt_csp4_welcome_screen_do_activation_redirect()
{
    // Bail if no activation redirect
    if (! get_transient('_pcbtt_csp4_welcome_screen_activation_redirect')) {
        return;
    }

    // Delete the redirect transient
    delete_transient('_pcbtt_csp4_welcome_screen_activation_redirect');

    // Bail if activating from network, or bulk
    if (is_network_admin() || isset($_GET['activate-multi'])) {
        return;
    }

    // Redirect to bbPress about page
    wp_safe_redirect(add_query_arg(array( 'page' => 'pcbtt_csp4' ), admin_url('admin.php')));
}


/***************************************************************************
 * Load Required Files
 ***************************************************************************/

// Global
global $pcbtt_csp4_settings;

require_once(PICCBOTT_CSP4_PLUGIN_PATH.'framework/get-settings.php');
$pcbtt_csp4_settings = pcbtt_csp4_get_settings();

require_once(PICCBOTT_CSP4_PLUGIN_PATH.'inc/class-pbtt-csp4.php');
add_action('plugins_loaded', array( 'PICCBOTT_CSP4', 'get_instance' ));

if (is_admin()) {
    // Admin Only
    require_once(PICCBOTT_CSP4_PLUGIN_PATH.'inc/config-settings.php');
    require_once(PICCBOTT_CSP4_PLUGIN_PATH.'framework/framework.php');
    add_action('plugins_loaded', array( 'PICCBOTT_CSP4_ADMIN', 'get_instance' ));
    require_once(PICCBOTT_CSP4_PLUGIN_PATH.'framework/review.php');
    if(version_compare(phpversion(), '5.3.3', '>=')){
        require_once( PICCBOTT_CSP4_PLUGIN_PATH.'lib/setup_tgmpa.php' );
        require_once( PICCBOTT_CSP4_PLUGIN_PATH.'lib/TGMPA.php' );
    }
} else {
    // Public only
}


// Clear Popular Caches
add_action('update_option_pcbtt_csp4_settings_content', 'pcbtt_csp4_clear_known_caches', 10, 2);

function pcbtt_csp4_clear_known_caches($o, $n)
{
    try {
        if (isset($o['status']) && isset($n['status'])) {
            if ($o['status'] != $n['status']) {

        // Clear Litespeed cache
                method_exists('LiteSpeed_Cache_API', 'purge_all') && LiteSpeed_Cache_API::purge_all() ;

                // WP Super Cache
                if (function_exists('wp_cache_clear_cache')) {
                    wp_cache_clear_cache();
                }

                // W3 Total Cahce
                if (function_exists('w3tc_pgcache_flush')) {
                    w3tc_pgcache_flush();
                }

                // Site ground
                if (class_exists('SG_CachePress_Supercacher') && method_exists('SG_CachePress_Supercacher ', 'purge_cache')) {
                    SG_CachePress_Supercacher::purge_cache(true);
                }

                // Endurance Cache
                if (class_exists('Endurance_Page_Cache')) {
                    $e = new Endurance_Page_Cache;
                    $e->purge_all();
                }

                // WP Fastest Cache
                if (isset($GLOBALS['wp_fastest_cache']) && method_exists($GLOBALS['wp_fastest_cache'], 'deleteCache')) {
                    $GLOBALS['wp_fastest_cache']->deleteCache(true);
                }
            }
        }
    } catch (Exception $e) {
    }
}


function pcbtt_csp4_admin_upgrade_link($medium = 'link')
{
    return apply_filters('pcbtt_csp4_upgrade_link', 'https://www.piccbott.com/ultimate-picc-bot-page-vs-picc-bot-pro/?utm_source=WordPress&utm_medium=' . sanitize_key(apply_filters('pcbtt_csp4_upgrade_link_medium', $medium)) . '&utm_campaign=liteplugin');
}