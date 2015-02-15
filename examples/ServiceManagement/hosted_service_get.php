<?PHP
/**
 * 获取云服务属性
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/ee460806.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\GetHostedServicePropertiesOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $name = 'shenlc';
    $serviceOptions = new GetHostedServicePropertiesOptions();
    $serviceOptions->setEmbedDetail(true);
    $result = $serviceManagementRestProxy->getHostedServiceProperties($name, $serviceOptions);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
