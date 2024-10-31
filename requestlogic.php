<?php

/**
 * @package requestlogic
 */

/*
Plugin Name: RequestLogic
Plugin URI: https://www.requestlogic.com/tutorial
Description: This plugin is a marketing tool used to expand and manage your fan base and learn about their interests.
Version: 1.0.0
Author: Berries & Company
Author URI: https://www.berriesand.co
License: GPLv2 or later
Text Domain: requestlogic
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

Copyright 2021 Berries & Company
*/

if (!class_exists('RequestLogic')) {

    class RequestLogic
    {
        protected function create_post_type()
        {
            add_action('init', array($this, 'custom_post_type'));
        }

        function register()
        {
            add_action('admin_enqueue_scripts', array($this, 'enqueue'));

            add_action('admin_menu', array($this, 'add_admin_pages'));
            $name = plugin_basename(__FILE__);
            add_filter("rl_plugin_action_links_$name", array($this, 'settings_link'));
        }

        public function settings_link($links)
        {
            $settings_link = '<a href="admin.php?page=requestlogic_plugin">Settings</a>';
            array_push($links, $settings_link);
            return $links;
        }

        function add_admin_pages()
        {
            add_menu_page('RequestLogic plugin', 'RequestLogic', 'manage_options', 'requestlogic_plugin', array($this, 'admin_index'), plugins_url('/assets/img/logo.png', __FILE__), 110);
        }

        function admin_index()
        {
            require_once plugin_dir_path(__FILE__) . 'templates/admin.php';
        }

        function activate()
        {
            $this->costum_post_type();
            flush_rewrite_rules();
        }

        function deactivate()
        {
            flush_rewrite_rules();
        }

        protected function costum_post_type()
        {
            register_post_type('requestlogic',  ['public' => true, 'label' => 'RequestLogic']);
        }

        function enqueue()
        {
            wp_enqueue_style('bscss', plugins_url('/assets/bootstrap.min.css', __FILE__));
            wp_enqueue_script('rjquery');
            wp_enqueue_script('bsjs', plugins_url('/assets/bootstrap.min.js', __FILE__));

            wp_enqueue_style('rl_mypluginstyle', plugins_url('/assets/forms.css', __FILE__));
            wp_enqueue_script('rl_mypluginscript', plugins_url('/assets/forms.js', __FILE__));
        }
    }

    $rLogic = new RequestLogic();
    $rLogic->register();


    register_activation_hook(__FILE__, array($rLogic, 'activate'));

    register_deactivation_hook(__FILE__, array($rLogic, 'deactivate'));
}

function requestlogic_generateForm($attr)
{
    wp_register_script('rl-form-script', 'https://morepuzzlesblobstorage.blob.core.windows.net/requestlogic/resources/formscript.js');
    wp_enqueue_script('rl-form-script');
    $attributes = shortcode_atts(array('accountid' => '#', 'formid' => '#', 'key' => '#'), $attr);
    $url = 'https://berries-functions.azurewebsites.net/api/'.$attributes['accountid'].'/form/'.$attributes['formid'].'_'.$attributes['key'].'/wordpress';
    $html = file_get_contents($url);
    return $html;
}

add_shortcode('requestlogic', 'requestlogic_generateForm');