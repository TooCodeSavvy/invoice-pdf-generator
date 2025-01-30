<?php

/**
 * PDF URL Generator Class
 *
 * This class is responsible for generating the URL for the invoice PDF file 
 * using the WooCommerce PDF Invoices & Packing Slips plugin. 
 * It constructs the URL required to generate the PDF for a specific order.
 */
class PDF_URL_Generator {

    /**
     * Generates the URL for the invoice PDF for a given order.
     *
     * This method constructs the URL that triggers the PDF generation action 
     * in the WooCommerce admin area, providing the order ID and order key to 
     * ensure the correct invoice is generated.
     *
     * @param int $order_id The ID of the WooCommerce order.
     * @param string $order_key The unique key associated with the WooCommerce order.
     *
     * @return string The URL used to generate the invoice PDF for the specified order.
     */
    public function generate_invoice_pdf_url( $order_id, $order_key ) {
        // Construct the URL for the PDF generation with the required parameters.
        return admin_url( 'admin-ajax.php?action=generate_wpo_wcpdf&template_type=invoice&order_ids=' . $order_id . '&order_key=' . $order_key . '&my-account=true' );
    }
}
