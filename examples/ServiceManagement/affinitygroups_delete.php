<?PHP
/**
 * 删除地缘组
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/gg715314.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $name = 'apitestucw';
    $header = $serviceManagementRestProxy->deleteAffinityGroup($name);
    print_r($header);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
