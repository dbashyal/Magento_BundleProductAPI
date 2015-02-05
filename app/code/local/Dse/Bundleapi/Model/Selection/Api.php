<?php
class Dse_Bundleapi_Model_Selection_Api extends Mage_Catalog_Model_Api_Resource
{
    /**/
    public function create($items = array(), $selectionRawData = array(), $productId = 0, $storeid = null)
    {
        // convert stdClass Object to Array.
        $items = json_decode(json_encode($items), true);
        $selectionRawData = json_decode(json_encode($selectionRawData), true);

        $selections = array();

        //check if product id in selection data is valid
        foreach($selectionRawData as $selection){
            $optionProduct = Mage::getModel('catalog/product')->load($selection['product_id']);
            if(!$optionProduct->getId()){
                throw new Exception('Selection product provided does not reference a valid product');
            }
        }

        $selections[] = $selectionRawData;

        $product   = Mage::getModel('catalog/product')->setStoreId($storeid);
        $product->load($productId);

        if (!$product->getId()) {
            //bail
            throw new Exception('Product loaded does not exist');
        }

        $product->setSkuType(1);
        $product->setPriceType(1);
        $product->setShipmentType(1);

        Mage::register('product', $product);
        Mage::register('current_product', $product);

        $product->setCanSaveConfigurableAttributes(false);
        $product->setCanSaveCustomOptions(true);
        $product->setBundleOptionsData($items);
        $product->setBundleSelectionsData($selections);
        $product->setCanSaveCustomOptions(true);
        $product->setCanSaveBundleSelections(true);

        $product->save();

        return $product->getId();
    }
}
