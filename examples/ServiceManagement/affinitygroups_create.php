<?PHP
/**
 * 创建地缘组
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/gg715317.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $name = 'apitestucw';
    $label = base64_encode($name . 'popfeng');
    $location = 'China East';
    $header = $serviceManagementRestProxy->createAffinityGroup($name, $label, $location);
    print_r($header);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
