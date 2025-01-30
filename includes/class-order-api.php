<?php

/**
 * Order API Class
 *
 * This class handles the functionality of adding a PDF URL to the WooCommerce REST API 
 * response for shop order objects. It integrates with the 'PDF Invoices & Packing Slips for WooCommerce' plugin 
 * to generate PDF URLs for orders.
 */
class Order_API {

    /**
     * Constructor for the Order_API class.
     *
     * This constructor initializes the class by hooking into the WooCommerce REST API filter 
     * 'woocommerce_rest_prepare_shop_order_object' to modify the order response by adding 
     * the generated PDF URL to the order data.
     */
    public function __construct() {
        // Hook into the WooCommerce REST API to add PDF URL to order responses.
        add_filter( 'woocommerce_rest_prepare_shop_order_object', [ $this, 'add_pdf_url_to_order' ], 10, 3 );
    }

    /**
     * Adds the PDF URL to the WooCommerce order data in the REST API response.
     *
     * This method is triggered when the WooCommerce REST API prepares an order object response. 
     * It generates the PDF URL for the invoice and adds it to the order data that is returned 
     * in the API response.
     *
     * @param WP_REST_Response $response The REST API response object containing order data.
     * @param WC_Order $object The WooCommerce order object.
     * @param WP_REST_Request $request The request object sent to the REST API.
     *
     * @return WP_REST_Response The modified response object with the added PDF URL.
     */
    public function add_pdf_url_to_order( $response, $object, $request ) {
        // Get the Order ID from the response data.
        $order_id = $response->data['id'];

        // Retrieve the WooCommerce order object using the Order ID.
        $order = wc_get_order( $order_id );

        // If the order exists, generate the PDF URL for the invoice and add it to the response data.
        if ( $order ) {
            // Get the order key to generate the PDF URL.
            $order_key = $order->get_order_key();

            // Instantiate the PDF_URL_Generator class to generate the PDF URL.
            $pdf_url_generator = new PDF_URL_Generator();

            // Generate the invoice PDF URL using the order ID and order key.
            $pdf_url = $pdf_url_generator->generate_invoice_pdf_url( $order_id, $order_key );

            // Add the generated PDF URL to the response data.
            $response->data['invoice_pdf_url'] = $pdf_url;
        }

        // Return the modified response with the added PDF URL.
        return $response;
    }
}
