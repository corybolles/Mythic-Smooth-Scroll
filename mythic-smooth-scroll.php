<?php
/**
* @package MythicSmoothScroll
*/
/*
Plugin Name: Mythic Smooth Scroll
Plugin URI: https://github.com/corybolles/Mythic-Smooth-Scroll
Description: Simple jQuery smooth scroll plugin with optional offset for fixed headers.
Version: 1.0.0
Author: Mythic Design Company
Author URI: http://mythicdesigncompany.com
License: GPLv3
Text Domain: mythic-smooth-scroll
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright (C) 2018 Mythic Design Company
*/

defined('ABSPATH') or die('Please don\t access me in this way. I feel invaded.');

function mythic_ss_register_settings() {
   add_option( 'mythic_ss_header_id', '');
   add_option( 'mythic_ss_offset_amount', '50');
    
   register_setting( 'mythic_ss_options', 'mythic_ss_header_id');
   register_setting( 'mythic_ss_options', 'mythic_ss_offset_amount');
}
add_action( 'admin_init', 'mythic_ss_register_settings' );

function mythic_ss_register_options_page() {
    add_options_page('Mythic Smooth Scroll', 'Mythic Smooth Scroll', 'manage_options', 'mythic-smooth-scroll', 'mythic_ss_options_page');
}

add_action('admin_menu', 'mythic_ss_register_options_page');

function mythic_ss_options_page() {
    
?>

    <div>
        <h1>Mythic Smooth Scroll</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'mythic_ss_options' );
                do_settings_sections( 'mythic_ss_options' );
            ?>
            <label for="mythic_ss_header_id"><strong>Header ID (Leave blank if you're header is not fixed)</strong></label><br>
            <a href="#">Not sure how to find this?</a><br>
            <input type="text" id="mythic_ss_header_id" name="mythic_ss_header_id" value="<?php echo get_option('mythic_ss_header_id'); ?>" /><br>
            <br>
            <label for="mythic_ss_offset_amount"><strong>Scroll Offset Amount (Default is 50). Will be added to fixed header's height.</strong></label><br>
            <input type="text" id="mythic_ss_offset_amount" name="mythic_ss_offset_amount" value="<?php echo get_option('mythic_ss_offset_amount'); ?>" pattern= "[0-9]+"/><br>
            <br>
            <?php  submit_button(); ?>
        </form>
    </div>

<?php
    
}



function mythic_ss_init(){
    
    if(is_admin_bar_showing()) {
        $adminBar = true;
    } else {
        $adminBar = false;
    }
    
    $data = array(
        'headerId' => get_option('mythic_ss_header_id'),
        'offsetAmount' => get_option('mythic_ss_offset_amount'),
        'adminBar' => $adminBar
    );
    
    wp_enqueue_script('smoothScroll', plugin_dir_url( __FILE__ ) . 'js/smoothscroll.js', array('jquery'), '1.0' );
    wp_localize_script('smoothScroll', 'smoothScrollData', $data);
}

add_action( 'wp_enqueue_scripts', 'mythic_ss_init' );