<?php
echo "\n\n";
try{
    $url = 'http://dltr.org/index.php/api/soap/?wsdl';
    $url2 = 'http://dltr.org/index.php/api/v2_soap/index/?wsdl';

    //
    $opts = array(
        'http'=>array(
            'user_agent' => 'PHPSoapClient'
        )
    );

    $context = stream_context_create($opts);

    $client = new SoapClient($url, array('trace' => true, 'stream_context' => $context, 'cache_wsdl' => WSDL_CACHE_NONE));
    $client2 = new SoapClient($url2, array('trace' => true, 'stream_context' => $context, 'cache_wsdl' => WSDL_CACHE_NONE));

    $session = $client2->login('dltrtestuser', 'dltrtestkey');

    // get attribute set
    $attributeSets = $client2->catalogProductAttributeSetList($session);

    /*foreach($attributeSets as $attributeSet){
        echo print_r($attributeSet, 1);
    }*/

    $attributeSet = current($attributeSets);

    try{
        // delete current
        $result = $client2->catalogProductDelete($session, 'product_sku');
    }catch (Exception $e){
        // product doesn't exist
    }

    $product = array(
        'sku_type' => 1,
        'price' => '100',
        'price_type' => 1,
        'shipment_type' => 1,
        'bundle_options' => array(
            array('title' => 'Bundle Contains', 'type' => 'checkbox', 'required' => 1, 'position' => 0)
        ),
        'categories' => array(3807, 3989, 12195, 16900),
        'websites' => array(1,2,3),
        'name' => 'Product name',
        'description' => 'Product description',
        'short_description' => 'Product short description',
        'weight' => '10',
        'status' => '1',
        'url_key' => 'product-url-key',
        'url_path' => 'product-url-path',
        'visibility' => '4',
        'tax_class_id' => 2,
        'meta_title' => 'Product meta title',
        'meta_keyword' => 'Product meta keyword',
        'meta_description' => 'Product meta description'
    );

    // create again
    $productId = $client2->catalogProductCreate($session, 'bundle', $attributeSet->set_id, 'product_sku', $product);
    $product['id'] = $productId;

    if(is_int($productId)){
        $items[] = array(
            'title'     => 'test title',
            'option_id' => '',
            'delete'    => '',
            'type'      => 'checkbox',
            'required'  => 1,
            'position'  => 0
        );

        $selectionRawData[] = array('selection_id' => '','option_id' => '','product_id' => '13898','delete' => '','selection_price_value' => '0','selection_price_type' => 0,'selection_qty' => 1,'selection_can_change_qty' => 0,'position' => 0,'is_default' => 1);
        $selectionRawData[] = array('selection_id' => '','option_id' => '','product_id' => '15834','delete' => '','selection_price_value' => '0','selection_price_type' => 0,'selection_qty' => 1,'selection_can_change_qty' => 0,'position' => 0,'is_default' => 1);
        $selectionRawData[] = array('selection_id' => '','option_id' => '','product_id' => '15840','delete' => '','selection_price_value' => '0','selection_price_type' => 0,'selection_qty' => 1,'selection_can_change_qty' => 0,'position' => 0,'is_default' => 1);
        $selectionRawData[] = array('selection_id' => '','option_id' => '','product_id' => '16275','delete' => '','selection_price_value' => '0','selection_price_type' => 0,'selection_qty' => 1,'selection_can_change_qty' => 0,'position' => 0,'is_default' => 1);
        $selectionRawData[] = array('selection_id' => '','option_id' => '','product_id' => '16700','delete' => '','selection_price_value' => '0','selection_price_type' => 0,'selection_qty' => 1,'selection_can_change_qty' => 0,'position' => 0,'is_default' => 1);

		// works fine this way
        $result = $client->call($session, 'bundleapi_selection.create', array($items, $selectionRawData, $product, 0));
        var_dump($result);

		// doesn't work for some reason.
        $result = $client2->bundleapiSelectionCreate($session, $items, $selectionRawData, $product, 0);
        var_dump($result);
    }
} catch (Exception $e){
    echo $e->__toString();
}

echo "\n\n";