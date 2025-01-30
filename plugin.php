<?php
/**
 * Plugin Name: Invoice PDF Generator for WooCommerce
 * Description: Adds PDF invoice URLs to WooCommerce REST API responses.
 * Version: 1.0.0
 * Author: Anouar Jaama
 */

// Include the main plugin class
require_once plugin_dir_path( __FILE__ ) . 'includes/class-invoice-pdf-generator.php'; 
require_once plugin_dir_path( __FILE__ ) . 'includes/class-order-api.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pdf-url-generator.php'; 


// Initialize the plugin
new Invoice_PDF_Generator();
