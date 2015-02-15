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

namespace WindowsAzure\ServiceManagement;
use WindowsAzure\Common\Internal\Resources;
use WindowsAzure\Common\Internal\Validate;
use WindowsAzure\Common\Internal\Utilities;
use WindowsAzure\Common\Internal\RestProxy;
use WindowsAzure\Common\Internal\Http\HttpCallContext;
use WindowsAzure\Common\Internal\Serialization\XmlSerializer;
use WindowsAzure\ServiceManagement\Internal\IServiceManagement;
use WindowsAzure\ServiceManagement\Models\CreateStorageOptions;
use WindowsAzure\ServiceManagement\Models\CreateHostedServiceOptions;
use WindowsAzure\ServiceManagement\Models\CreateAffinityGroupOptions;
use WindowsAzure\ServiceManagement\Models\CreateDeploymentByRolesOptions;
use WindowsAzure\ServiceManagement\Models\GetHostedServicePropertiesOptions;
use WindowsAzure\ServiceManagement\Models\GetDeploymentOptions;
use WindowsAzure\ServiceManagement\Models\SetNetworkConfigurationOptions;
use WindowsAzure\ServiceManagement\Models\AddRoleOptions;
use WindowsAzure\ServiceManagement\Models\AddManagementCertificatesOptions;
use WindowsAzure\ServiceManagement\Models\OperateRoleOptions;
use WindowsAzure\ServiceManagement\Models\DeleteDeploymentOptions;

/**
 * ServiceManagementRestProxy
 * This class constructs HTTP requests and receive HTTP responses for service
 * management service layer.
 *
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-24
 */
class ServiceManagementRestProxy extends RestProxy
    implements IServiceManagement
{
    /**
     * @var string
     */
    private $_subscriptionId;

    /**
     * Initializes new ServiceManagementRestProxy object.
     *
     * @param IHttpClient $channel        The HTTP channel.
     * @param string      $subscriptionId The user subscription id.
     * @param string      $uri            The service URI.
     * @param ISerializer $dataSerializer The data serializer.
     */
    public function __construct($channel, $subscriptionId, $uri, $dataSerializer)
    {
        parent::__construct(
            $channel,
            $dataSerializer,
            $uri
        );
        $this->_subscriptionId = $subscriptionId;
    }

    /**
     * Constructs URI path for given service management resource.
     *
     * @param string $serviceManagementResource The resource name.
     * @param string $name                      The service name.
     *
     * @return string
     */
    private function _getPath($serviceManagementResource = null, $name = null)
    {
        $path = $this->_subscriptionId;
        if (!is_null($serviceManagementResource)) {
            $path .= '/' . $serviceManagementResource;
        }

        if (!is_null($name)) {
            $path .= '/' . $name;
        }

        return $path;
    }

    /**
     * Constructs URI path for locations.
     *
     * @return string
     */
    private function _getLocationPath()
    {
        return $this->_getPath('locations', null);
    }

    /**
     * Constructs URI path for affinity group.
     *
     * @param string $name The affinity group name.
     *
     * @return string
     */
    private function _getAffinityGroupPath($name = null)
    {
        return $this->_getPath('affinitygroups', $name);
    }

    /**
     * Constructs URI path for storage service.
     *
     * @param string $name The storage service name.
     *
     * @return string
     */
    private function _getStorageServicePath($name = null)
    {
        return $this->_getPath('services/storageservices', $name);
    }

    /**
     * Constructs URI path for check storage account name.
     *
     * @param string $name The storage service name.
     *
     * @return string
     */
    private function _getStorageServiceCheckAccountNamePath($name = null)
    {
        return $this->_getPath('services/storageservices/operations/isavailable', $name);
    }

    /**
     * Constructs URI path for hosted service.
     *
     * @param string $name The hosted service name.
     *
     * @return string
     */
    private function _getHostedServicePath($name = null)
    {
        return $this->_getPath('services/hostedservices', $name);
    }

    /**
     * Constructs URI path for check hosted cloud service name.
     *
     * @param string $name The cloud service name.
     *
     * @return string
     */
    private function _getHostedServiceCheckNamePath($name = null)
    {
        return $this->_getPath('services/hostedservices/operations/isavailable', $name);
    }

    /**
     * Constructs URI path for deployment slot.
     *
     * @param string $name The hosted service name.
     * @param string $slot The deployment slot name.
     *
     * @return string
     */
    private function _getDeploymentPathUsingSlot($name, $slot)
    {
        $path = "services/hostedservices/$name/deploymentslots";
        return $this->_getPath($path, $slot);
    }

    /**
     * Constructs URI path for deployment slot.
     *
     * @param string $name           The hosted service name.
     * @param string $deploymentName The deployment slot name.
     *
     * @return string
     */
    private function _getDeploymentPathUsingName($name, $deploymentName = null)
    {
        $path = "services/hostedservices/$name/deployments";
        return $this->_getPath($path, $deploymentName);
    }

    /**
     * Gets role instance operation path.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     *
     * @return string
     */
    private function _getRoleInstanceOperationPath(
        $cloudServiceName,
        $deploymentName,
        $roleName
    ) {
        $options = new GetDeploymentOptions();
        $options->setDeploymentName($deploymentName);

        $path = $this->_getDeploymentPath($cloudServiceName, $options) . 
            '/roleinstances/' . $roleName . '/Operations';

        return $path;
    }

    /**
     * Gets role path.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     *
     * @return string
     */
    private function _getRolePath(
        $cloudServiceName,
        $deploymentName,
        $roleName = null
    ) {
        $options = new GetDeploymentOptions();
        $options->setDeploymentName($deploymentName);

        $path = $this->_getDeploymentPath($cloudServiceName, $options) . 
            '/roles';
        if ( ! is_null($roleName)) {
            $path .= '/' . $roleName;
        }

        return $path;
    }

    /**
     * Gets the deployment URI path using the slot or name.
     *
     * @param string               $name    The hosted service name.
     * @param GetDeploymentOptions $options The optional parameters.
     *
     * @return string
     */
    private function _getDeploymentPath($name, $options)
    {
        $slot           = $options->getSlot();
        $deploymentName = $options->getDeploymentName();
        $path           = null;

        Validate::isTrue(
            ! empty($slot) || ! empty($deploymentName),
            Resources::INVALID_DEPLOYMENT_LOCATOR_MSG
        );

        if ( ! empty($deploymentName)) {
            $path = $this->_getDeploymentPathUsingName($name, $deploymentName);
        } else {
            $path = $this->_getDeploymentPathUsingSlot($name, $slot);
        }

        return $path;
    }

    /**
     * Constructs URI path for operations.
     *
     * @param string $name The operation resource name.
     *
     * @return string
     */
    private function _getOperationPath($name = null)
    {
        return $this->_getPath('operations', $name);
    }

    /**
     * Constructs URI path for virtual network.
     *
     * @param string $name The operation resource name.
     *
     * @return string
     */
    private function _getNetworkingVirtualNetworkPath($name = null)
    {
        return $this->_getPath('services/networking/virtualnetwork', $name);
    }

    /**
     * Constructs URI path for network media.
     *
     * @param string $name The operation resource name.
     *
     * @return string
     */
    private function _getNetworkingMediaPath($name = null)
    {
        return $this->_getPath('services/networking/media', $name);
    }

    /**
     * Constructs URI path for OS images.
     *
     * @param string $name The operation resource name.
     *
     * @return string
     */
    private function _getOsImagesPath($name = null)
    {
        return $this->_getPath('services/images', $name);
    }

    /**
     * Constructs URI path for Management Certificates.
     *
     * @param string $thumbprint the thumbprint of the management certificate.
     *
     * @return string
     */
    private function _getManagementCertificatesPath($thumbprint = null)
    {
        return $this->_getPath('certificates', $thumbprint);
    }

    /**
     * Constructs URI path for disk service.
     *
     * @param string $name The disk name.
     *
     * @return string
     */
    private function _getDiskServicePath($name = null)
    {
        return $this->_getPath('services/disks', $name);
    }

    /**
     * Constructs request XML including windows azure XML namesoace.
     *
     * @param array  $xmlElements The XML elements associated with their values.
     * @param string $root        The XML root name.
     *
     * @return string
     */
    private function _createRequestXml($xmlElements, $root)
    {
        $requestArray = array(
            Resources::XTAG_NAMESPACE  => array(
                Resources::WA_XML_NAMESPACE => null
            ),
            Resources::XTAG_ATTRIBUTES => array(
                Resources::XTAG_ATTRIBUTE_XMLNS_I =>
                    Resources::WA_XML_INSTANCE_NAMESPACE
            )
        );

        foreach ($xmlElements as $tagName => $value) {
            if (!empty($value)) {
                $requestArray[$tagName] = $value;
            }
        }

        $properties = array(XmlSerializer::ROOT_NAME => $root);

        return $this->dataSerializer->serialize($requestArray, $properties);
    }

    /**
     * The role operation function for Virtual Machine.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     * @param string $operationType
     * @param OperateRoleOptions $options
     * @return object
     */
    public function _operateRole(
        $cloudServiceName,
        $deploymentName,
        $roleName,
        $operationType,
        $options = null
    ) {
        Validate::isString($cloudServiceName, 'cloud-service-name');
        Validate::notNullOrEmpty($cloudServiceName, 'cloud-service-name');
        Validate::isString($deploymentName, 'deployment-name');
        Validate::notNullOrEmpty($deploymentName, 'deployment-name');
        Validate::isString($roleName, 'role-name');
        Validate::notNullOrEmpty($roleName, 'role-name');

        if (is_null($options)) {
            $options = new OperateRoleOptions();
        }
        $options->setOperationType($operationType);
        $xmlElements = $options->toXmlArray();
        $requestXml = $this->_createRequestXml($xmlElements, $operationType);

        $path = $this->_getRoleInstanceOperationPath(
            $cloudServiceName,
            $deploymentName,
            $roleName
        );
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_POST);
        $context->setPath($path);
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::XML_CONTENT_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Returns the system properties for the specified storage account.
     *
     * These properties include: the address, description, and label of the storage
     * account; and the name of the affinity group to which the service belongs,
     * or its geo-location if it is not part of an affinity group.
     *
     * @param string $name The storage account name.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee460802.aspx
     */
    public function getStorageAccountProperties($name)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getStorageServicePath($name));
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        $parsed   = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($parsed);
    }

    /**
     * The List Storage Accounts operation lists the storage accounts that are
     * available in the specified subscription.
     *
     * @return object
     */
    public function listStorageAccounts()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getStorageServicePath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        $parsed   = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($parsed);
    }

    /**
     * The Check Storage Account Name Availability operation checks to see if
     * the specified storage account name is available, or if it has already
     * been taken.
     *
     * @param string $name The storage account name.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj154125.aspx
     */
    public function checkStorageAccountName($name)
    {
        Validate::isString($name, 'storage account name');
        Validate::notNullOrEmpty($name, 'storage account name');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getStorageServiceCheckAccountNamePath($name));
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        $parsed   = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($parsed);
    }

    /**
     * Creates a new storage account in Windows Azure.
     *
     * In the optional parameters either location or affinity group must be provided.
     * Because Create Storage Account is an asynchronous operation, it always returns
     * status code 202 (Accepted). To determine the status code for the operation
     * once it is complete, call getOperationStatus API. The status code is embedded
     * in the response for this operation; if successful, it will be
     * status code 200 (OK).
     *
     * @param string               $name    The storage account name.
     * @param string               $label   The name for the storage account
     * specified as a base64-encoded string. The name may be up to 100 characters
     * in length. The name can be used identify the storage account for your tracking
     * purposes.
     * @param CreateStorageOptions $options The optional parameters.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh264518.aspx
     */
    public function createStorageAccount($name, $label, $options)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');
        Validate::isString($label, 'label');
        Validate::notNullOrEmpty($label, 'label');
        Validate::notNullOrEmpty($options, 'options');

        $options->setServiceName($name);
        $options->setLabel($label);
        $xmlElements = $options->toXmlArray();
        $requestXml = $this->_createRequestXml(
            $xmlElements,
            Resources::XTAG_CREATE_STORAGE_SERVICE_INPUT
        );

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_POST);
        $context->setPath($this->_getStorageServicePath());
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::XML_CONTENT_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Deletes the specified storage account from Windows Azure.
     *
     * @param string $name The storage account name.
     *
     * @return none
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/hh264517.aspx
     */
    public function deleteStorageAccount($name)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_DELETE);
        $context->setPath($this->_getStorageServicePath($name));
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Lists the affinity groups associated with the specified subscription.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee460797.aspx
     */
    public function listAffinityGroups()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getAffinityGroupPath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * Creates a new affinity group for the specified subscription.
     *
     * @param string                     $name     The affinity group name.
     * @param string                     $label    The base-64 encoded name for the
     * affinity group. The name can be up to 100 characters in length.
     * @param string                     $location The data center location where the
     * affinity group will be created. To list available locations, use the
     * listLocations API.
     * @param CreateAffinityGroupOptions $options  The optional parameters.
     *
     * @return none
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/gg715317.aspx
     */
    public function createAffinityGroup($name, $label, $location, $options = null)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');
        Validate::isString($label, 'label');
        Validate::notNullOrEmpty($label, 'label');
        Validate::isString($location, 'location');
        Validate::notNullOrEmpty($location, 'location');

        if (is_null($options)) {
            $options = new CreateAffinityGroupOptions();
        }
        $options->setName($name);
        $options->setLabel($label);
        $options->setLocation($location);
        $xmlElements = $options->toXmlArray();
        $requestXml = $this->_createRequestXml(
            $xmlElements,
            Resources::XTAG_CREATE_AFFINITY_GROUP
        );

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_POST);
        $context->setPath($this->_getAffinityGroupPath());
        $context->addStatusCode(Resources::STATUS_CREATED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::XML_CONTENT_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Deletes an affinity group in the specified subscription.
     *
     * @param string $name The affinity group name.
     *
     * @return none
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/gg715314.aspx
     */
    public function deleteAffinityGroup($name)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_DELETE);
        $context->setPath($this->_getAffinityGroupPath($name));
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Lists all of the data center locations that are valid for your subscription.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/gg441293.aspx
     */
    public function listLocations()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getLocationPath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * Returns the status of the specified operation. After calling an asynchronous
     * operation, you can call Get Operation Status to determine whether the
     * operation has succeeded, failed, or is still in progress.
     *
     * @param string $requestId
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee460783.aspx
     */
    public function getOperationStatus($requestId)
    {
        Validate::isString($requestId, 'requestId');
        Validate::notNullOrEmpty($requestId, 'requestId');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getOperationPath($requestId));
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * The Check Hosted Service Name Availability operation checks for the
     * availability of the specified cloud service name.
     *
     * @param string $name The cloud service name.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj154116.aspx
     */
    public function checkHostedServicesName($name)
    {
        Validate::isString($name, 'cloud service name');
        Validate::notNullOrEmpty($name, 'cloud service name');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getHostedServiceCheckNamePath($name));
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        $parsed   = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($parsed);
    }

    /**
     * Lists the hosted services available under the current subscription.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee460781.aspx
     */
    public function listHostedServices()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getHostedServicePath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * Creates a new hosted service in Windows Azure.
     *
     * @param string               $name    The name for the hosted service
     * that is unique within Windows Azure. This name is the DNS prefix name and can
     * be used to access the hosted service.
     * @param string               $label   The name for the hosted service
     * that is base-64 encoded. The name can be used identify the storage account for
     * your tracking purposes.
     * @param CreateHostedServiceOptions $options The optional parameters.
     *
     * @return none
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/gg441304.aspx
     */
    public function createHostedService($name, $label, $options)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');
        Validate::isString($label, 'label');
        Validate::notNullOrEmpty($label, 'label');
        Validate::notNullOrEmpty($options, 'options');

        $options->setServiceName($name);
        $options->setLabel($label);
        $xmlElements = $options->toXmlArray();
        $requestXml = $this->_createRequestXml(
            $xmlElements,
            Resources::XTAG_CREATE_HOSTED_SERVICE
        );

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_POST);
        $context->setPath($this->_getHostedServicePath());
        $context->addStatusCode(Resources::STATUS_CREATED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::XML_CONTENT_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Deletes the specified hosted service from Windows Azure.
     *
     * Before you can delete a hosted service, you must delete any deployments it
     * has. Attempting to delete a hosted service that has deployments results in
     * an error. You can call the deleteDeployment API to delete a hosted service's
     * deployments.
     *
     * @param string $name The name for the hosted service.
     *
     * @return none
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/gg441305.aspx
     */
    public function deleteHostedService($name)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_DELETE);
        $context->setPath($this->_getHostedServicePath($name));
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Retrieves system properties for the specified hosted service. These properties
     * include the service name and service type; the name of the affinity group to
     * which the service belongs, or its location if it is not part of an affinity
     * group; and optionally, information on the service's deployments.
     *
     * @param string                            $name    The name for the hosted
     * service.
     * @param GetHostedServicePropertiesOptions $options The optional parameters.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee460806.aspx
     */
    public function getHostedServiceProperties($name, $options = null)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');

        if (is_null($options)) {
            $options = new GetHostedServicePropertiesOptions();
        }

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getHostedServicePath($name));
        $context->addStatusCode(Resources::STATUS_OK);
        $context->addQueryParameter(
            Resources::QP_EMBED_DETAIL,
            Utilities::booleanToString($options->getEmbedDetail())
        );

        $response = $this->sendContext($context);
        $parsed   = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($parsed);
    }

    /**
     * The Create Virtual Machine Deployment operation creates a deployment
     * and then creates a Virtual Machine in the deployment based on
     * the specified configuration.
     *
     * The createDeployment API is an asynchronous operation.
     * To determine whether the management service has finished processing
     * the request, call getOperationStatus API.
     *
     * @param string                         $cloudServiceName
     * @param array                          $roleOptionsList
     * @param CreateDeploymentByRolesOptions $deploymentOptions
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/library/azure/jj157194.aspx
     */
    public function createDeploymentByRoles(
        $cloudServiceName,
        $roleOptionsList,
        $deploymentOptions = null
    ) {
        Validate::isString($cloudServiceName, 'cloudservice-name');
        Validate::notNullOrEmpty($cloudServiceName, 'cloudservice-name');
        Validate::notNullOrEmpty($roleOptionsList, 'roleOptionsList');
        Validate::notNullOrEmpty($deploymentOptions, 'deploymentOptions');

        $roleList = array();
        foreach ($roleOptionsList as $roleOptions) {
            $networkEndpointXmlElements = array();
            foreach ($roleOptions->getCsNetworkEndpointList() as $endpointOptions) {
                $networkEndpointXmlElements[] =
                    $endpointOptions->toXmlArrayForNetworkEndpoint();
            }

            $roleList[] = $roleOptions->
                toXmlArray($networkEndpointXmlElements, true);
        }
        $deploymentOptions->setRoleList($roleList);
        $xmlElements = $deploymentOptions->toXmlArray();

        $requestXml = $this->_createRequestXml(
            $xmlElements,
            Resources::XTAG_DEPLOYMENT
        );

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_POST);
        $context->setPath($this->_getDeploymentPathUsingName($cloudServiceName));
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::XML_CONTENT_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * Returns configuration information, status, and system properties for a
     * deployment.
     *
     * The getDeployment API can be used to retrieve information for a specific
     * deployment or for all deployments in the staging or production environment.
     * If you want to retrieve information about a specific deployment, you must
     * first get the unique name for the deployment. This unique name is part of the
     * response when you make a request to get all deployments in an environment.
     *
     * @param string               $name    The hosted service name.
     * @param GetDeploymentOptions $options The optional parameters.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/en-us/library/windowsazure/ee460804.aspx
     */
    public function getDeployment($name, $options = null)
    {
        Validate::isString($name, 'name');
        Validate::notNullOrEmpty($name, 'name');
        if (is_null($options)) {
            $options = new GetDeploymentOptions();
        }

        $context = new HttpCallContext();
        $path    = $this->_getDeploymentPath($name, $options);
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($path);
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        $parsed   = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($parsed);
    }


    /**
     * The Delete Deployment asynchronous operation deletes
     * the specified deployment.
     *
     * Note that you can delete a deployment either by specifying the deployment
     * environment (staging or production), or by specifying the deployment's unique
     * name.
     *
     * @param string                  $cloudServiceName
     * @param bool                    $isDeleteMedia 
     * @param DeleteDeploymentOptions $options
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/ee460815.aspx
     */
    public function deleteDeployment(
        $cloudServiceName,
        $isDeleteMedia = false,
        $options
    ) {
        Validate::isString($cloudServiceName, 'cloudservice-name');
        Validate::notNullOrEmpty($cloudServiceName, 'cloudservice-name');
        Validate::isBoolean($isDeleteMedia, 'isDeleteMedia');
        Validate::notNullOrEmpty($options, 'options');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_DELETE);
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        $context->setPath(
            $this->_getDeploymentPath($cloudServiceName, $options)
        );
        if ($isDeleteMedia) {
            $context->addQueryParameter(
                Resources::QP_COMP,
                Resources::QPV_MEDIA
            );
        }

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * The Add Role operation adds a Virtual Machine to a deployment of
     * Virtual Machines. Before you run this operation, you must have an
     * existing cloud service and deployment in Microsoft Azure. 
     *
     * The addRole API is an asynchronous operation.
     * To determine whether the management service has finished processing
     * the request, call getOperationStatus API.
     *
     * @param string            $cloudServiceName
     * @param string            $deploymentName
     * @param AddRoleOptions    $addRole
     *
     * @return object
     *
     * @see https://msdn.microsoft.com/library/azure/jj157186.aspx
     */
    public function addRole(
        $cloudServiceName,
        $deploymentName,
        $roleOptions
    ) {
        Validate::isString($cloudServiceName, 'cloudservice-name');
        Validate::notNullOrEmpty($cloudServiceName, 'cloudservice-name');
        Validate::isString($deploymentName, 'deployment-name');
        Validate::notNullOrEmpty($deploymentName, 'deployment-name');
        Validate::notNullOrEmpty($roleOptions, 'roleOptions');

        $networkEndpointXmlElements = array();
        foreach ($roleOptions->getCsNetworkEndpointList() as $endpointOptions) {
            $networkEndpointXmlElements[] =
                $endpointOptions->toXmlArrayForNetworkEndpoint();
        }
        $xmlElements = $roleOptions->toXmlArray($networkEndpointXmlElements, false);
        $requestXml = $this->_createRequestXml(
            $xmlElements,
            Resources::XTAG_PERSISTENT_VM_ROLE
        );

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_POST);
        $context->setPath($this->_getRolePath($cloudServiceName, $deploymentName));
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::XML_CONTENT_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * The Start Role operation starts the specified Virtual Machine.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj157189.aspx
     */
    public function startRole($cloudServiceName, $deploymentName, $roleName)
    {
        return $this->_operateRole(
            $cloudServiceName,
            $deploymentName,
            $roleName,
            Resources::XTAG_START_ROLE_OPERATION
        );
    }

    /**
     * The Restart role operation restarts the specified Virtual Machine.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj157197.aspx
     */
    public function restartRole($cloudServiceName, $deploymentName, $roleName)
    {
        return $this->_operateRole(
            $cloudServiceName,
            $deploymentName,
            $roleName,
            Resources::XTAG_RESTART_ROLE_OPERATION
        );
    }

    /**
     * The Shutdown Role operation shuts down the specified Virtual Machine.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     * @param OperateRoleOptions $options
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj157195.aspx
     */
    public function shutdownRole($cloudServiceName, $deploymentName, $roleName, $options)
    {
        return $this->_operateRole(
            $cloudServiceName,
            $deploymentName,
            $roleName,
            Resources::XTAG_SHUTDOWN_ROLE_OPERATION,
            $options
        );
    }

    /**
     * The Delete Role operation deletes the specified Virtual Machine.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     * @param bool   $isDeleteMedia
     * @return object
     */
    public function deleteRole(
        $cloudServiceName,
        $deploymentName,
        $roleName,
        $isDeleteMedia = false
    ) {
        Validate::isString($cloudServiceName, 'cloud-service-name');
        Validate::notNullOrEmpty($cloudServiceName, 'cloud-service-name');
        Validate::isString($deploymentName, 'deployment-name');
        Validate::notNullOrEmpty($deploymentName, 'deployment-name');
        Validate::isString($roleName, 'role-name');
        Validate::notNullOrEmpty($roleName, 'role-name');
        Validate::isBoolean($isDeleteMedia, 'isDeleteMedia');

        $path = $this->_getRolePath(
            $cloudServiceName,
            $deploymentName,
            $roleName
        );
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_DELETE);
        $context->setPath($path);
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        if ($isDeleteMedia) {
            $context->addQueryParameter(
                Resources::QP_COMP,
                Resources::QPV_MEDIA
            );
        }

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * The Get Role operation retrieves information
     * about the specified Virtual Machine.
     *
     * @param string $cloudServiceName
     * @param string $deploymentName
     * @param string $roleName
     * @return object
     */
    public function getRole($cloudServiceName, $deploymentName, $roleName)
    {
        Validate::isString($cloudServiceName, 'cloud-service-name');
        Validate::notNullOrEmpty($cloudServiceName, 'cloud-service-name');
        Validate::isString($deploymentName, 'deployment-name');
        Validate::notNullOrEmpty($deploymentName, 'deployment-name');
        Validate::isString($roleName, 'role-name');
        Validate::notNullOrEmpty($roleName, 'role-name');

        $path = $this->_getRolePath(
            $cloudServiceName,
            $deploymentName,
            $roleName
        );
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($path);
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * Lists the virtual networks configured for the subscription.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/library/azure/jj157185.aspx
     */
    public function listVirtualNetworkSites()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getNetworkingVirtualNetworkPath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * The Set Network Configuration asynchronous operation configures
     * the virtual network.
     *
     * @param array $options  The optional parameters list.
     * @return void
     */
    public function setNetworkConfiguration($optionsList)
    {
        Validate::notNullOrEmpty($optionsList, 'optionsList');

        $vnsXmlElements = array();
        foreach ($optionsList as $options) {
            $subnetXmlElements = array();
            foreach ($options->getVnsSubnetList() as $subnetOptions) {
                $subnetXmlElements[] = $subnetOptions->toXmlArrayForVnsSubnet();
            }
            $vnsXmlElements[] = $options->toXmlArrayForVns($subnetXmlElements);
        }
        $xmlElements = SetNetworkConfigurationOptions::toXmlArray($vnsXmlElements);
        $requestXml = $this->_createRequestXml(
            $xmlElements,
            Resources::XTAG_NETWORK_CONFIGURATION
        );

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_PUT);
        $context->setPath($this->_getNetworkingMediaPath());
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::TEXT_PLAIN_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($response->getHeader());
    }

    /**
     * The List OS Images operation retrieves a list of the operating system
     * images from the image repository that is associated with the specified
     * subscription.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj157191.aspx
     */
    public function listOsImages()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getOsImagesPath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * The List Management Certificates operation returns basic information
     * about all of the management certificates that are associated with the
     * specified subscription.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj154105.aspx
     */
    public function listManagementCertificates()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getManagementCertificatesPath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * The Get Management Certificate operation retrieves information about
     * the management certificate with the specified thumbprint.
     *
     * @param string $thumbprint
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj154131.aspx
     */
    public function getManagementCertificates($thumbprint)
    {
        Validate::isString($thumbprint, 'thumbprint');
        Validate::notNullOrEmpty($thumbprint, 'thumbprint');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getManagementCertificatesPath($thumbprint));
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * The Delete Management Certificate operation deletes a certificate from
     * the specified subscription.
     *
     * @param string $thumbprint
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj154127.aspx
     */
    public function deleteManagementCertificates($thumbprint)
    {
        Validate::isString($thumbprint, 'thumbprint');
        Validate::notNullOrEmpty($thumbprint, 'thumbprint');

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_DELETE);
        $context->setPath($this->_getManagementCertificatesPath($thumbprint));
        $context->addStatusCode(Resources::STATUS_OK);

        $this->sendContext($context);
    }

    /**
     * The Add Management Certificate operation adds a management certificate
     * to the specified subscription. For more information about management
     * certificates, see Manage Certificates.
     *
     * @param string $publicKey   Specifies a base-64 encoded public key for
     *                            the management certificate.
     * @param string $thumbprint  Specifies the thumbprint for the management
     *                            certificate.
     * @param string $data        Specifies the base-64 encoded certificate
     *                            data in .cer format.
     * @return object
     *
     * @see http://msdn.microsoft.com/zh-cn/library/azure/jj154123.aspx
     */
    public function addManagementCertificates($publicKey, $thumbprint, $data)
    {
        $options = new AddManagementCertificatesOptions();
        $options->setPublicKey($publicKey);
        $options->setThumbprint($thumbprint);
        $options->setData($data);
        $xmlElements = $options->toXmlArray();
        $requestXml = $this->_createRequestXml(
            $xmlElements,
            Resources::XTAG_SUBSCRIPTION_CERTIFICATE
        );

        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_POST);
        $context->setPath($this->_getManagementCertificatesPath());
        $context->addStatusCode(Resources::STATUS_ACCEPTED);
        $context->setBody($requestXml);
        $context->addHeader(
            Resources::CONTENT_TYPE,
            Resources::XML_CONTENT_TYPE
        );

        $response = $this->sendContext($context);
        return Utilities::arrayToObject($responses->getHeader());
    }

    /**
     * The Get Subscription operation returns account and resource allocation
     * information for the specified subscription.
     *
     * @return object
     *
     * @see http://msdn.microsoft.com/library/azure/hh403995.aspx
     */
    public function getSubscription()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getPath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response   = $this->sendContext($context);
        $serialized = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($serialized);
    }

    /**
     * The List Disks operation retrieves a list of the disks in the image
     * repository that is associated with the specified subscription.
     *
     * @return object
     * @see https://msdn.microsoft.com/library/azure/jj157176.aspx
     */
    public function listDisks()
    {
        $context = new HttpCallContext();
        $context->setMethod(Resources::HTTP_GET);
        $context->setPath($this->_getDiskServicePath());
        $context->addStatusCode(Resources::STATUS_OK);

        $response = $this->sendContext($context);
        $parsed   = $this->dataSerializer->unserialize($response->getBody());

        return Utilities::arrayToObject($parsed);
    }
}
