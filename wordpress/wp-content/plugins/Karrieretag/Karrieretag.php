<?php
/*
    * Plugin Name: AppleSucks
    * Description: Handle the basics with this plugin.
    * Version: 1.10.3
    * Requires at least: 5.2
    * Requires PHP: 7.2
    */

if( ! defined( 'ABSPATH') ){
    die;
}

class KarrieretagPlugin{
    //variables

    public $form_names = array();

    //methods
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'custom_menu_page'));
    }

    function activate(){
        //function called on activation of the plugin
        $this->custom_menu_page();
        flush_rewrite_rules();
    }

    function deactivate(){
        //function called on deactivation of the plugin
        flush_rewrite_rules();
    }

    function uninstall(){
        //function called on uninstallation of the plugin
    }

    function custom_menu_page(){
        add_menu_page('AppleSucks',  'AppleSucks', 'manage_options', 'AppleSucks', array($this, 'test_init'));
    }

    function test_init(){
        $this->make_menu_page();
    }

    function make_menu_page()
    {
        echo "<h1>AppleSucks</h1>";
        echo "<form method='post' id='Forms-to-check'>";
        for ($i = 0; $i < count($this->find_forms_on_website()); $i++) {
            $form_name = $this->get_form_name($this->find_forms_on_website()[$i]);
            if (isset($_POST["_" . $form_name . "_"])) {
                echo "<input type='checkbox' name='$form_name' checked> " . $form_name . "<a href='../wp-content/plugins/Karrieretag/exportData.php?dbTable=".$form_name."'>Export</a>" . "<br>";
            } else {
                echo "<input type='checkbox' name='$form_name'> " . $form_name . "<a href='../wp-content/plugins/Karrieretag/exportData.php?dbTable=".$form_name."'>Export</a>" . "<br>";
            }

            $this->form_names[] = $form_name;
        }
        echo "<input type='submit'></form>";

        echo "<a href='../wp-content/plugins/Karrieretag/exportData.php'>Export</a>";
    }

    function button_clicks(){
        foreach ($this->form_names as $form_name) {
            $button_name = $form_name . "button";
            if(isset($_POST[$button_name])){
                echo $button_name . "was clicked";
            }
            echo $button_name;
        }
    }

    function find_forms_on_website() {
        $args = array(
            'post_type' => 'any',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $posts = get_posts($args);

        $forms = array();

        foreach ($posts as $post) {
            preg_match_all('/<form.*<\/form>/siU', $post->post_content, $matches);
            foreach ($matches[0] as $match) {
                $forms[] = $match;
            }
        }

        return $forms;
    }

    function get_form_name($form)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($form);
        $form_name = $doc->getElementsByTagName('form')->item(0)->getAttribute('name');
        return $form_name;
    }
}

if( class_exists('KarrieretagPlugin' ) ) {
    $karrieretagPlugin = new KarrieretagPlugin();
}

register_activation_hook(__FILE__, array($karrieretagPlugin, 'activate'));

register_activation_hook(__FILE__, array($karrieretagPlugin, 'deactivate'));
?>