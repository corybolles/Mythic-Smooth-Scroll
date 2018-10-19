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

function registerSettings() {
   add_option( 'mythicSmoothScrollHeaderID', '');
   add_option( 'mythicSmoothScrollOffsetAmount', '50');
    
   register_setting( 'mythicSmoothScrollOptions', 'mythicSmoothScrollHeaderID');
   register_setting( 'mythicSmoothScrollOptions', 'mythicSmoothScrollOffsetAmount');
}
add_action( 'admin_init', 'registerSettings' );

function registerOptionsPage() {
    add_options_page('Smooth Scroll Options', 'Mythic Smooth Scroll', 'manage_options', 'mythic-smooth-scroll', 'mythicSmoothScrollOptionsPage');
}

add_action('admin_menu', 'registerOptionsPage');

function mythicSmoothScrollOptionsPage() {
    
?>

    <div>
        <h1>Mythic Smooth Scroll</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'mythicSmoothScrollOptions' );
                do_settings_sections( 'mythicSmoothScrollOptions' );
            ?>
            <table style="text-align: left;">
                <tr valign="top">
                    <th scope="row"><label for="mythicSmoothScrollHeaderID">Header ID (Leave blank if you're header is not fixed)</label></th>
                    <td><input type="text" id="mythicSmoothScrollHeaderID" name="mythicSmoothScrollHeaderID" value="<?php echo get_option('mythicSmoothScrollHeaderID'); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="mythicSmoothScrollOffsetAmount">Scroll Offset Amount (Default is 50). Will be added to fixed header's height.</label></th>
                    <td><input type="text" id="mythicSmoothScrollOffsetAmount" name="mythicSmoothScrollOffsetAmount" value="<?php echo get_option('mythicSmoothScrollOffsetAmount'); ?>" pattern= "[0-9]+"/></td>
                </tr>
            </table>
            <?php  submit_button(); ?>
        </form>
    </div>

<?php
    
}



function smoothScrollInit(){
    
    if(is_admin_bar_showing()) {
        $adminBar = true;
    } else {
        $adminBar = false;
    }
    
    $data = array(
        'headerId' => get_option('mythicSmoothScrollHeaderID'),
        'offsetAmount' => get_option('mythicSmoothScrollOffsetAmount'),
        'adminBar' => $adminBar
    );
    
    wp_enqueue_script('smoothScroll', plugin_dir_url( __FILE__ ) . 'js/smoothscroll.js', array('jquery'), '1.0' );
    wp_localize_script('smoothScroll', 'smoothScrollData', $data);
}

add_action( 'wp_enqueue_scripts', 'smoothScrollInit' );