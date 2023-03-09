# Karrieretag_Projekt

###Keine HTML oder JavaScript Theorie


## 1. Theorie $content, add_filter()
$content

The $content variable typically represents the content of a WordPress post or page. This can include text, images, videos, and other media that is included in the post or page content.

When you write a plugin or theme for WordPress, you may want to modify the post or page content before it is displayed on the website. To do this, you can use the the_content filter hook, which provides access to the $content variable.

Here's an example of how you might use the the_content filter hook to modify the post content:

function my_custom_content_filter( $content ) {
    // modify $content as desired
    return $content;
}
add_filter( 'the_content', 'my_custom_content_filter' );

In this example, the my_custom_content_filter() function will be executed whenever the the_content filter hook is run, and it will modify the post content before it is displayed on the website.

Note that $content can also be used in other filter and action hooks in WordPress, depending on the context. For example, it might represent the content of a comment or the body of an email message.

##2. Theorie classes

class 'name' {}'

Basic class deinitions begin with the keyword class, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class.

Example #1 Simple Class definition

    <?php
    class SimpleClass
    {
        // property declaration
        public $var = 'a default value';

        // method declaration
        public function displayVar() {
            echo $this->var;
        }
    }
    ?>
    
The pseudo-variable $this is available when a method is called from within an object context. $this is the value of the calling object.

In this class you can define funktion and call them in the class with $this. 


##3. Theorie array($this, 'method') vs $this -> 'method'

In object-oriented programming in PHP, '$this->method()' and ' array($this, method)' both allow you to call a method on the current object. However, there are some differences in how they work.

The syntax '$this->mehtod()' is the more commen and straightforword way to call a mathod on the current obhect. It simply calls the method using the  object operator '->' 
For exmaple:

    class MyClass {
        public function myMethod() {
            echo "Hello, world!";
        }
    }

    $obj = new MyClass();
    $obj->myMethod(); // Output: "Hello, world!"

On the other hand 'array($this, method)' creates an arry containing the current object ('$this') and the name of the method to call ('method'). This array can the be passed as a callback to function that accept callbacks, such as 'call_user_func_array()'. For example:

    class MyClass {
        public function myMethod() {
            echo "Hello, world!";
        }

        public function callMyMethod() {
            call_user_func_array(array($this, 'myMethod'), array());
        }
    }

    $obj = new MyClass();
    $obj->callMyMethod(); // Output: "Hello, world!"
    
In this example, 'callMyMethod()' creates an array containing '$this' and the string ´'myMethod'´, and passes it to 'call_user_func_array()'.'call_user_func_array()' then calls the 'myMethod()' method on '$this', which outputs '"Hello, world!"'.

In summery , 'this->method()' ist the more common way to call a method on the current object, while 'array($this, method)' is userful when you need to pass the method as a callback to other functions.

##3. Theorie add_action

In PHP, the 'add_action' function is used in WordPress to add a new action to the WordPress action system

The WordPressa action system allows developers to hook inot specific events in the Wordpress codebase and execute their own custom code when thos events occur. The 'add_action' function allows you to register a new funtion to be executed when a specific action occurs.

Here is an example of how 'add_acton' can be used in WordPress:

    // Define a new function to be executed
    function my_custom_function() {
       // Your custom code goes here
    }

    // Register the new function to be executed when the 'wp_head' action occurs
    add_action( 'wp_head', 'my_custom_function' );

In this example , the 'my_custom_function' function is definded, and then registered to be executed when the ´'wp_head'´ aciton occurs by calling 'add_action' and passing in the aciton name 'wp_head' as the first parameter, and the name of the function to execute ('my_custom_function') as the second parameter.

Whenever the 'wp_head' action occurs in the WordPress code, the 'my_custom_fnction' function will be executed, allowin you to perform your own custom code at that point in the WordPress codebase.    


##4. Theorie register_setting(), settings_field(), settings_section()

register_setting(),

In PHP, the 'register_setting' function is used in WordPress to register a new setting with the WordPress options system

The WordPress options system allows developers to store and retrieve settings for their  WordPress plugins or themes. The 'register_settings' function allows you to register a new setting with the Wordpress options system, defining the default value, validation rules, and other attributes for that setting.

Here is an example of how 'register_setting' can be used in WordPress:

    // Register a new setting with the WordPress options system
    function my_plugin_settings_init() {
      register_setting( 'my-plugin-settings', 'my_plugin_option', array(
        'type' => 'string',
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
      ) );
    }

    // Call the my_plugin_settings_init function on the 'admin_init' action
    add_action( 'admin_init', 'my_plugin_settings_init' );

In this example, we define a function 'my_plugin_settings_init' that calls the 'register_setting' function to register a new setting with the name 'my_plugin_option' in the WordPress option system. We also define the setting type as a string, set the default value to an empty string, and specify the 'sanitize_text_field' function as the callback to sanitize the user input for this setting.

Finally, we add an action hook to the 'admin_init' event to call our 'my_plugin_settings_init' function, which registers the new setting with the WordPress options system.

Once the setting is registered, it can be accessed and updated using the WordPress options API function like 'get_option' and 'update_option'.




 
