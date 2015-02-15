<?PHP
/**
 * 获取管理证书
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/jj154131.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $thumbprint = 'F4ADC22C88D65C9FE93206E51D63DE360C6F12F8';
    $result = $serviceManagementRestProxy->getManagementCertificates($thumbprint);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
