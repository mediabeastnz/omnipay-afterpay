<?php

namespace Omnipay\AfterPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * Response constructor.
     *
     * @param \Omnipay\Common\Message\RequestInterface $request
     * @param mixed                                    $data
     */
    public function __construct(RequestInterface $request, $data, $statusCode)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if ($this->isRedirect()) {
            return false;
        }

        if ($this->isResponseHasError()) {
            return false;
        }

        return true;
    }

    protected function isResponseHasError()
    {
        return array_key_exists('errorCode', $this->data) || !$this->isStatusCodeValid();
    }

    protected function isStatusCodeValid()
    {
        return $this->getStatusCode() < 400;
    }

    public function getMessage()
    {
        if (isset($this->data['message'])) {
            return $this->data['message'];
        }

        if (!$this->isStatusCodeValid()) {
            return 'Afterpay returned an invalid status code. Please try again.';
        }

        return null;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string|null
     */
    public function getToken()
    {
        return isset($this->data['token']) ? $this->data['token'] : null;
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->getToken();
    }
}
