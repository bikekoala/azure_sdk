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
 *
 * @category  Microsoft
 * @package   WindowsAzure
 * @author    Azure PHP SDK <azurephpsdk@microsoft.com>
 * @copyright 2012 Microsoft Corporation
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/windowsazure/azure-sdk-for-php
 */

spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'windowsazure\\common\\cloudconfigurationmanager' => '/Common/CloudConfigurationManager.php',
                'windowsazure\\common\\internal\\atom\\atombase' => '/Common/Internal/Atom/AtomBase.php',
                'windowsazure\\common\\internal\\atom\\atomlink' => '/Common/Internal/Atom/AtomLink.php',
                'windowsazure\\common\\internal\\atom\\category' => '/Common/Internal/Atom/Category.php',
                'windowsazure\\common\\internal\\atom\\content' => '/Common/Internal/Atom/Content.php',
                'windowsazure\\common\\internal\\atom\\entry' => '/Common/Internal/Atom/Entry.php',
                'windowsazure\\common\\internal\\atom\\feed' => '/Common/Internal/Atom/Feed.php',
                'windowsazure\\common\\internal\\atom\\generator' => '/Common/Internal/Atom/Generator.php',
                'windowsazure\\common\\internal\\atom\\person' => '/Common/Internal/Atom/Person.php',
                'windowsazure\\common\\internal\\atom\\source' => '/Common/Internal/Atom/Source.php',
                'windowsazure\\common\\internal\\authentication\\iauthscheme' => '/Common/Internal/Authentication/IAuthScheme.php',
                'windowsazure\\common\\internal\\authentication\\oauthscheme' => '/Common/Internal/Authentication/OAuthScheme.php',
                'windowsazure\\common\\internal\\authentication\\sharedkeyauthscheme' => '/Common/Internal/Authentication/SharedKeyAuthScheme.php',
                'windowsazure\\common\\internal\\authentication\\storageauthscheme' => '/Common/Internal/Authentication/StorageAuthScheme.php',
                'windowsazure\\common\\internal\\authentication\\tablesharedkeyliteauthscheme' => '/Common/Internal/Authentication/TableSharedKeyLiteAuthScheme.php',
                'windowsazure\\common\\internal\\connectionstringparser' => '/Common/Internal/ConnectionStringParser.php',
                'windowsazure\\common\\internal\\connectionstringsource' => '/Common/Internal/ConnectionStringSource.php',
                'windowsazure\\common\\internal\\filterableservice' => '/Common/Internal/FilterableService.php',
                'windowsazure\\common\\internal\\filters\\authenticationfilter' => '/Common/Internal/Filters/AuthenticationFilter.php',
                'windowsazure\\common\\internal\\filters\\datefilter' => '/Common/Internal/Filters/DateFilter.php',
                'windowsazure\\common\\internal\\filters\\exponentialretrypolicy' => '/Common/Internal/Filters/ExponentialRetryPolicy.php',
                'windowsazure\\common\\internal\\filters\\headersfilter' => '/Common/Internal/Filters/HeadersFilter.php',
                'windowsazure\\common\\internal\\filters\\retrypolicy' => '/Common/Internal/Filters/RetryPolicy.php',
                'windowsazure\\common\\internal\\filters\\retrypolicyfilter' => '/Common/Internal/Filters/RetryPolicyFilter.php',
                'windowsazure\\common\\internal\\filters\\wrapfilter' => '/Common/Internal/Filters/WrapFilter.php',
                'windowsazure\\common\\internal\\http\\batchrequest' => '/Common/Internal/Http/BatchRequest.php',
                'windowsazure\\common\\internal\\http\\batchresponse' => '/Common/Internal/Http/BatchResponse.php',
                'windowsazure\\common\\internal\\http\\httpcallcontext' => '/Common/Internal/Http/HttpCallContext.php',
                'windowsazure\\common\\internal\\http\\httpclient' => '/Common/Internal/Http/HttpClient.php',
                'windowsazure\\common\\internal\\http\\ihttpclient' => '/Common/Internal/Http/IHttpClient.php',
                'windowsazure\\common\\internal\\http\\iurl' => '/Common/Internal/Http/IUrl.php',
                'windowsazure\\common\\internal\\http\\url' => '/Common/Internal/Http/Url.php',
                'windowsazure\\common\\internal\\invalidargumenttypeexception' => '/Common/Internal/InvalidArgumentTypeException.php',
                'windowsazure\\common\\internal\\iservicefilter' => '/Common/Internal/IServiceFilter.php',
                'windowsazure\\common\\internal\\logger' => '/Common/Internal/Logger.php',
                'windowsazure\\common\\internal\\mediaservicessettings' => '/Common/Internal/MediaServicesSettings.php',
                'windowsazure\\common\\internal\\oauthrestproxy' => '/Common/Internal/OAuthRestProxy.php',
                'windowsazure\\common\\internal\\parserstate' => '/Common/Internal/ConnectionStringParser.php',
                'windowsazure\\common\\internal\\resources' => '/Common/Internal/Resources.php',
                'windowsazure\\common\\internal\\restproxy' => '/Common/Internal/RestProxy.php',
                'windowsazure\\common\\internal\\serialization\\iserializer' => '/Common/Internal/Serialization/ISerializer.php',
                'windowsazure\\common\\internal\\serialization\\jsonserializer' => '/Common/Internal/Serialization/JsonSerializer.php',
                'windowsazure\\common\\internal\\serialization\\xmlserializer' => '/Common/Internal/Serialization/XmlSerializer.php',
                'windowsazure\\common\\internal\\servicebussettings' => '/Common/Internal/ServiceBusSettings.php',
                'windowsazure\\common\\internal\\servicemanagementsettings' => '/Common/Internal/ServiceManagementSettings.php',
                'windowsazure\\common\\internal\\servicerestproxy' => '/Common/Internal/ServiceRestProxy.php',
                'windowsazure\\common\\internal\\servicesettings' => '/Common/Internal/ServiceSettings.php',
                'windowsazure\\common\\internal\\storageservicesettings' => '/Common/Internal/StorageServiceSettings.php',
                'windowsazure\\common\\internal\\utilities' => '/Common/Internal/Utilities.php',
                'windowsazure\\common\\internal\\validate' => '/Common/Internal/Validate.php',
                'windowsazure\\common\\models\\logging' => '/Common/Models/Logging.php',
                'windowsazure\\common\\models\\metrics' => '/Common/Models/Metrics.php',
                'windowsazure\\common\\models\\oauthaccesstoken' => '/Common/Models/OAuthAccessToken.php',
                'windowsazure\\common\\models\\retentionpolicy' => '/Common/Models/RetentionPolicy.php',
                'windowsazure\\common\\models\\serviceproperties' => '/Common/Models/ServiceProperties.php',
                'windowsazure\\common\\serviceexception' => '/Common/ServiceException.php',
                'windowsazure\\common\\servicesbuilder' => '/Common/ServicesBuilder.php',
                'windowsazure\\servicemanagement\\internal\\iservicemanagement' => '/ServiceManagement/Internal/IServiceManagement.php',

                'windowsazure\\servicemanagement\\internal\\options' => '/ServiceManagement/Internal/Options.php',
                'windowsazure\\servicemanagement\\internal\\service' => '/ServiceManagement/Internal/Service.php',
                'windowsazure\\servicemanagement\\internal\\windowsazureservice' => '/ServiceManagement/Internal/WindowsAzureService.php',

                'windowsazure\\servicemanagement\\models\\createaffinitygroupoptions' => '/ServiceManagement/Models/CreateAffinityGroupOptions.php',
                'windowsazure\\servicemanagement\\models\\createdeploymentbyrolesoptions' => '/ServiceManagement/Models/CreateDeploymentByRolesOptions.php',
                'windowsazure\\servicemanagement\\models\\createstorageoptions' => '/ServiceManagement/Models/CreateStorageOptions.php',
                'windowsazure\\servicemanagement\\models\\getdeploymentoptions' => '/ServiceManagement/Models/GetDeploymentOptions.php',
                'windowsazure\\servicemanagement\\models\\setnetworkconfigurationoptions' => '/ServiceManagement/Models/SetNetworkConfigurationOptions.php',
                'windowsazure\\servicemanagement\\models\\addroleoptions' => '/ServiceManagement/Models/AddRoleOptions.php',
                'windowsazure\\servicemanagement\\models\\createhostedserviceoptions' => '/ServiceManagement/Models/CreateHostedServiceOptions.php',
                'windowsazure\\servicemanagement\\models\\gethostedservicepropertiesoptions' => '/ServiceManagement/Models/GetHostedServicePropertiesOptions.php',
                'windowsazure\\servicemanagement\\models\\addmanagementcertificatesoptions' => '/ServiceManagement/Models/AddManagementCertificatesOptions.php',
                'windowsazure\\servicemanagement\\models\\operateroleoptions' => '/ServiceManagement/Models/OperateRoleOptions.php',
                'windowsazure\\servicemanagement\\models\\deletedeploymentoptions' => '/ServiceManagement/Models/DeleteDeploymentOptions.php',

                'windowsazure\\servicemanagement\\servicemanagementrestproxy' => '/ServiceManagement/ServiceManagementRestProxy.php',
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
