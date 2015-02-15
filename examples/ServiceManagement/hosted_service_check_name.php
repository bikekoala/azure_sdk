<?PHP
/**
 * 检查云服务名称可用性
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/jj154116.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $cloudServiceName = 'apitestucw';
    $result = $serviceManagementRestProxy->checkHostedServicesName($cloudServiceName);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
