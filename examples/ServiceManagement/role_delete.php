<?PHP
/**
 * 删除虚拟机角色
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/jj157184.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);
    $cloudServiceName = 'ucw-test';
    $deploymentName = 'ucw-test';
    $roleName = 'ucw-test';
    $isDeleteMedia = true;
    $result = $serviceManagementRestProxy->deleteRole($cloudServiceName, $deploymentName, $roleName, $isDeleteMedia);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
