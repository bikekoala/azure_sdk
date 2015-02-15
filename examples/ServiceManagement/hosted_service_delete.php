<?PHP
/**
 * 删除云服务
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/ee460815.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $name = 'test-api';
    $result = $serviceManagementRestProxy->deleteHostedService($name);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
