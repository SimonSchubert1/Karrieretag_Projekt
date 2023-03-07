<?php
    /*
    * Plugin Name:       AppleSucks
    * Description:       Handle the basics with this plugin.
    * Version:           1.10.3
    * Requires at least: 5.2
    * Requires PHP:      7.2
    */
    add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
  
    function my_custom_dashboard_widgets() {
        global $wp_meta_boxes;
    
        wp_add_dashboard_widget('custom_help_widget', 'AppleSucks', 'custom_dashboard_help');
    }
        
    function custom_dashboard_help() {
    echo '<p>Welcome to Custom Blog Theme! Need help? Contact the developer <a href="mailto:yourusername@gmail.com">here</a>. For WordPress Tutorials visit: <a href="https://www.wpbeginner.com" target="_blank">WPBeginner</a></p>';
    }
?>