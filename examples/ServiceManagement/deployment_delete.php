<?PHP
/**
 * 删除部署
 * 部署中最后一台Role时可删除Role、Storage、blob、deployment
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/ee460815.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\DeleteDeploymentOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);


    $cloudServiceName = 'ucw-test';
    $isDeleteMedia = true;
    $serviceOptions = new DeleteDeploymentOptions();
    $serviceOptions->setDeploymentName('ucw-test');

    $result = $serviceManagementRestProxy->deleteDeployment(
        $cloudServiceName,
        $isDeleteMedia,
        $serviceOptions
    );
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
