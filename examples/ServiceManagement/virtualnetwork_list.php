<?PHP
/**
 * 列出虚拟网络站点
 *
 * http://msdn.microsoft.com/library/azure/jj157185.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);


    $sites = $serviceManagementRestProxy->listVirtualNetworkSites();
    print_r($sites);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
