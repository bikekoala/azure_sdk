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
 * PHP version 5.6
 */
 
namespace WindowsAzure\Common;
use WindowsAzure\Common\Internal\Resources;
use WindowsAzure\Common\Internal\Serialization\XmlSerializer;

/**
 * Fires when the response code is incorrect.
 *
 * @author Xuewu Sun <sunxw@ucloudworld.com> 2014-11-19
 */
class ServiceException extends \LogicException
{
    /**
     * @var mixed
     */
    private $_errorCode;

    /**
     * @var mixed
     */
    private $_errorMessage;

    /**
     * @var int
     */
    private $_responseCode;

    /**
     * @var string
     */
    private $_responseCodeString;

    /**
     * @var string
     */
    private $_responseBody;

    /**
     * Constructor
     *
     * @param mixed  ... $params  variable arguments
     * 
     * @return WindowsAzure\Common\ServiceException
     */
    public function __construct(...$params)
    {
        if (1 === count($params)) {
            list($e) = $params;
            if ($e instanceof self) {
                $this->_responseCode       = $e->getResponseCode();
                $this->_responseCodeString = $e->getResponseCodeString();
                $this->_responseBody       = $e->getResponseBody();
            }
        } else {
            list(
                $this->_responseCode,
                $this->_responseCodeString,
                $this->_responseBody
            ) = $params;
        }

        if ( ! empty($this->_responseBody)) {
            $serialized = (new XmlSerializer())->unserialize($this->_responseBody);
            $this->_errorCode    = $serialized[Resources::XTAG_CODE];
            $this->_errorMessage = $serialized[Resources::XTAG_MESSAGE];
        }
        $this->code = $this->_responseCode;

        parent::__construct(
            sprintf(
                Resources::AZURE_ERROR_MSG,
                $this->_responseCode,
                $this->_responseCodeString,
                $this->_errorCode,
                $this->_errorMessage
            )
        );
    }
    
    /**
     * Gets error code.
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->_errorCode;
    }
    
    /**
     * Gets detailed error message.
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->_errorMessage;
    }

    /**
     * Gets the response code 
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->_responseCode;
    }

    /**
     * Gets the string value of the response code 
     *
     * @return string
     */
    public function getResponseCodeString()
    {
        return $this->_responseCodeString;
    }

    /**
     * Gets the response content
     *
     * @return string
     */
    public function getResponseBody()
    {
        return $this->_responseBody;
    }
}


