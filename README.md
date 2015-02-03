# Magento Bundle Product API

@see: createBundleProduct.php

// works fine this way
`$result = $client->call($session, 'bundleapi_selection.create', array($items, $selectionRawData, $product, 0));`

// doesn't work for some reason.
`$result = $client2->bundleapiSelectionCreate($session, $items, $selectionRawData, $product, 0);`

h3.Issues

What am I doing wrong in V2?

How can I pass multi-dimensional array in V2? Do I need to provide 'key' - 'value' for all data?

Pull requests with fixes would be appreciated. :)
