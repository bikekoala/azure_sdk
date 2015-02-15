<?php

/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * PHP version 5
 */

namespace WindowsAzure\ServiceManagement\Models;
use WindowsAzure\Common\Internal\Validate;
use WindowsAzure\Common\Internal\Resources;
use WindowsAzure\Common\Internal\Utilities;

/**
 * The optional parameters for addRole API.
 *
 * @see http://msdn.microsoft.com/zh-cn/library/azure/jj157186.aspx
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-20
 */
class AddRoleOptions
{
    /**
     * @var string
     */
    private $_roleName;

    /**
     * @var string
     */
    private $_roleType = 'PersistentVMRole';

    /**
     * @var string
     */
    private $_roleSize;

    /**
     * @var string
     */
    private $_osvhdMediaLink;

    /**
     * @var string
     */
    private $_osvhdSourceImageName;

    /**
     * @var string
     */
    private $_dvhdDiskLabel;

    /**
     * @var int
     */
    private $_dvhdLogicalDiskSizeInGB;

    /**
     * @var string
     */
    private $_dvhdMediaLink;

    /**
     * @var string
     */
    private $_csConfigurationSetType;

    /**
     * @var string
     */
    private $_csLinuxHostName;

    /**
     * @var string
     */
    private $_csLinuxUserName;

    /**
     * @var string
     */
    private $_csLinuxUserPassword;

    /**
     * @var string
     */
    private $_csWindowsComputerName;

    /**
     * @var string
     */
    private $_csWindowsAdminUsername;

    /**
     * @var string
     */
    private $_csWindowsAdminPassword;

    /**
     * @var string
     */
    private $_csWindowsEnableAutomaticUpdates = 'true';

    /**
     * @var string
     */
    private $_csNetworkEndpointName;

    /**
     * @var string
     */
    private $_csNetworkEndpointProtocol;

    /**
     * @var string
     */
    private $_csNetworkEndpointPort;
    
    /**
     * @var string
     */
    private $_csNetworkEndpointLocalPort;

    /**
     * @var bool
     */
    private $_csLinuxDisableSshPasswordAuthentication = 'false';

    /**
     * @var array
     */
    private $_csNetworkEndpointList = array();

    /**
     * @var array
     */
    private $_csSubnetNames;

    /**
     * @var string
     */
    private $_csStaticVirtualNetworkIPAddress;

    /**
     * @var bool
     */
    private $_provisionGuestAgent = 'false';

    const CS_TYPE_WINDOWS_PROVISIONING = 'WindowsProvisioningConfiguration';
    const CS_TYPE_LINUX_PROVISIONING   = 'LinuxProvisioningConfiguration';
    const CS_TYPE_NETWORK              = 'NetworkConfiguration';

    const STATUS_TRUE                  = 'true';
    const STATUS_FALSE                 = 'false';

    const NETWORK_PROTOCOL_TCP         = 'TCP';
    const NETWORK_PROTOCOL_UDP         = 'UDP';

    /**
     * Required if StaticVirtualNetworkIPAddress is specified;
     * otherwise, optional in NetworkConfiguration.
     * Contains a list of subnets to which the Virtual Machine will belong.
     *
     * @param mixed $names
     * @return void
     */
    public function setCsSubnetNames($names)
    {
        Validate::notNullOrEmpty($names, 'SubnetName');

        $this->_csSubnetNames = $names;
    }

    /**
     * Specifies the internal IP address for the Virtual Machine in a Virtual
     * Network. If you specify this element, you must also specify the
     * SubnetNames element with only one subnet defined. The IP address
     * specified in this element must belong to the subnet that is defined in
     * SubnetNames and it should not be the one of the first four IP addresses
     * or the last IP address in the subnet.
     *
     * @param string $ip
     * @return void
     */
    public function setCsStaticVirtualNetworkIPAddress($ip)
    {
        Validate::isString($ip, 'StaticVirtualNetworkIPAddress');
        Validate::notNullOrEmpty($ip, 'StaticVirtualNetworkIPAddress');

        $this->_csStaticVirtualNetworkIPAddress = $ip;
    }

    /**
     * Specifies the name of the external endpoint.
     *
     * @param string $name
     * @return void
     */
    public function setCsNetworkEndpointName($name)
    {
        Validate::isString($name, 'Name');
        Validate::notNullOrEmpty($name, 'Name');

        $this->_csNetworkEndpointName = $name;
    }

    /**
     * Specifies the transport protocol for the endpoint.
     *
     * @param string $porotocol
     * @return void
     */
    public function setCsNetworkEndpointProtocol($porotocol)
    {
        Validate::isString($porotocol, 'Porotocol');
        Validate::notNullOrEmpty($porotocol, 'Porotocol');

        $this->_csNetworkEndpointProtocol = $porotocol;
    }

    /**
     * Specifies the external port to use for the endpoint.
     *
     * @param int $port
     * @return void
     */
    public function setCsNetworkEndpointPort($port)
    {
        Validate::isInteger($port, 'Port');

        $this->_csNetworkEndpointPort = $port;
    }

    /**
     * Specifies the internal port on which the Virtual Machine is listening.
     *
     * @param int $port
     * @return void
     */
    public function setCsNetworkEndpointLocalPort($port)
    {
        Validate::isInteger($port, 'LocalPort');

        $this->_csNetworkEndpointLocalPort = $port;
    }

    /**
     * 设置网络配置集数组
     *
     * @param array $endpointList
     * @return void
     */
    public function setCsNetworkEndpointList($endpointList)
    {
        Validate::notNullOrEmpty($endpointList, 'endpointList');

        $this->_csNetworkEndpointList = $endpointList;
    }

    /**
     * 返回iuwangl配置集数组
     *
     * @return array
     */
    public function getCsNetworkEndpointList()
    {
        return $this->_csNetworkEndpointList;
    }

    /**
     * Indicates whether the VM Agent is installed on the Virtual Machine.
     * To run a resource extension in a Virtual Machine, this service must
     * be installed.
     *
     * @param bool $status
     * @return void
     */
    public function setProvisionGuestAgent($status)
    {
        Validate::isString($status, 'ProvisionGuestAgent');
        Validate::notNullOrEmpty($status, 'ProvisionGuestAgent');

        $this->_provisionGuestAgent = $status;
    }

    /**
     * Sets the media link for OSVirtualHardDisk
     *
     * Required if the Virtual Machine is being created from a platform image.
     * Specifies the location of the VHD file that is created when
     * SourceImageName specifies a platform image. This element is not used if
     * the Virtual Machine is being created using an existing disk.
     *
     * @param string $link
     * @return void
     */
    public function setOsvhdMediaLink($link)
    {
        Validate::isString($link, 'OSVirtualHardDisk_MediaLink');
        Validate::notNullOrEmpty($link, 'OSVirtualHardDisk_MediaLink');

        $this->_osvhdMediaLink = $link;
    }

    /**
     * Sets the source iamge name for OSVirtualHardDisk
     *
     * Optional. Specifies the name of the image to use to create the Virtual
     * Machine. You can specify a user image or a platform image. An image is
     * always associated with a VHD, which is a .vhd file stored as a page blob
     * in a storage account in Azure. If you specify a platform image, an
     * associated VHD is created and you must use the MediaLink element to
     * specify the location in storage where the VHD will be located.
     *
     * @param string $name
     * @return void
     */
    public function setOsvhdSourceImageName($name)
    {
        Validate::isString($name, 'OSVirtualHardDisk_SourceImageName');
        Validate::notNullOrEmpty($name, 'OSVirtualHardDisk_SourceImageName');

        $this->_osvhdSourceImageName = $name;
    }

    /**
     * Sets the disk label for DataVirtualHardDisk
     *
     * Optional. If the disk that is being added is already registered
     * in the subscription, this element is ignored. If a new disk is
     * being created, this element is used to provide a description of
     * the disk. The value of this element is only obtained programmatically
     * and does not appear in the Management Portal.
     *
     * @param string $label
     * @return void
     */
    public function setDvhdDiskLabel($label)
    {
        Validate::isString($label, 'DiskLabel');
        Validate::notNullOrEmpty($label, 'DiskLabel');

        $this->_dvhdDiskLabel = $label;
    }

    /**
     * Sets the logical disk size in GB for DataVirtualHardDisk
     *
     * Optional. Specifies the size, in GB, of an empty disk to be attached
     * to the Virtual Machine. If the disk that is being added is already
     * registered in the subscription, this element is ignored. If the disk
     * and VHD is being created by Azure as it is added, this element defines
     * the size of the new disk.
     *
     * The number of disks that can be added to a Virtual Machine is limited
     * by the size of the machine. For more information, see Virtual Machine
     * and Cloud Service Sizes for Azure.
     *
     * This element is used with the MediaLink element.
     *
     * @param int $size
     * @return void
     */
    public function setDvhdLogicalDiskSizeInGB($size)
    {
        Validate::isInteger($size, 'LogicalDiskSizeInGB');

        $this->_dvhdLogicalDiskSizeInGB = $size;
    }

    /**
     * Sets the media link for DataVirtualHardDisk
     *
     * Required if the Virtual Machine is being created from a platform image.
     * Specifies the location of the VHD file that is created when
     * SourceImageName specifies a platform image. This element is not used if
     * the Virtual Machine is being created using an existing disk.
     *
     * @param string $link
     * @return void
     */
    public function setDvhdMediaLink($link)
    {
        Validate::isString($link, 'DataVirtualHardDisk_MediaLink');
        Validate::notNullOrEmpty($link, 'DataVirtualHardDisk_MediaLink');

        $this->_dvhdMediaLink = $link;
    }

    /**
     * Specifies the computer name for the Virtual Machine. If you do not
     * specify a computer name, one is assigned that is a combination of the
     * deployment name, role name, and identifying number. Computer names must
     * be 1 to 15 characters long.
     *
     * @param string $computerName
     * @return void
     */
    public function setCsWindowsComputerName($computerName)
    {
        Validate::isString($computerName, 'ComputerName');
        Validate::notNullOrEmpty($computerName, 'ComputerName');

        $this->_csWindowsComputerName = $computerName;
    }

    /**
     * Specifies the name of the administrator account that is created
     * to access the Virtual Machine.
     *
     * @param string $username
     * @return void
     */
    public function setCsWindowsAdminUsername($username)
    {
        Validate::isString($username, 'AdminUsername');
        Validate::notNullOrEmpty($username, 'AmindUsername');

        $this->_csWindowsAdminUsername = $username;
    }

    /**
     * Specifies the password to use for an administrator account on
     * the Virtual Machine that is being created.
     *
     * @param string $password
     * @return void
     */
    public function setCsWindowsAdminPassword($password)
    {
        Validate::isString($password, 'AdminPassword');
        Validate::notNullOrEmpty($password, 'AdminPassword');

        $this->_csWindowsAdminPassword = $password;
    }

    /**
     * Specifies whether automatic updates are enabled for the Virtual Machine.
     * Updates occur at a random time between 3:00 AM and 5:00 AM.
     *
     * @param string $status
     * @return void
     */
    public function setCsWindowsEnableAutomaticUpdates($status)
    {
        Validate::isString($status, 'EnableAutomaticUpdates');
        Validate::notNullOrEmpty($status, 'EnableAutomaticUpdates');

        $this->_csWindowsEnableAutomaticUpdates = $status;
    }

    /**
     * Sets the Configuration sets host name for linux
     *
     * Required in LinuxProvisioningConfiguration.
     * Specifies the host name for the Virtual Machine. 
     * Host names must be 1 to 64 characters long.
     *
     * @param string $hostName
     * @return void
     */
    public function setCsLinuxHostName($hostName)
    {
        Validate::isString($hostName, 'ConfigurationSets_HostName');
        Validate::notNullOrEmpty($hostName, 'ConfigurationSets_HostName');

        $this->_csLinuxHostName = $hostName;
    }

    /**
     * Sets the Configuration sets user name for linux
     *
     * Required in LinuxProvisioningConfiguration.
     * Specifies the name of a user account to be created
     * in the sudoer group of the Virtual Machine. User account names
     * must be 1 to 32 characters long.
     *
     * @param string $userName
     * @return void
     */
    public function setCsLinuxUserName($userName)
    {
        Validate::isString($userName, 'ConfigurationSets_UserName');
        Validate::notNullOrEmpty($userName, 'ConfigurationSets_UserName');

        $this->_csLinuxUserName = $userName;
    }

    /**
     * Sets the Configuration sets user password for linux
     *
     * Required in LinuxProvisioningConfiguration.
     * Specifies the password for the user account.
     * Passwords must be 6 to 72 characters long.
     *
     * @param string $password
     * @return void
     */
    public function setCsLinuxUserPassword($password)
    {
        Validate::isString($password, 'ConfigurationSets_UserPassword');
        Validate::notNullOrEmpty($password, 'ConfigurationSets_UserPassword');

        $this->_csLinuxUserPassword = $password;
    }

    /**
     * Sets the Configuration sets Disable SSH password authentication
     *
     * Optional in LinuxProvisioningConfiguration.
     * Specifies whether SSH password authentication is disabled.
     * By default this value is set to true.
     *
     * @param bool $status
     * @return void
     */
    public function setCsLinuxDisableSshPasswordAuthentication($status)
    {
        Validate::isString($status, 'DisableSshPasswordAuthentication');
        Validate::notNullOrEmpty($status, 'DisableSshPasswordAuthentication');

        $this->_csLinuxDisableSshPasswordAuthentication = $status;
    }

    /**
     * Sets the configuration set type
     *
     * Required.
     *
     * @param string $type
     * @return void
     */
    public function setCsConfigurationSetType($type)
    {
        Validate::isString($type, 'ConfigurationSetType');
        Validate::notNullOrEmpty($type, 'ConfigurationSetType');

        $this->_csConfigurationSetType = $type;
    }

    /**
     * Sets the role size
     *
     * Optional. Specifies the size of the Virtual Machine.
     * The default size is Small. For more information about
     * Virtual Machine sizes, see Virtual Machine and
     * Cloud Service Sizes for Azure.
     *
     * @param string $roleSize
     * @return void
     */
    public function setRoleSize($roleSize)
    {
        Validate::isString($roleSize, 'RoleSize');
        Validate::notNullOrEmpty($roleSize, 'RoleSize');

        $this->_roleSize = $roleSize;
    }

    /**
     * Sets the role type
     *
     * Required. Specifies the type of role to use. For Virtual Machines,
     * this must be PersistentVMRole.
     *
     * @param string $roleType
     * @return void
     */
    public function setRoleType($roleType)
    {
        Validate::isString($roleType, 'RoleType');
        Validate::notNullOrEmpty($roleType, 'RoleType');

        $this->_roleType = $roleType;
    }

    /**
     * Sets the role name
     *
     * Required. Specifies the name for the Virtual Machine.
     *
     * @param string $roleName
     * @return void
     */
    public function setRoleName($roleName)
    {
        Validate::isString($roleName, 'RoleName');
        Validate::notNullOrEmpty($roleName, 'RoleName');

        $this->_roleName = $roleName;
    }

    /**
     * Convert elements to XML array
     *
     * @return array
     */
    public function toXmlArrayForNetworkEndpoint()
    {
        $arr = array(
            Resources::XTAG_INPUT_ENDPOINT => array(
                Resources::XTAG_LOCAL_PORT  => $this->_csNetworkEndpointLocalPort,
                Resources::XTAG_NAME        => $this->_csNetworkEndpointName,
                Resources::XTAG_PROTOCOL    => $this->_csNetworkEndpointProtocol,
            )
        );
        Utilities::addIfNotEmpty(
            Resources::XTAG_PORT,
            $this->_csNetworkEndpointPort,
            $arr
        );

        return $arr;
    }

    /**
     * Convert elements to XML array
     *
     * @param array $networkEndpointXmlElements
     * @param bool $needDeployment
     * @return array
     */
    public function toXmlArray(
        $networkEndpointXmlElements = array(),
        $needDeployment = false
    ) {
        $linuxProvisioningConfiguration =
        $windowsProvisioningConfiguration =
        $networkConfiguration = array();

        if (static::CS_TYPE_LINUX_PROVISIONING ===
            $this->_csConfigurationSetType) {
            $linuxProvisioningConfiguration = array(
                Resources::XTAG_CONFIGURATION_SET => array(
                    Resources::XTAG_ATTRIBUTES => array(
                            Resources::XTAG_ATTRIBUTE_I_TYPE =>
                                $this->_csConfigurationSetType . 'Set'
                    ),
                    Resources::XTAG_CONFIGURATION_SET_TYPE =>
                        $this->_csConfigurationSetType,
                    Resources::XTAG_HOST_NAME => $this->_csLinuxHostName,
                    Resources::XTAG_USER_NAME => $this->_csLinuxUserName,
                    Resources::XTAG_USER_PASSWORD => $this->_csLinuxUserPassword,
                    Resources::XTAG_DISABLE_SSH_PASSWORD_AUTHENTICATION =>
                        $this->_csLinuxDisableSshPasswordAuthentication,
                ),
            );
        }

        if (static::CS_TYPE_WINDOWS_PROVISIONING ===
            $this->_csConfigurationSetType) {
            $windowsProvisioningConfiguration = array(
                Resources::XTAG_CONFIGURATION_SET => array(
                    Resources::XTAG_ATTRIBUTES => array(
                            Resources::XTAG_ATTRIBUTE_I_TYPE =>
                                $this->_csConfigurationSetType . 'Set'
                    ),
                    Resources::XTAG_CONFIGURATION_SET_TYPE =>
                        $this->_csConfigurationSetType,
                    Resources::XTAG_COMPUTER_NAME => $this->_csWindowsComputerName,
                    Resources::XTAG_ADMIN_PASSWORD => $this->_csWindowsAdminPassword,
                    Resources::XTAG_ADMIN_USERNAME => $this->_csWindowsAdminUsername,
                    Resources::XTAG_ENABLE_AUTOMATIC_UPDATES => $this->_csWindowsEnableAutomaticUpdates,
                ),
            );
        }

        if ( ! empty($networkEndpointXmlElements)) {
            $arr = array(
                Resources::XTAG_CONFIGURATION_SET_TYPE => static::CS_TYPE_NETWORK,
                Resources::XTAG_INPUT_ENDPOINTS => $networkEndpointXmlElements
            );
            if ( ! empty($this->_csSubnetNames &&
                 ! empty($this->_csStaticVirtualNetworkIPAddress))) {
                 $subnetNames = array();
                 foreach ($this->_csSubnetNames as $i => $subnetName) {
                     $subnetNames[$i][Resources::XTAG_SUBNET_NAME] = $subnetName;
                 }
                 $arr[Resources::XTAG_SUBNET_NAMES] = $subnetNames;
                 $arr[Resources::XTAG_STATIC_VIRTUAL_NETWORK_IP_ADDRESS] =
                    $this->_csStaticVirtualNetworkIPAddress;
            }

            $networkConfiguration[Resources::XTAG_CONFIGURATION_SET] = $arr;
        }

        $role =  array(
            Resources::XTAG_ROLE_NAME => $this->_roleName,
            Resources::XTAG_ROLE_TYPE => $this->_roleType,
            Resources::XTAG_CONFIGURATION_SETS => array(
                $linuxProvisioningConfiguration,
                $windowsProvisioningConfiguration,
                $networkConfiguration
            ),
            Resources::XTAG_DATA_VIRTUAL_HARD_DISKS => array(
                Resources::XTAG_DATA_VIRTUAL_HARD_DISK => array(
                    Resources::XTAG_DISK_LABEL => $this->_dvhdDiskLabel,
                    Resources::XTAG_LOGICAL_DISK_SIZE_IN_GB =>
                        $this->_dvhdLogicalDiskSizeInGB,
                    Resources::XTAG_MEDIA_LINK => $this->_dvhdMediaLink,
                )
            ),
            Resources::XTAG_OS_VIRTUAL_HARD_DISK => array(
                Resources::XTAG_MEDIA_LINK => $this->_osvhdMediaLink,
                Resources::XTAG_SOURCE_IMAGE_NAME =>
                    $this->_osvhdSourceImageName,
            ),
            Resources::XTAG_ROLE_SIZE => $this->_roleSize,
            Resources::XTAG_PROVISION_GUEST_AGENT => $this->_provisionGuestAgent
        );

        if ($needDeployment) {
            return array(
                Resources::XTAG_ROLE => $role
            );
        } else {
            return $role;
        }
    }
}
