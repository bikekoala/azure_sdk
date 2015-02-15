<?PHP
/**
 * 获取异步请求操作状态
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/ee460783.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\AsynchronousOperationResult;

$requestId = isset($argv[1]) ? $argv[1] : '';
if('' === $requestId) {
    exit("Invalid request id.\n");
}
try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $result = $serviceManagementRestProxy->getOperationStatus($requestId);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
