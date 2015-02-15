<?PHP
/**
 * 列出位置
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/gg441293.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

// API: listLocations
try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);
    $result = $serviceManagementRestProxy->listLocations();
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
