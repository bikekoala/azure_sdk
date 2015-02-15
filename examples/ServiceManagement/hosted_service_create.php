<?PHP
/**
 * 创建云服务
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/gg441304.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\CreateHostedServiceOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $name = 'apitestucw';
    $label = base64_encode($name . 'popfeng');

    $serviceOptions = new CreateHostedServiceOptions();
    $serviceOptions->setLocation('China North');

    $result = $serviceManagementRestProxy->createHostedService($name, $label, $serviceOptions);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
