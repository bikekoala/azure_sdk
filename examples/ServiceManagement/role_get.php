<?PHP
/**
 * 获取虚拟机角色
 *
 * https://msdn.microsoft.com/zh-cn/library/azure/jj157193.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);
    $cloudServiceName = 'ucw-test';
    $deploymentName = 'ucw-test';
    $roleName = 'ucw-test';

    $result = $serviceManagementRestProxy->getRole($cloudServiceName, $deploymentName, $roleName);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
