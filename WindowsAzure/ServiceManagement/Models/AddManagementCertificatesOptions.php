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
use WindowsAzure\Common\Internal\Resources;
use WindowsAzure\Common\Internal\Validate;

/**
 * The optional parameters for AddManagementCertificatesOptions API.
 *
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-25
 */
class AddManagementCertificatesOptions
{
    /**
     * @var string
     */
    private $_publicKey;

    /**
     * @var string
     */
    private $_thumbprint;

    /**
     * @var string
     */
    private $_data;

    /**
     * Sets the subscription certificate public key
     *
     * Specifies a base-64 encoded public key for the management certificate.
     *
     * @param string $publicKey
     * @return void
     */
    public function setPublicKey($publicKey)
    {
        Validate::isString($publicKey, 'SubscriptionCertificatePublicKey');
        Validate::notNullOrEmpty($publicKey, 'SubscriptionCertificatePublicKey');

        $this->_publicKey = $publicKey;
    }

    /**
     * Sets the subscription certificate thumbprint
     *
     * Specifies the thumbprint for the management certificate.
     *
     * @param string $thumbprint
     * @return void
     */
    public function setThumbprint($thumbprint)
    {
        Validate::isString($thumbprint, 'SubscriptionCertificateThumbprint');
        Validate::notNullOrEmpty($thumbprint, 'SubscriptionCertificateThumbprint');

        $this->_thumbprint = $thumbprint;
    }

    /**
     * Sets the subscription certificate data
     *
     * Specifies the base-64 encoded certificate data in .cer format.
     *
     * @param string $data
     * @return void
     */
    public function setData($data)
    {
        Validate::isString($data, 'SubscriptionCertificateData');
        Validate::notNullOrEmpty($data, 'SubscriptionCertificateData');

        $this->_data = $data;
    }

    /**
     * Convert elements to XML array
     *
     * @return array
     */
    public function toXmlArray()
    {
        return array(
            Resources::XTAG_SUBSCRIPTION_CERTIFICATE_PUBLIC_KEY => $this->_publicKey,
            Resources::XTAG_SUBSCRIPTION_CERTIFICATE_THUMBPRINT => $this->_thumbprint,
            Resources::XTAG_SUBSCRIPTION_CERTIFICATE_DATA       => $this->_data
        );
    }
}
