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
 * The optional parameter for _operateRole API.
 *
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-26
 */
class OperateRoleOptions
{
    /**
     * @var string
     */
    private $_operationType;

    /**
     * @var mixed
     */
    private $_postShutdownAction;

    /**
     * Sets the operation type
     *
     * @param string $type
     * @return void
     */
    public function setOperationType($type)
    {
        Validate::isString($type, 'OperationType');
        Validate::notNullOrEmpty($type, 'OperationType');

        $this->_operationType = $type;
    }

    /**
     * Sets the post shutdown action
     *
     * @param string $action
     * @return void
     */
    public function setPostShutdownAction($action)
    {
        Validate::isString($action, 'PostShutdownAction');
        Validate::notNullOrEmpty($action, 'PostShutdownAction');

        $this->_postShutdownAction = $action;
    }

    /**
     * Convert elements to XML array
     *
     * @return array
     */
    public function toXmlArray()
    {
        $xmlElements = array(
            Resources::XTAG_OPERATION_TYPE => $this->_operationType
        );

        if ( ! empty($this->_postShutdownAction)) {
            $xmlElements[Resources::XTAG_POST_SHUTDOWN_ACTION] =
                $this->_postShutdownAction;
        }

        return $xmlElements;
    }
}
