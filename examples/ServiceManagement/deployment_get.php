<?PHP
/**
 * 获取部署
 *
 * http://msdn.microsoft.com/library/azure/ee460804.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\GetDeploymentOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);


    $cloudServiceName = 'ucw-test';
    $result = $serviceManagementRestProxy->getDeployment($cloudServiceName);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
