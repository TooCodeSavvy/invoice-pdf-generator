<?php
class PDF_URL_Generator {
    public function generate_invoice_pdf_url( $order_id, $order_key ) {
        return admin_url( 'admin-ajax.php?action=generate_wpo_wcpdf&template_type=invoice&order_ids=' . $order_id . '&order_key=' . $order_key . '&my-account=true' );
    }
}
