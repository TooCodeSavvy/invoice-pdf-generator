<?php

class Order_API {
    public function __construct() {
        add_filter( 'woocommerce_rest_prepare_shop_order_object', [ $this, 'add_pdf_url_to_order' ], 10, 3 );
    }

    public function add_pdf_url_to_order( $response, $object, $request ) {
        $order_id = $response->data['id'];
        $order = wc_get_order( $order_id );

        if ( $order ) {
            $order_key = $order->get_order_key();
            $pdf_url_generator = new PDF_URL_Generator();
            $pdf_url = $pdf_url_generator->generate_invoice_pdf_url( $order_id, $order_key );
            $response->data['invoice_pdf_url'] = $pdf_url;
        }

        return $response;
    }
}
