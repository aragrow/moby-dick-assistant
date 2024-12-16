<?php

/*
Purpose: Prevents direct access to the file. The check ensures that the file is only executed within the WordPress environment 
(not directly accessed via the browser).
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class WP_Queequeq_ShortCodes {

    public function __construct() {

       // add_action('admin_post_save_injury_data', [$this,'save_injury_data']);
       // add_action('admin_post_nopriv_save_injury_data', [$this,'save_injury_data']);

       // Register the shortcode
        add_shortcode('queequeg', [$this, 'queequeg_shortcode_search']);
    
    }


    function queequeg_shortcode_search($atts) {
        // Set the default parameters for the shortcode
        $atts = shortcode_atts(
            array(
                'url' => 'https://127.0.0.1:5500/api/v1/', // Default URL (can be overridden in the shortcode),
                'key' => 'DEMO',
                'mode' => 'GET'
            ),
            $atts,
            'queequeg'
        );
    
        // Initialize cURL session
        $ch = curl_init();
    
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $atts['url']);      // URL to request
        
        // Return the response instead of printing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    // Return response as a string
        
        // If the server says this URL has moved, go ahead and follow the new address automatically until you reach the final destination.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);    // Follow redirects if any
        
        if($atts['method'] == 'POST') 
            // Set the HTTP method to POST
            curl_setopt($ch, CURLOPT_POST, true);
        else {
            // Set the HTTP method to GET
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Change to POST, PUT, etc., as needed
        }

        // Set headers, including the Bearer token
        $headers = [
            "Authorization: Bearer {$atts['key']}",
            "Content-Type: application/json" // Add more headers if necessary
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Disable SSL verification (for local testing only)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute cURL and store the result
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if(curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return "Error: " . $error_msg;
        }
    
        // Close cURL session
        curl_close($ch);
    
        // Return the response or process it (e.g., display as JSON)
        return $response;
    }

}

/*
Purpose: Creates an instance of the WP_InShape_Admin_UI class.
*/
new WP_Queequeq_ShortCodes();