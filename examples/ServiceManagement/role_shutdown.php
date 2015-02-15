<?PHP
/**
 * 关闭虚拟机角色
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/jj157195.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\OperateRoleOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $cloudServiceName = 'ucw-test';
    $deploymentName = 'ucw-test';
    $roleName = 'ucw-test';

    $options = new OperateRoleOptions();
    /*
     * Stopped              闭虚拟机，但保留计算资源。
     *                      你将继续对已停止虚拟机使用的资源付费。
     *
     * StoppedDeallocated   闭虚拟机并释放计算资源。
     *                      你不再对此虚拟机使用的计算资源付费。
     *                      如果将静态虚拟网络 IP 地址分配给虚拟机，则保留。
     *                      有关详细信息，请参阅 获取角色 中的StaticVirtualNetworkIPAddress
     *
     * 如果未指定此元素，则默认操作为Stopped。
     */
    $options->setPostShutdownAction('StoppedDeallocated');
    $result = $serviceManagementRestProxy->shutdownRole($cloudServiceName, $deploymentName, $roleName, $options);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
