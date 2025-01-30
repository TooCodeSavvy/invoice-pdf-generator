Invoice PDF Generator for WooCommerce
=====================================

This plugin integrates with **PDF Invoices & Packing Slips for WooCommerce** to provide PDF invoice URLs through the WooCommerce REST API. By default, WooCommerce does not return the URL for generated PDF invoices when using the `wp-json` API. This plugin solves that issue by generating the correct PDF URL and adding it to the order's REST API response.

Requirements
------------

-   **WooCommerce** installed and activated.
-   **PDF Invoices & Packing Slips for WooCommerce** plugin installed and activated.
-   **Invoice PDF Generator for WooCommerce** plugin (this plugin).

Features
--------

-   Adds PDF invoice URLs to WooCommerce REST API order responses.
-   Generates valid PDF URLs for invoices without requiring a nonce in the URL.
-   Compatible with the **PDF Invoices & Packing Slips for WooCommerce** plugin.

Installation
------------

1.  Install and activate the **PDF Invoices & Packing Slips for WooCommerce** plugin.
2.  Install and activate the **Invoice PDF Generator for WooCommerce** plugin (this plugin).
3.  The PDF invoice URLs will automatically be available in the WooCommerce REST API order data.

How it Works
------------

This plugin hooks into WooCommerce order processing to generate PDF invoice URLs. When you retrieve order data through the WooCommerce REST API, the PDF invoice URL will be available under the key `invoice_pdf_url`.

It works by listening to the `wpo_wcpdf_before_document` action and the `woocommerce_rest_prepare_shop_order_object` filter. The URL for the invoice PDF is generated and stored in the order meta, then added to the API response for easy access.

Usage
-----

After installing and activating the plugin, the PDF invoice URL will be available in the order data returned from the WooCommerce REST API. The URL will be available in the `invoice_pdf_url` field of the order object.

Example API Response:

```
{
    "id": 123,
    "order_key": "wc_order_abc123",
    "invoice_pdf_url": "https://yourwebsite.com/admin-ajax.php?action=generate_wpo_wcpdf&template_type=invoice&order_ids=123&order_key=wc_order_abc123&my-account=true"
}
```

Code Breakdown
--------------

### `wpo_wcpdf_before_document` Hook

The following hook generates the PDF invoice URL and stores it in the order meta:

```
add_action( 'wpo_wcpdf_before_document', function( $document_type, $order ) {
    if( !empty($order) && $document_type == 'invoice' ) {
        // Generate the PDF URL for the invoice
        $pdf_url = admin_url( 'admin-ajax.php?action=generate_wpo_wcpdf&template_type='.$document_type.'&order_ids=' . $order->get_id() . '&order_key=' . $order->get_order_key() . '&my-account=true' );

        // Store the PDF URL in the order meta
        update_post_meta( $order->get_id(), '_wcpdf_document_link', esc_attr($pdf_url) );
    }
}, 10, 2 );
```

### REST API Filter to Add PDF URL to Order Response

The following filter adds the PDF URL to the REST API order data response:

```
add_filter( 'woocommerce_rest_prepare_shop_order_object', function( $response, $object, $request ) {
    // Get the Order ID and Order Key
    $order_id = $response->data['id'];
    $order = wc_get_order( $order_id );

    if ( $order ) {
        $order_key = $order->get_order_key();

        // Generate the PDF URL without nonce and with &my-account=true
        $pdf_url = admin_url( 'admin-ajax.php?action=generate_wpo_wcpdf&template_type=invoice&order_ids=' . $order_id . '&order_key=' . $order_key . '&my-account=true' );

        // Add the PDF URL to the response
        $response->data['invoice_pdf_url'] = $pdf_url;
    }

    return $response;
}, 10, 3 );
```

File and Class Structure
------------------------
```
invoice-pdf-generator/
├── assets/              # Plugin assets (images, JS, etc.)
├── includes/
│   ├── class-pdf-url-generator.php      # Handles the PDF URL generation
│   ├── class-order-api.php             # Extends WooCommerce REST API response to include PDF URL
│   └── class-invoice-pdf-generator.php # Main plugin class
├── languages/           # Translation files
├── plugin.php           # Main plugin entry point
├── readme.md           # This file`
```


Conclusion
----------

This plugin allows you to retrieve invoice PDF URLs directly from the WooCommerce REST API. It integrates seamlessly with the **PDF Invoices & Packing Slips for WooCommerce** plugin, ensuring that your WooCommerce orders can now provide PDF invoice links for external systems or integrations.