<?php
class Wooster_Settings_Plugin
{
    /**
     * Construct the plugin object
     */
    public function __construct()
    {
        // Hook into the admin menu
        add_action('admin_menu', array($this, 'wooster_create_plugin_settings_page'));
        add_action('admin_init', array($this, 'wooster_setup_sections'));
        add_action('admin_init', array($this, 'wooster_setup_fields'));
    }

    /**
     * Creates the plugin settings page.
     */
    public function wooster_create_plugin_settings_page()
    {
        // Add the menu item and page
        $page_title = 'Configuration du badge Wooster';
        $menu_title = 'Badge Wooster';
        $capability = 'manage_options';
        $slug = 'wooster-badge';
        $callback = array($this, 'wooster_plugin_settings_page_content');
        $icon = 'dashicons-awards';
        $position = 100;

        // add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
        add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $slug, $callback);
    }

    /**
     * Displays the content for the Wooster plugin settings page.
     */
    public function wooster_plugin_settings_page_content()
    { ?>
        <div class="wrap">
            <h2>Configuration du badge Wooster</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('wooster-badge');
                do_settings_sections('wooster-badge');
                submit_button();
                ?>
            </form>
        </div> <?php
    }

    /**
     * Sets up the admin sections for the Wooster Badge plugin.
     */
    public function wooster_setup_sections()
    {
        add_settings_section('number_section', 'Référencement du partenariat', array($this, 'section_callback'), 'wooster-badge');
        add_settings_section('badge_section', 'Intégration du badge', array($this, 'section_callback'), 'wooster-badge');
    }

    /**
     * Callback function for the section.
     *
     * @param array $arguments The arguments passed to the section.
     * @return void
     */
    public function section_callback($arguments)
    {
        switch ($arguments['id']) {
            case 'number_section':
                echo '<p>Veulliez saisir votre licence de partenariat.</p>';
                break;
            case 'badge_section':
                echo '<p>Vous pouvez intégrer le badge de partenaire de Wooster en utilisant le shortcode [wooster-badge].</p>';
                break;
        }
    }

    /**
     * Sets up the fields for the Wooster Badge plugin.
     */
    public function wooster_setup_fields()
    {
        // This function defines an array of fields with their respective properties.
        // Each field is added using the add_settings_field() function, which takes the field's unique ID, label, callback function, section, and additional arguments.
        // The register_setting() function is used to register the field's unique ID as a setting.
        // This allows the field's value to be saved and retrieved using the get_option() function.
        $fields = array(
            array(
                'uid' => 'partenaire_number',
                'label' => 'Licence de partenariat :',
                'section' => 'number_section',
                'type' => 'text',
                'options' => false,
                'placeholder' => '123456789',
                'helper' => 'Ce champ est requis pour l\'affichage du badge.',
                'supplemental' => 'Votre SIREN apparait dans votre licence.',
                'default' => ''
            )
        );
        foreach ($fields as $field) {
            add_settings_field($field['uid'], $field['label'], array($this, 'wooster_field_callback'), 'wooster-badge', $field['section'], $field);
            register_setting('wooster-badge', $field['uid']);
        }
    }

    /**
     * Callback function for the wooster_field.
     *
     * @param mixed $arguments The arguments passed to the callback function.
     * @return void
     */
    public function wooster_field_callback($arguments)
    {
        $value = get_option($arguments['uid']); // Get the current value, if there is one
        if (!$value) { // If no value exists
            $value = $arguments['default']; // Set to our default
        }

        // Check which type of field we want
        switch ($arguments['type']) {
            case 'text': // If it is a text field
                printf('<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" required />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value);
                break;
        }

        // Is help text for the field?
        if ($helper = $arguments['helper']) {
            printf('<span class="helper"> %s</span>', $helper); // Show it
        }

        // Is supplemental text for the field?
        if ($supplimental = $arguments['supplemental']) {
            printf('<p class="description">%s</p>', $supplimental); // Show it
        }
    }
}
new Wooster_Settings_Plugin();