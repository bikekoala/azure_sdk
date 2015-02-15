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

namespace WindowsAzure\ServiceManagement\Internal;
use WindowsAzure\Common\Internal\Resources;
use WindowsAzure\Common\Internal\Validate;

/**
 * Optional parameters for createStorageService API.
 *
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-23
 */
class Options
{
    /**
     * @var string
     */
    protected $_name;

    /**
     * @var string
     */
    protected $_label;

    /**
     * @var string
     */
    protected $_location;

    /**
     * @var string
     */
    protected $_affinityGroup;

    /**
     * @var string
     */
    protected $_description;

    /**
     * Sets the name.
     * 
     * @param string $name
     * 
     * @return void
     */
    public function setName($name)
    {
        Validate::isString($name, 'Name');
        Validate::notNullOrEmpty($name, 'Name');

        $this->_name = $name;
    }

    /**
     * Sets the label.
     * 
     * @param string $label
     * 
     * @return void
     */
    public function setLabel($label)
    {
        Validate::isString($label, 'Label');
        Validate::notNullOrEmpty($label, 'Label');

        $this->_label = $label;
    }

    /**
     * Sets the location
     *
     * @param array $location
     * @return void
     */
    public function setLocation($location)
    {
        Validate::isString($location, 'Location');
        Validate::notNullOrEmpty($location, 'Location');

        $this->_location = $location;
    }

    /**
     * Sets the affinityGroup.
     * 
     * @param string $affinityGroup The affinityGroup.
     * 
     * @return void
     */
    public function setAffinityGroup($affinityGroup)
    {
        Validate::isString($affinityGroup, 'AffinityGroup');
        Validate::notNullOrEmpty($affinityGroup, 'AffinityGroup');

        $this->_affinityGroup = $affinityGroup;
    }

    /**
     * Sets the description.
     * 
     * @param string $description The description.
     * 
     * @return void
     */
    public function setDescription($description)
    {
        Validate::isString($description, 'Description');

        $this->_description = $description;
    }
}
