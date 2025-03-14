<?php
/*
* color setting options
*/
function yacht_manager_myplugin_register_settings() {
    $options = [
        'ytm_primary_text',
        'ytm_secondary_text',
        'ytm_body_text',
        'ytm_card_primary_text',
        'ytm_primary_bg',
        'ytm_secondary_bg',
        'ytm_primary_line',
    ];

    $colors = [
        '#000000',
        '#a8a8a8',
        '#5e5e5e',
        '#ffffff',
        '#f0f0f0',
        '#f9f9f9',
        '#f5f5f5',
    ];
    $count = 0;
    foreach ($options as $option) {
        add_option($option, $colors[$count]);
        register_setting('ytm_setting_color', $option);
        $count++;
    }
}
add_action('admin_init', 'yacht_manager_myplugin_register_settings');

function yacht_manager_myplugin_settings_page() { ?>
    <div class="wrap">
        <h2>Color Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('ytm_setting_color'); ?>
            <table class="form-table">
                <tr>
                    <td colspan="2">
                        <h3 class="label">Section Color</h3>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Primary Text Color:</th>
                    <td>
                        <input type="text" id="ytm_primary_text" name="ytm_primary_text" value="<?php echo esc_attr(get_option('ytm_primary_text')); ?>" class="ytm-color-picker" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for the primary text.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Body Text Color:</th>
                    <td><input type="text" id="ytm_body_text" name="ytm_body_text" value="<?php echo esc_attr(get_option('ytm_body_text')); ?>" class="ytm-color-picker" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for the body text.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h3 class="label">Background Color</h3>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Primary Background Color:</th>
                    <td><input type="text" id="ytm_primary_bg" name="ytm_primary_bg" value="<?php echo esc_attr(get_option('ytm_primary_bg')); ?>" class="ytm-color-picker" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for the primary background.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Secondary Background Color:</th>
                    <td><input type="text" id="ytm_secondary_bg" name="ytm_secondary_bg" value="<?php echo esc_attr(get_option('ytm_secondary_bg')); ?>" class="ytm-color-picker" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for the secondary background.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Primary Line Color:</th>
                    <td><input type="text" id="ytm_primary_line" name="ytm_primary_line" value="<?php echo esc_attr(get_option('ytm_primary_line')); ?>" class="ytm-color-picker" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for the Line Behind Card.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h3 class="label">Card Color</h3>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Card Primary Text Color:</th>
                    <td><input type="text" id="ytm_card_primary_text" name="ytm_card_primary_text" value="<?php echo esc_attr(get_option('ytm_card_primary_text')); ?>" class="ytm-color-picker" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for the text card.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Card Secondary Text Color:</th>
                    <td><input type="text" id="ytm_card_secondary_text" name="ytm_card_secondary_text" value="<?php echo esc_attr(get_option('ytm_card_secondary_text')); ?>" class="ytm-color-picker" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for the secondary text.</p>
                    </td>
                </tr>
                <!-- <tr>
                    <td colspan="2">
                        <h3 class="label">Filter Color</h3>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">CTA Text Color:</th>
                    <td><input type="text" id="ytm_cta_text" name="ytm_cta_text" value="<?php echo esc_attr(get_option('ytm_cta_text')); ?>" class="ytm-color-picker" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p class="description">This color is used for text color inside primary color, button.</p>
                    </td>
                </tr> -->
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php }
