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

/**
 * The optional parameters.
 *
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-19
 */
class SetNetworkConfigurationOptions
{
    /**
     * @var string
     */
    private $_vnsName;

    /**
     * @var string
     */
    private $_vnsLocation;

    /**
     * @var string
     */
    private $_vnsAddressSpaceAddressPrefix;

    /**
     * @var string
     */
    private $_vnsSubnetName;

    /**
     * @var string
     */
    private $_vnsSubnetAddressPrefix;

    /**
     * @var array
     */
    private $_vnsSubnetList = array();

    /**
     * Sets the value of the name attribute for VirtualNetworkSite element.
     * 
     * @param string $name
     * @return void
     */
    public function setVnsName($name)
    {
        Validate::isString($name, 'name');

        $this->_vnsName = $name;
    }

    /**
     * Sets the value of the Location attribute for VirtualNetworkSite
     * element.
     *
     * @param string $location
     * @return void
     */
    public function setVnsLocation($location)
    {
        Validate::isString($location, 'location');

        $this->_vnsLocation = $location;
    }

    /**
     * Sets the CIDR address space that is used for virtual network sites.
     * e.g. 198.51.100.0/22
     *
     * @param string $addressPrefix
     * @return void
     */
    public function setVnsAdressSpaceAddressPrefix($addressPrefix)
    {
        Validate::isString($addressPrefix, 'AddressPrefix');

        $this->_vnsAddressSpaceAddressPrefix = $addressPrefix;
    }

    /**
     * Sets the value of the name attribute for Subnet element.
     * 
     * @param string $name
     * @return void
     */
    public function setVnsSubnetName($name)
    {
        Validate::isString($name, 'name');

        $this->_vnsSubnetName = $name;
    }

    /**
     * Sets the CIDR address space that is used for subnets of the virtual network sites.
     * e.g. 198.51.100.0/22
     *
     * @param string $addressPrefix
     * @return void
     */
    public function setVnsSubnetAddressPrefix($addressPrefix)
    {
        Validate::isString($addressPrefix, 'AddressPrefix');

        $this->_vnsSubnetAddressPrefix = $addressPrefix;
    }

    /**
     * Sets the list of subnet elements
     *
     * @param array $subnetList
     * @return void
     */
    public function setVnsSubnetList($subnetList)
    {
        Validate::notNullOrEmpty($subnetList, 'subnetList');

        $this->_vnsSubnetList = $subnetList;
    }

    /**
     * Gets the list of subnet elements
     *
     * @return array
     */
    public function getVnsSubnetList()
    {
        return $this->_vnsSubnetList;
    }

    /**
     * Convert elements to XML array
     *
     * @return void
     */
    public function toXmlArrayForVnsSubnet()
    {
        return array(
            Resources::XTAG_SUBNET                     => array(
                Resources::XTAG_ATTRIBUTES             => array(
                    Resources::XTAG_ATTRIBUTE_NAME     =>
                    $this->_vnsSubnetName
                ),
                Resources::XTAG_ADDRESS_PREFIX         =>
                $this->_vnsSubnetAddressPrefix
            )
        );
    }

    /**
     * Convert elements to XML array
     *
     * @return void
     */
    public function toXmlArrayForVns($subnetXmlElements)
    {
        return array(
            Resources::XTAG_VIRTUAL_NETWORK_SITE       => array(
                Resources::XTAG_ATTRIBUTES             => array(
                    Resources::XTAG_ATTRIBUTE_NAME     =>
                    $this->_vnsName,
                    Resources::XTAG_LOCATION =>
                    $this->_vnsLocation
                ),
                Resources::XTAG_SUBNETS                => $subnetXmlElements,
                Resources::XTAG_ADDRESS_SPACE          => array(
                    Resources::XTAG_ADDRESS_PREFIX     =>
                    $this->_vnsAddressSpaceAddressPrefix
                )
            )
        );
    }

    /**
     * Convert elements to XML array
     *
     * @param array $vnsXmlElements
     * @return array
     */
    public static function toXmlArray($vnsXmlElements)
    {
        $namespace = array(Resources::NC_XML_NAMESPACE => null);
        $xmlElements = array(
            Resources::XTAG_NAMESPACE                          => $namespace,
            Resources::XTAG_VIRTUAL_NETWORK_CONFIGURATION      => array(
                Resources::XTAG_VIRTUAL_NETWORK_SITES          => $vnsXmlElements
            )
        );

        return $xmlElements;
    }
}
