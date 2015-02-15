<?PHP
/**
 * 设置网络配置
 *
 * http://msdn.microsoft.com/library/azure/jj157181.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\SetNetworkConfigurationOptions;

try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    $subnet[1] = new SetNetworkConfigurationOptions();
    $subnet[1]->setVnsSubnetName('Subnet-1');
    $subnet[1]->setVnsSubnetAddressPrefix('10.0.0.0/11');

    $vns[1] = new SetNetworkConfigurationOptions();
    $vns[1]->setVnsName('ucw-vn-chinanorth');
    $vns[1]->setVnsLocation('China North');
    $vns[1]->setVnsAdressSpaceAddressPrefix('10.0.0.0/8');
    $vns[1]->setVnsSubnetList($subnet);

    $subnet[1] = new SetNetworkConfigurationOptions();
    $subnet[1]->setVnsSubnetName('Subnet-1');
    $subnet[1]->setVnsSubnetAddressPrefix('10.0.0.0/11');
    $subnet[2] = new SetNetworkConfigurationOptions();
    $subnet[2]->setVnsSubnetName('Subnet-2');
    $subnet[2]->setVnsSubnetAddressPrefix('10.32.0.0/11');

    $vns[2] = new SetNetworkConfigurationOptions();
    $vns[2]->setVnsName('ucw-vn-chinaeast');
    $vns[2]->setVnsLocation('China East');
    $vns[2]->setVnsAdressSpaceAddressPrefix('10.0.0.0/8');
    $vns[2]->setVnsSubnetList($subnet);

    $header = $serviceManagementRestProxy->setNetworkConfiguration($vns);
    print_r($header);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
