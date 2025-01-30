<?php
/**
 * Plugin Name: Invoice PDF Generator for WooCommerce
 * Description: Adds PDF invoice URLs to WooCommerce REST API responses.
 * Version: 1.0.0
 * Author: Anouar
 */

// Include necessary class files for the plugin functionality
require_once plugin_dir_path( __FILE__ ) . 'includes/class-invoice-pdf-generator.php'; 
require_once plugin_dir_path( __FILE__ ) . 'includes/class-order-api.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-pdf-url-generator.php'; 


/**
 * Plugin initialization: Instantiates the main class that handles functionality.
 *
 * This code is responsible for bootstrapping the plugin by creating an instance
 * of the Invoice_PDF_Generator class. The class initializes the necessary hooks
 * to integrate with WooCommerce and generate the invoice PDF URLs.
 */
new Invoice_PDF_Generator();