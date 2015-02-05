# Magento Bundle Product API

[![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=dbashyal&url=https://github.com/dbashyal&title=Github Repos&language=&tags=github&category=software)

@see: [createBundleProduct.php] (createBundleProduct.php)

// API version 1 method

```$result = $client->call($session, 'bundleapi_selection.create', array($items, $selectionRawData, $productId, 0));```

// API version 2 method
```$result = $client2->bundleapiSelectionCreate($session, $items, $selectionRawData, $productId, 0);```

###Issues
After modification of wsdl.xml I need to restart my Ubuntu. Tried `sudo rm -rf /tmp/*` but didn't help.

Pull requests with fixes would be appreciated. :)

Thank You.
@dbashyal