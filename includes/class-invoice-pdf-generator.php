<?php

class Invoice_PDF_Generator {
    public function __construct() {
        add_action( 'wpo_wcpdf_before_document', [ $this, 'generate_pdf_url_for_order' ], 10, 2 );
        new Order_API();
    }

    public function generate_pdf_url_for_order( $document_type, $order ) {
        if( !empty($order) && $document_type == 'invoice' ) {
            $pdf_url_generator = new PDF_URL_Generator();
            $pdf_url = $pdf_url_generator->generate_invoice_pdf_url( $order->get_id(), $order->get_order_key() );
            update_post_meta( $order->get_id(), '_wcpdf_document_link', esc_attr($pdf_url) );
        }
    }
}
