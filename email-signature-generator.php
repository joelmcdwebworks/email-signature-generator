<?php

/**
 * Plugin Name:       Email Signature Generator
 * Plugin URI:        https://mcdwebworks.com
 * Description:       Create a customizable signature for members of your business or organization to use in emails. Display signature generator anywhere on your WordPress website with a shortcode.
 * Version:           0.0.1
 * Author:            Joel McDonald | McDonald Web Works
 * Author URI:        https://mcdwebworks.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       email-signature-generator
 */

if( ! class_exists( 'Email_Signature_Generator' ) ) {

    class Email_Signature_Generator {

        public static function run() {
            
            $this_function = array(
                'slug' => '',
                'style' => '',
                'script' => '',
            );

            global $this_function;

            // Loop through all functions directories and include functions if active.

            $functions = scandir( plugin_dir_path(__FILE__) . 'functions' );

            foreach( $functions as $function ) {

                if( $function != '.' && $function != '..' ) {
                    
                    $this_function['slug'] = $function;
                    $this_function['style'] = $function . '-style';
                    $this_function['script'] = $function . '-script';

                    $file = 'functions/' . $this_function['slug'] . '/activator.php';

                    include_once $file;

                } //if

            } //foreach

            // Enable update checker for Github releases.

            require 'plugin-update-checker/plugin-update-checker.php';

            $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
                'https://github.com/joelmcdwebworks/email-signature-generator/',
                __FILE__,
                'gf-popup-confirmations'
            );

            //Set the branch that contains the stable release.
            $myUpdateChecker->setBranch('main');

            $myUpdateChecker->getVcsApi()->enableReleaseAssets();             

        } // run()

    }

    GF_Popup_Confirmations::run();

 }

?>
