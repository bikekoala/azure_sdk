# Microsoft Azure SDK for PHP

This project provides a set of PHP client libraries that make it easy to access
Microsoft Azure tables, blobs, queues, service bus (queues and topics), service runtime and service management APIs. For documentation on how to host PHP applications on Microsoft Azure, please see the
[Microsoft Azure PHP Developer Center](http://www.windowsazure.com/en-us/develop/php/).

# Features

* Service Management
  * storage accounts: create, update, delete, list, regenerate keys
  * affinity groups: create, update, delete, list, get properties
  * locations: list
  * hosted services: create, update, delete, list, get properties
  * deployment: create, get, delete, swap, change configuration, update status, upgrade, rollback
  * role instance: reboot, reimage
  * REST API Version: 2014-06-01

  
# Getting Started

## Download Source Code

To get the source code from GitLab, type

    git clone https://github.com/popfeng/azure_sdk.git
    cd ./azure-sdk

> **Note**
> 
> The PHP Client Libraries for Microsoft Azure have a dependency on the [HTTP_Request2](http://pear.php.net/package/HTTP_Request2), [Mail_mime](http://pear.php.net/package/Mail_mime), and [Mail_mimeDecode](http://pear.php.net/package/Mail_mimeDecode) PEAR packages. The recommended way to resolve these dependencies is to install them using the [PEAR package manager](http://pear.php.net/manual/en/installation.php).

# Usage

## Getting Started

There are four basic steps that have to be performed before you can make a call to any Microsoft Azure API when using the libraries. 

* First, include the autoloader script:

    require_once "WindowsAzure/WindowsAzure.php"; 
  
* Include the namespaces you are going to use.

  To create any Microsoft Azure service client you need to use the **ServicesBuilder** class:

    use WindowsAzure\Common\ServicesBuilder;

  To process exceptions you need:

    use WindowsAzure\Common\ServiceException;

  
* To instantiate the service client you will also need a valid connection string. The format is: 

  * For accessing a live storage service (tables, blobs, queues):
  
      DefaultEndpointsProtocol=[http|https];AccountName=[yourAccount];AccountKey=[yourKey]
  
  * For accessing the emulator storage:
  
      UseDevelopmentStorage=true

  * For accessing the Service Bus:

      Endpoint=[yourEndpoint];SharedSecretIssuer=[yourWrapAuthenticationName];SharedSecretValue=[yourWrapPassword]

    Where the Endpoint is typically of the format `https://[yourNamespace].servicebus.chinacloudapi.cn`.

  * For accessing Service Management APIs:

      SubscriptionID=[yourSubscriptionId];CertificatePath=[filePathToYourCertificate]


* Instantiate a "REST Proxy" - a wrapper around the available calls for the given service.

  * For Service Management:

      $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($connectionString);


## Service Management

### Set-up certificates

You  need to create two certificates, one for the server (a .cer file) and one for the client (a .pem file). To create the .pem file using [OpenSSL](http://www.openssl.org), execute this: 

  openssl req -x509 -nodes -days 365 -newkey rsa:1024 -keyout mycert.pem -out mycert.pem

To create the .cer certificate, execute this: 

  openssl x509 -inform pem -in mycert.pem -outform der -out mycert.cer

### List Available Locations

```PHP  
$serviceManagementRestProxy->listLocations();
$locations = $result->getLocations();
foreach($locations as $location){
      echo $location->getName()."<br />";
}
```

### Create a Storage Service

To create a storage service, you need a name for the service (between 3 and 24 lowercase characters and unique within Microsoft Azure), a label (a base-64 encoded name for the service, up to 100 characters), and either a location or an affinity group. Providing a description for the service is optional.

```PHP
$name = "mystorageservice";
$label = base64_encode($name);
$options = new CreateStorageServiceOptions();
$options->setLocation('West US');

$result = $serviceManagementRestProxy->createStorageService($name, $label, $options);
```
  
  
### Create a Cloud Service

A cloud service is also known as a hosted service (from earlier versions of Microsoft Azure).  The **createHostedServices** method allows you to create a new hosted service by providing a hosted service name (which must be unique in Microsoft Azure), a label (the base 64-endcoded hosted service name), and a **CreateServiceOptions** object which allows you to set the location *or* the affinity group for your service. 

```PHP
$name = "myhostedservice";
$label = base64_encode($name);
$options = new CreateServiceOptions();
$options->setLocation('West US');
// Instead of setLocation, you can use setAffinityGroup to set an affinity group.

$result = $serviceManagementRestProxy->createHostedService($name, $label, $options);
```

### Create a Deployment

To make a new deployment to Azure you must store the package file in a Microsoft Azure Blob Storage account under the same subscription as the hosted service to which the package is being uploaded. You can create a deployment package with the [Microsoft Azure PowerShell cmdlets](https://www.windowsazure.com/en-us/develop/php/how-to-guides/powershell-cmdlets/), or with the [cspack commandline tool](http://msdn.microsoft.com/en-us/library/windowsazure/gg432988.aspx).

```PHP
$hostedServiceName = "myhostedservice";
$deploymentName = "v1";
$slot = DeploymentSlot::PRODUCTION;
$packageUrl = "URL_for_.cspkg_file";
$configuration = file_get_contents('path_to_.cscfg_file');
$label = base64_encode($hostedServiceName);

$result = $serviceManagementRestProxy->createDeployment($hostedServiceName,
                         $deploymentName,
                         $slot,
                         $packageUrl,
                         $configuration,
                         $label);

$status = $serviceManagementRestProxy->getOperationStatus($result);
echo "Operation status: ".$status->getStatus()."<br />";
```

# Need Help?

Be sure to check out the Microsoft Azure [Developer Forums on Stack Overflow](http://go.microsoft.com/fwlink/?LinkId=234489) if you have trouble with the provided code.

# Contribute Code or Provide Feedback

If you would like to become an active contributor to this project please follow the instructions provided in [Microsoft Azure Projects Contribution Guidelines](http://windowsazure.github.com/guidelines.html).

To setup your development environment, follow the instructions in this [wiki page](https://github.com/Azure/azure-sdk-for-php/wiki/Devbox-installation-guide).

If you encounter any bugs with the library please file an issue in the [Issues](https://github.com/Azure/azure-sdk-for-php/issues) section of the project.

# Learn More
[Microsoft Azure PHP Developer Center](http://www.windowsazure.com/en-us/develop/php/)
