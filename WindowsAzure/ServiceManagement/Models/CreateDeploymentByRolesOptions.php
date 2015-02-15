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
use WindowsAzure\ServiceManagement\Internal\Options;

/**
 * The optional parameters for createDeploymentByRoles API.
 *
 * @see http://msdn.microsoft.com/library/azure/jj157194.aspx
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-20
 */
class CreateDeploymentByRolesOptions extends Options
{
    /**
     * @var string
     */
    private $_deploymentSlot = 'Production';

    /**
     * @var string
     */
    private $_virtualNetworkName;

    /**
     * @var array
     */
    private $_roleList;

    /**
     * Sets the deployment slot
     *
     * Required. Specifies the environment in which the Virtual Machine
     * is to be deployed. The only allowable value is Production.
     *
     * @param string $deploymentSlot
     * @return void
     */
    public function setDeploymentSlot($deploymentSlot)
    {
        Validate::isString($deploymentSlot, 'slot');
        Validate::notNullOrEmpty($deploymentSlot, 'slot');

        $this->_deploymentSlot = $deploymentSlot;
    }

    /**
     * Sets the virtual network name
     *
     * Optional. Specifies the name of an existing virtual network to which
     * the deployment will belong.
     *
     * Virtual networks are created by calling the Set Network
     * Configuration operation.
     *
     * @param string $virtualNetworkName
     * @return void
     */
    public function setVirtualNetworkName($virtualNetworkName)
    {
        Validate::isString($virtualNetworkName, 'virtualNetworkName');
        Validate::notNullOrEmpty($virtualNetworkName, 'virtualNetworkName');

        $this->_virtualNetworkName = $virtualNetworkName;
    }

    /**
     * Sets the role list
     *
     * Required. Contains information about the Virtual Machines
     * that are to be deployed.
     *
     * @param array $roleList
     * @return void
     */
    public function setRoleList($roleList)
    {
        Validate::isArray($roleList, 'RoleList');
        Validate::notNullOrEmpty($roleList, 'RoleList');

        $this->_roleList = $roleList;
    }

    /**
     * Convert elements to XML array
     *
     * @return array
     */
    public function toXmlArray()
    {
        return array(
            Resources::XTAG_NAME            => $this->_name,
            Resources::XTAG_DEPLOYMENT_SLOT => $this->_deploymentSlot,
            Resources::XTAG_LABEL           => $this->_label,
            Resources::XTAG_ROLE_LIST       => $this->_roleList,
            Resources::XTAG_VIRTUAL_NETWORK_NAME => $this->_virtualNetworkName
        );
    }
}
