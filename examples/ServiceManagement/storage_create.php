<?PHP
/**
 * 创建存储账户
 *
 * http://msdn.microsoft.com/zh-cn/library/azure/hh264518.aspx
 */
require 'common.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceManagement\Models\CreateStorageOptions;

//备注
//
//可通过创建存储帐户操作以编程方式创建存储帐户，数量最多可达订阅中给出的限制。对一个订阅的存储帐户数的初始限制为 20。在 Azure 异步执行存储帐户创建操作时，该操作将立即返回一个请求 ID，因为设置一个新的存储帐户可能需要几分钟。若要了解存储帐户创建操作何时完成，可使用请求 ID 轮询获取操作状态操作。该操作将返回一个 XML 正文，其中含有一个 Operation 元素，该元素包含一个 Status 元素，其值将为 InProgress、Failed 或 Succeeded，具体取决于存储帐户创建的状态。如果轮询到状态变为 Failed 或 Succeeded 为止，则 Operation 元素将在 StatusCode 元素中包含状态代码，而失败的操作将在 Error 元素中包含其他错误信息。有关详细信息，请参阅获取操作状态。
//http://msdn.microsoft.com/zh-cn/library/azure/ee460783.aspx

//TODO: 由于版本升级，需要传入AccountType参数，记得清理其他无法用的方法
try {
    $serviceManagementRestProxy = ServicesBuilder::getInstance()->createServiceManagementService($conn_string);

    //Service Name
    //必需。存储帐户在 Azure 中独一无二的名称。存储帐户名称的长度必须介于 3 和 24 个字符之间，且只能使用数字和小写字母。
    //该名称是 DNS 前缀名称，可用于访问存储帐户中的 blob、队列和表。
    //例如：http://ServiceName.blob.core.windows.net/mycontainer/
    //Label
    //必需。以 Base64 编码字符串形式指定的存储帐户标签。该标签的长度最长可以为 100 个字符。该标签可用于标识存储帐户，以便进行跟踪。
    $name = 'apitestucw';
    $label = base64_encode($name . 'popfeng');

    $serviceOptions = new createStorageOptions();
    $serviceOptions->setLocation('China North');

    $result = $serviceManagementRestProxy->createStorageAccount($name, $label, $serviceOptions);
    print_r($result);
} catch (ServiceException $e) {
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/ee460801
    echo $e->getMessage();
}
