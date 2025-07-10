<?php
    //  Create the Xml to POST to the Webservice
    $Xml_to_Send = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
    $Xml_to_Send .= "<Volusion_API>";
    $Xml_to_Send .= "<!--";
    $Xml_to_Send .= 
    " 
<Products>
<ProductCode>E-TEST101</ProductCode>
<ListPrice>69.0000</ListPrice>
<ProductPrice>45.7500</ProductPrice>
</Products>
    ";
    $Xml_to_Send .= "-->";
    $Xml_to_Send .= "</Volusion_API>";

    //  Create the Header
    $url = "https://shop.factory-express.com/net/WebService.aspx?Login=trentt@factory-express.com &EncryptedPassword=E1345A309A8F48C0D784D9BEE58E483B176D87222017B445F56E2A8B3DFC4950EncryptedPassword=E1345A309A8F48C0D784D9BEE58E483B176D87222017B445F56E2A8B3DFC4950Import=Insert";
    $header  = "POST".$url." HTTP/1.0 \r\n";
    $header .= "MIME-Version: 1.0 \r\n";
    $header .= "Content-type: text/xml; charset=utf-8 \r\n";
    $header .= "Content-length: ".strlen($post_string)." \r\n";
    $header .= "Content-transfer-encoding: text \r\n";
    $header .= "Request-number: 1 \r\n";
    $header .= "Document-type: Request \r\n";
    $header .= "Interface-Version: Test 1.4 \r\n";
    $header .= "Connection: close \r\n\r\n";
    $header .= $Xml_to_Send;

    //  Post and Return Xml
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $header);
    $data = curl_exec($ch);

    //  Check for Errors
    if (curl_errno($ch)){
        print curl_error($ch);
    } else {
       curl_close($ch);
    }

    //  Display the Xml Returned on the Browser
    echo $data;
?>