<?PHP
/**
 * 创建虚拟机部署
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/jj157194.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\ServiceManagement\Models\AddRoleOptions;
use WindowsAzure\ServiceManagement\Models\CreateDeploymentByRolesOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $roleOptions = new AddRoleOptions();
    $roleOptions->setRoleName('apitestucw');
    $roleOptions->setRoleSize('Small');
    $roleOptions->setProvisionGuestAgent($roleOptions::STATUS_TRUE);

    $roleOptions->setOsvhdMediaLink('https://apitestucw.blob.core.chinacloudapi.cn/vhds/apitestucwos.vhd');
    $roleOptions->setOsvhdSourceImageName('b549f4301d0b4295b8e76ceb65df47d4__Ubuntu-12_04_4-LTS-amd64-server-20140529-en-us-30GB');
    $roleOptions->setDvhdDiskLabel(base64_encode('apitestucw-disk'));
    $roleOptions->setDvhdLogicalDiskSizeInGB(1023);
    $roleOptions->setDvhdMediaLink('https://apitestucw.blob.core.chinacloudapi.cn/vhds/apitestucwdata.vhd');

    /*
    $roleOptions->setCsConfigurationSetType($roleOptions::CS_TYPE_LINUX_PROVISIONING);
    $roleOptions->setCsLinuxHostName('api-ucw-test');
    $roleOptions->setCsLinuxUserName('popfeng');
    $roleOptions->setCsLinuxUserPassword('popfeng@ucw.COM');
     */

    $roleOptions->setCsConfigurationSetType($role::CS_TYPE_WINDOWS_PROVISIONING);
    $roleOptions->setCsWindowsComputerName('api-ucw-test');
    $roleOptions->setCsWindowsAdminUsername('popfeng');
    $roleOptions->setCsWindowsAdminPassword('popfeng@ucw.COM');

    $endpointOptionsList[1] = new AddRoleOptions();
    $endpointOptionsList[1]->setCsNetworkEndpointName('SSH');
    $endpointOptionsList[1]->setCsNetworkEndpointProtocol($endpointOptionsList[1]::NETWORK_PROTOCOL_TCP);
    $endpointOptionsList[1]->setCsNetworkEndpointPort(22);
    $endpointOptionsList[1]->setCsNetworkEndpointLocalPort(22);
    $endpointOptionsList[2] = new AddRoleOptions();
    $endpointOptionsList[2]->setCsNetworkEndpointName('FTP');
    $endpointOptionsList[2]->setCsNetworkEndpointProtocol($endpointOptionsList[1]::NETWORK_PROTOCOL_TCP);
    $endpointOptionsList[2]->setCsNetworkEndpointPort(21);
    $endpointOptionsList[2]->setCsNetworkEndpointLocalPort(21);
    $roleOptions->setCsNetworkEndpointList($endpointOptionsList);

    $roleOptionsList = array();
    $roleOptionsList[] = $roleOptions;

    $cloudServiceName = 'apitestucw';
    $deploymentOptions = new CreateDeploymentByRolesOptions();
    $deploymentOptions->setName('apitestucw');
    $deploymentOptions->setLabel('apitestucw01-popfeng');
    $deploymentOptions->setVirtualNetworkName('ucw-vn-chinanorth');

    $result = $serviceManagementRestProxy->createDeploymentByRoles(
        $cloudServiceName,
        $roleOptionsList,
        $deploymentOptions
    );
    print_r($result);
} catch (\Exception $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage(), PHP_EOL;
}
