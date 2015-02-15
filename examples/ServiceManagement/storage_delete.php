<?PHP
/**
 * 删除存储账户
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/hh264517.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\CreateServiceOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    //Service Name
    //必需。存储帐户在 Azure 中独一无二的名称。存储帐户名称的长度必须介于 3 和 24 个字符之间，且只能使用数字和小写字母。
    //该名称是 DNS 前缀名称，可用于访问存储帐户中的 blob、队列和表。
    //例如：http://ServiceName.blob.core.windows.net/mycontainer/
    $name = 'testest';
    $result = $serviceManagementRestProxy->deleteStorageAccount($name);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
