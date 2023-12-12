<?php

/**
 * Display Admin notice
 */
function wooster_plugin_notice()
{
    $url = esc_url(add_query_arg(
        'page',
        'wooster-badge',
        get_admin_url() . 'options-general.php'
    ));
?>
    <div class="notice error">
        <p><?php _e('Badge Wooster : Votre <a href='. $url . '>licence de partenariat' . '</a> avec Wooster n\'a pas été renseigné.', 'wooster-badge'); ?></p>
    </div>
<?php
}

/**
 * Define the shortcode function
 */
function wooster_badge_shortcode()
{
    // Get the plugin directory url
    $plugin_dir = plugin_dir_url(__FILE__);

    // Get the image URL
    $image_url = 'https://cdn-img.wooster.fr/app/uploads/updater/wooster-badge-partenaire.png';
    // $image_url = $plugin_dir . 'assets/wooster-badge-partenaire.png';

    // Has the partner provided their number?
    if (empty(get_option('partenaire_number'))) {
        // Construct empty image.
        $image = '<div class="wooster-badge"></div>';
    } else {
        // Construct the image HTML.
        $image = '<div class="wooster-badge">
        <picture style="height: 50px;">
        <source media="(max-width: 767px)" srcset="' . $image_url . ', ' . esc_attr($image_url . ' 2x') . ', ' . esc_attr($image_url . ' 3x') . '">
        <source media="(max-width: 1023px)" srcset="' . $image_url . ', ' . esc_attr($image_url . ' 2x') . ', ' . esc_attr($image_url . ' 3x') . '">
        <source media="(min-width: 1024px)" srcset="' . $image_url . ', ' . esc_attr($image_url . ' 2x') . ', ' . esc_attr($image_url . ' 3x') . '">
        <img src="' . $image_url . '" alt="Wooster Badge Partenaire" width=auto height=80>
        </picture>
        </div>';
    }
    return $image;
}
add_shortcode('wooster-badge', 'wooster_badge_shortcode');


// Has the partner provided their number?
if (empty(get_option('partenaire_number'))) {
    // Show the admin notice
    add_action('admin_notices', 'wooster_plugin_notice');
}


/**
 * Displays the Wooster Badge settings link in the plugins admin page.
 *
 *
 * @param array $links The existing links.
 * @return array The modified links with the settings page link of Wooster Badge plugin.
 */
function wooster_badge_settings_link($links)
{
    // Build and escape the URL.
    $url = esc_url(add_query_arg(
        'page',
        'wooster-badge',
        get_admin_url() . 'options-general.php'
    ));
    // Create the link to Wooster Badge settings page.
    $settings_link = "<a href='$url'>" . __('Settings') . '</a>';
    // Adds the link to the end of the array.
    array_push(
        $links,
        $settings_link
    );
    return $links;
}
add_filter('plugin_action_links_wooster-badge/wooster-badge.php', 'wooster_badge_settings_link');