<?php

/**
 * Invoice PDF Generator Class
 *
 * This class handles the functionality of generating PDF URLs for WooCommerce orders
 * and stores the URL in the order metadata. It interacts with the 'PDF Invoices & Packing Slips for WooCommerce' plugin.
 */
class Invoice_PDF_Generator {

    /**
     * Constructor for the Invoice_PDF_Generator class.
     *
     * Initializes the class by hooking into the 'wpo_wcpdf_before_document' action 
     * to generate the PDF URL for invoices, and also initializes the Order API class.
     */
    public function __construct() {
        // Hook into the action to generate the PDF URL before the document is created.
        add_action( 'wpo_wcpdf_before_document', [ $this, 'generate_pdf_url_for_order' ], 10, 2 );

        // Instantiate the Order_API class to handle order-related tasks.
        new Order_API();
    }

    /**
     * Generates the PDF URL for an order and updates the order metadata with the PDF link.
     *
     * This method is hooked to the 'wpo_wcpdf_before_document' action and is triggered 
     * when a WooCommerce invoice is being generated. It constructs the PDF URL and 
     * saves it as order metadata.
     *
     * @param string $document_type The type of document being generated (invoice, packing slip, etc.).
     * @param object $order The WooCommerce order object.
     */
    public function generate_pdf_url_for_order( $document_type, $order ) {
        // Ensure that the order object is valid and the document type is 'invoice'.
        if( !empty($order) && $document_type == 'invoice' ) {
            // Instantiate PDF_URL_Generator to create the PDF URL for the invoice.
            $pdf_url_generator = new PDF_URL_Generator();

            // Generate the invoice PDF URL using the order ID and order key.
            $pdf_url = $pdf_url_generator->generate_invoice_pdf_url( $order->get_id(), $order->get_order_key() );

            // Save the generated PDF URL as order metadata for future reference.
            update_post_meta( $order->get_id(), '_wcpdf_document_link', esc_attr($pdf_url) );
        }
    }
}
