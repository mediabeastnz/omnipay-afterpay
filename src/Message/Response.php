<?php

namespace Omnipay\AfterPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{

    /**
     * Response constructor.
     *
     * @param \Omnipay\Common\Message\RequestInterface $request
     * @param mixed                                    $data
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        if ($this->isRedirect()) {
            return false;
        }
        if (array_key_exists('errorCode', $this->data)) {
            return false;
        }
        return true;
    }

}
