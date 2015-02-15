<?PHP
/**
 * 添加管理证书
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/jj154123.aspx
 *
 * openssl req -x509 -nodes -days 365 -newkey rsa:1024 -keyout mycert.pem -out mycert.pem
 * openssl x509 -inform pem -in mycert.pem -outform der -out mycert.cer
 *
 * openssl rsa -in mycert.pem -RSAPublicKey_out 2>/dev/null
 * openssl x509 -in mycert.pem -fingerprint -noout
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);
    /*
     *SubscriptionCertificatePublicKey  管理证书公钥的 base64 表示形式。
     SubscriptionCertificateThumbprint  唯一地标识管理证书的指纹。
     SubscriptionCertificateData        证书的原始数据，采用 Base-64 编码 .cer 格式。
     */
    $pubkeyCmdStr = 'openssl rsa -in %s -RSAPublicKey_out 2>/dev/null';
    exec(sprintf($pubkeyCmdStr, $cert_pem_path), $out);
    $publicKey = '';
    for($i=0,$n=count($out); $i<$n; $i++) {
        if (0===$i || $n-1===$i) continue;
        $publicKey .= $out[$i];
    }

    $fingerpringCmdStr = 'openssl x509 -in %s -fingerprint -noout';
    $out = exec(sprintf($fingerpringCmdStr, $cert_pem_path));
    $thumbprint = str_replace(':', '', substr($out, strpos($out, '=') + 1));

    $cerData = base64_encode(file_get_contents($cert_cer_path));

    $result = $serviceManagementRestProxy->addManagementCertificates($publicKey, $thumbprint, $cerData);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
