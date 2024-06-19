<?php
$dn = array(
"countryName" => "US",
"stateOrProvinceName" => "Connecticut",
"localityName" => "Storrs",
"organizationName" => "ConsoliBYTE, LLC",
"organizationalUnitName" => "Technical",
"commonName" => "www.xyz.com:test.www.xyz.com"
);
$privkey = openssl_pkey_new();
$csr = openssl_csr_new($dn, $privkey);
$sscert = openssl_csr_sign($csr, null, $privkey, 365);
if (openssl_csr_export($csr, $csrout)) {
    var_dump($csrout);
}

if (openssl_x509_export($sscert, $certout)) {
    var_dump($certout);
}

if (openssl_pkey_export($privkey, $pkeyout, "mypassword")) {
    var_dump($pkeyout);
}

while (($e = openssl_error_string()) !== false) {
echo $e . "\n";
}
?>
