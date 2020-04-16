<?php
/**
 * Config
 *
 * @package WordPress
 * @subpackage pcbtt_csp4
 * @since 0.1.0
 */

/**
 * Config Settings
 */
function pcbtt_csp4_get_options(){

    /**
     * Create new menus
     */

    $pcbtt_csp4_options[ ] = array(
        "type" => "menu",
        "menu_type" => "add_menu_page",
        "page_name" => __( "PiccOrg", 'wp-piccbot' ),
        "menu_slug" => "pcbtt_csp4",
        "layout" => "2-col"
    );

    /**
     * Settings Tab
     */
    $pcbtt_csp4_options[ ] = array(
        "type" => "tab",
        "id" => "pcbtt_csp4_setting",
        "label" => __( "Content", 'wp-piccbot' ),
    );


    $pcbtt_csp4_options[ ] = array(
        "type" => "setting",
        "id" => "pcbtt_csp4_settings_content",
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_license",
        "label" => __( "License", 'wp-piccbot' ),
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "text",
        "id" => "license-key",
        "label" => __( "License Key", 'wp-piccbot' ),
        "desc" => __( '
        <p>You\'re using PiccBot Anti-Bot Protection Lite - no license needed. Enjoy! <img draggable="false" class="emoji" alt="🙂" src="https://s.w.org/images/core/emoji/11/svg/1f642.svg"></p><p>To unlock more features consider <a href="'.pcbtt_csp4_admin_upgrade_link( 'settings-license' ).'" target="blank" rel="noopener noreferrer" class="pbtt-csp4-cta">upgrading to PRO</a></p><p class="discount-note">As a valued PiccBot Lite user you receive <strong>20% off</strong>, automatically applied at checkout!</p></p> ', 'wp-piccbot' )
    );



    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_general",
        "label" => __( "General", 'wp-piccbot' ),
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "radio",
        "id" => "status",
        "label" => __( "Status", 'wp-piccbot' ),
        "option_values" => array(
            '0' => __( 'Disabled', 'wp-piccbot' ),
            '1' => __( 'Enable PiccBot Anti-Bot Mode', 'wp-piccbot' ),
            '2' => __( 'Enable Maintenance Mode', 'wp-piccbot' )
        ),
        "desc" => __( "When you are logged in you'll see your normal website. Logged out visitors will see the Coming Soon or Maintenance page. Coming Soon Mode will be available to search engines if your site is not private. Maintenance Mode will notify search engines that the site is unavailable. <a href='https://www.piccbott.com/picc-bot-vs-maintenance-mode/?utm_source=picc-bot-plugin&utm_medium=link&utm_campaign=cc-vs-mm' target='_blank'>Learn the difference between Coming Soon and Maintenance Mode</a>", 'wp-piccbot' ),
        "default_value" => "0"
    );


    $csp4_maintenance_file = WP_CONTENT_DIR."/maintenance.php";
    if (file_exists($csp4_maintenance_file)) {
    $pcbtt_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "enable_maintenance_php",
        "label" => __( "Use maintenance.php", 'wp-piccbot' ),
        "desc" => __('maintenance.php detected, would you like to use this for your maintenance page?', 'wp-piccbot'),
        "option_values" => array(
             'name' => __( 'Yes', 'wp-piccbot' ),
             //'required' => __( 'Make Name Required', 'wp-piccbot' ),
        )
    );
    }

    // Page Setttings
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_page_settings",
        "label" => __( "Page Settings", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "upload",
        "id" => "logo",
        "label" => __( "Logo", 'wp-piccbot' ),
        "desc" => __('Upload a logo or teaser image (or) enter the url to your image.', 'wp-piccbot'),
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textbox",
        "id" => "headline",
        "class" => "large-text",
        "label" => __( "Headline", 'wp-piccbot' ),
        "desc" => __( "Enter a headline for your page.", 'wp-piccbot' ),
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "wpeditor",
        "id" => "description",
        "label" => __( "Message", 'wp-piccbot' ),
        "desc" => __( "Need Shortcode Support? <a href='".pcbtt_csp4_admin_upgrade_link( 'settings-content-shortcode' )."' target='blank' rel='noopener noreferrer' class='pbtt-csp4-cta'>Check out the Pro Version</a> which supports shortcodes, realtime page builder and adds many more features.", 'wp-piccbot' ),
        "class" => "large-text"
    );

     $pcbtt_csp4_options[ ] = array( "type" => "radio",
        "id" => "footer_credit",
        "label" => __("Powered By PiccOrg", 'ultimate-picc-bot-page'),
        "option_values" => array('0'=>__('Nope - Got No Love', 'wp-piccbot'),'1'=>__('Yep - I Love You Man', 'wp-piccbot')),
        "desc" => __("Can we show a <strong>cool stylish</strong> footer credit at the bottom the page.", 'wp-piccbot'),
        "default_value" => "0",
    );


    // Header
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_header",
        "label" => __( "Header", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "upload",
        "id" => "favicon",
        "label" => __( "Favicon", 'wp-piccbot' ),
        "desc" => __('Favicons are displayed in a browser tab. Need Help <a href="http://tools.dynamicdrive.com/favicon/" target="_blank">creating a favicon</a>?', 'wp-piccbot'),
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textbox",
        "id" => "seo_title",
        "label" => __( "SEO Title", 'wp-piccbot' ),
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "seo_description",
        "label" => __( "SEO Meta Description", 'wp-piccbot' ),
        "class" => "large-text"
    );


    $pcbtt_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "ga_analytics",
        "class" => "large-text",
        "label" => __( "Analytics Code", 'wp-piccbot' ),
        "desc" => __('Paste in your Universal or Classic <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> code.', 'wp-piccbot'),
    );


    /**
     * Design Tab
     */
    $pcbtt_csp4_options[ ] = array(
        "type" => "tab",
        "id" => "pcbtt_csp4_design",
        "label" => __( "Design", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "setting",
        "id" => "pcbtt_csp4_settings_design"
    );

    // Themes
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_themes",
        "label" => __( "Pro Themes", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "themes",
        "id" => "themes",
        "label" => __( "Available Pro Themes", 'wp-piccbot' )
    );
    


    // Background
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_background",
        "label" => __( "Background", 'wp-piccbot' )
    );


    $pcbtt_csp4_options[ ] = array(
        "type" => "color",
        "id" => "bg_color",
        "label" => __( "Background Color", 'wp-piccbot' ),
        "default_value" => "#fafafa",
        "validate" => 'color',
        "desc" => __( "Choose between having a solid color background or uploading an image. By default images will cover the entire background.", 'wp-piccbot' )
    );


    $pcbtt_csp4_options[ ] = array(
        "type" => "upload",
        "id" => "bg_image",
        "desc" => '
        <a href="admin.php?page=pcbtt_csp4_stockimages">Looking for free background images?</a> Confirm that\'s your email and click the button below.<br>
        <div id="pbtt-bg-images-form"><input type="email" id="pbtt-bg-images-email"  value="'.get_option('admin_email').'" /><button id="pbtt-bg-images-btn" class="button-primary">Send Me FREE Background Images</button></div>
        <script>
        jQuery( "#pbtt-bg-images-btn" ).click(function(e) {
            e.preventDefault();
            jQuery("#drip-email").val(jQuery("#pbtt-bg-images-email").val());
            jQuery("#drip-submit").click();
        });
        </script>
        ',
        "label" => __( "Background Image", 'wp-piccbot' ),
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "bg_cover",
        "label" => __( "Responsive Background", 'wp-piccbot' ),
        "desc" => __("Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area.", 'wp-piccbot'),
        "option_values" => array(
             '1' => __( 'Yes', 'wp-piccbot' ),
        ),
        "default" => "1",
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_size",
        "desc" => __('Cover (most users will use this setting), this setting will crop parts of the background that do not fit, Contain, this will force the background image to stay contained within the browser and parts that don\'t fit will show the background color.', 'wp-piccbot' ),
        "label" => __( "Responsive Size", 'wp-piccbot' ),
        "option_values" => array(
            'cover' => __( 'Cover', 'wp-piccbot' ),
            'contain' => __( 'Contain', 'wp-piccbot' ),
        )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "bg_overlay",
        "label" => __( "Dim Background", 'wp-piccbot' ),
        "desc" => __("This will add an overlay over your image dimming it.", 'wp-piccbot'),
        "option_values" => array(
             '1' => __( 'Yes', 'wp-piccbot' ),
        ),
        "default" => "1",
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_repeat",
        "desc" => __('This setting is not applied if Responsive Background is checked', 'wp-piccbot' ),
        "label" => __( "Background Repeat", 'wp-piccbot' ),
        "option_values" => array(
            'no-repeat' => __( 'No-Repeat', 'wp-piccbot' ),
            'repeat' => __( 'Tile', 'wp-piccbot' ),
            'repeat-x' => __( 'Tile Horizontally', 'wp-piccbot' ),
            'repeat-y' => __( 'Tile Vertically', 'wp-piccbot' ),
        )
    );


    $pcbtt_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_position",
        "desc" => __('This setting is not applied if Responsive Background is checked', 'wp-piccbot' ),
        "label" => __( "Background Position", 'wp-piccbot' ),
        "option_values" => array(
            'left top' => __( 'Left Top', 'wp-piccbot' ),
            'left center' => __( 'Left Center', 'wp-piccbot' ),
            'left bottom' => __( 'Left Bottom', 'wp-piccbot' ),
            'right top' => __( 'Right Top', 'wp-piccbot' ),
            'right center' => __( 'Right Center', 'wp-piccbot' ),
            'right bottom' => __( 'Right Bottom', 'wp-piccbot' ),
            'center top' => __( 'Center Top', 'wp-piccbot' ),
            'center center' => __( 'Center Center', 'wp-piccbot' ),
            'center bottom' => __( 'Center Bottom', 'wp-piccbot' ),
        )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "select",
        "id" => "bg_attahcment",
        "desc" => __('This setting is not applied if Responsive Background is checked', 'wp-piccbot' ),
        "label" => __( "Background Attachment", 'wp-piccbot' ),
        "option_values" => array(
            'fixed' => __( 'Fixed', 'wp-piccbot' ),
            'scroll' => __( 'Scroll', 'wp-piccbot' ),
        )
    );

    // Background
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_well",
        "label" => __( "Content", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textbox",
        "id" => "max_width",
        "class" => "text-small",
        "label" => __( "Max Width", 'wp-piccbot' ),
        "desc" => __("By default the max width of the content is set to 600px. Enter a number value if you need it bigger. Example: 900", 'wp-piccbot'),    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "enable_well",
        "label" => __( "Enable Well", 'wp-piccbot' ),
        "desc" => __("This will wrap your content in a box.", 'wp-piccbot'),
        "option_values" => array(
             '1' => __( 'Yes', 'wp-piccbot' ),
        ),
    );



    // Text
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_text",
        "label" => __( "Text", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "color",
        "id" => "text_color",
        "label" => __( "Text Color", 'wp-piccbot' ),
        "default_value" => "#666666",
        "validate" => 'required,color',
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "color",
        "id" => "link_color",
        "label" => __( "Link Color", 'wp-piccbot' ),
        "default_value" => "#27AE60",
        "validate" => 'required,color',
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "color",
        "id" => "headline_color",
        "label" => __( "Headline Color", 'wp-piccbot' ),
        "validate" => 'color',
        "default_value" => "#444444",
        "desc" => __('If no Headline Color is chosen then the Link Color will be used. ','wp-piccbot'),
    );



    $pcbtt_csp4_options[ ] = array(
        "type" => "select",
        "id" => "text_font",
        "label" => __( "Text Font", 'wp-piccbot' ),
        "option_values" => apply_filters('pcbtt_csp4_fonts',array(
            '_arial'     => 'Arial',
            '_arial_black' =>'Arial Black',
            '_georgia'   => 'Georgia',
            '_helvetica_neue' => 'Helvetica Neue',
            '_impact' => 'Impact',
            '_lucida' => 'Lucida Grande',
            '_palatino'  => 'Palatino',
            '_tahoma'    => 'Tahoma',
            '_times'     => 'Times New Roman',
            '_trebuchet' => 'Trebuchet',
            '_verdana'   => 'Verdana',
            )),
    );


    // Template
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_template",
        "label" => __( "Template", 'wp-piccbot' )
    );


    $pcbtt_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "custom_css",
        "class" => "large-text",
        "label" => __( "Custom CSS", 'wp-piccbot' ),
        "desc" => __('Need to tweaks the styles? Add your custom CSS here.','wp-piccbot'),
    );

    /**
     * Subscribers Tab
     */
    $pcbtt_csp4_options[ ] = array(
        "type" => "tab",
        "id" => "pcbtt_csp4_subscribers",
        "label" => __( "Subscribers", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "setting",
        "id" => "pcbtt_csp4_settings_subscribers"
    );


    /**
     * Advanced Tab
     */
    $pcbtt_csp4_options[ ] = array(
        "type" => "tab",
        "id" => "pcbtt_csp4_advanced",
        "label" => __( "Advanced", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "setting",
        "id" => "pcbtt_csp4_settings_advanced"
    );


    // Scripts
    $pcbtt_csp4_options[ ] = array(
        "type" => "section",
        "id" => "pcbtt_csp4_section_scripts",
        "label" => __( "Scripts", 'wp-piccbot' )
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "checkbox",
        "id" => "disable_default_excluded_urls",
        "label" => __( "Disable Default Excluded URLs", 'wp-piccbot' ),
        "desc" => __("By default we exclude urls with the terms: login, admin, dashboard and account to prevent lockouts. Check to disable.", 'wp-piccbot'),
        "option_values" => array(
             '1' => __( 'Disable', 'wp-piccbot' ),
        ),
        "default" => "1",
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "header_scripts",
        "label" => __( "Header Scripts", 'wp-piccbot' ),
        "desc" => __('Enter any custom scripts. You can enter Javascript or CSS. This will be rendered before the closing head tag.', 'wp-piccbot'),
        "class" => "large-text"
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "footer_scripts",
        "label" => __( "Footer Scripts", 'wp-piccbot' ),
        "desc" => __('Enter any custom scripts. This will be rendered before the closing body tag.', 'wp-piccbot'),
        "class" => "large-text"
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "html",
        "label" => __( "Custom HTML", 'wp-piccbot' ),
        "desc" => __("This will replace the plugin's entire template with your custom html. Make sure to include the html, head and body tags when replacing the html.", 'wp-piccbot'),
        "class" => "large-text"
    );

    $pcbtt_csp4_options[ ] = array(
        "type" => "textarea",
        "id" => "append_html",
        "label" => __( "Append HTML", 'wp-piccbot' ),
        "desc" => __("This will append html to the bottom of the template using the current styles.", 'wp-piccbot'),
        "class" => "large-text"
    );


    return $pcbtt_csp4_options;

}
