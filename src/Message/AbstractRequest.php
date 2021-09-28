<?php

namespace Omnipay\AfterPay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://api.afterpay.com/v1';
    protected $testEndpoint = 'https://api-sandbox.afterpay.com/v1';

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param mixed $value
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * @return mixed
     */
    public function getUserAgentPlatform()
    {
        return $this->getParameter('userAgentPlatform');
    }

    /**
     * @param mixed $value
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setUserAgentPlatform($value)
    {
        return $this->setParameter('userAgentPlatform', $value);
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->getParameter('countryCode');
    }

    /**
     * @param mixed $value
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setCountryCode($value)
    {
        return $this->setParameter('countryCode', $value);
    }

    /**
     * @return mixed
     */
    public function getUserAgentMerchantUrl()
    {
        return $this->getParameter('userAgentMerchantUrl');
    }

    /**
     * @param mixed $value
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setUserAgentMerchantUrl($value)
    {
        return $this->setParameter('userAgentMerchantUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getMerchantSecret()
    {
        return $this->getParameter('merchantSecret');
    }

    /**
     * @param mixed $value
     * @return $this
     * @throws \Omnipay\Common\Exception\RuntimeException
     */
    public function setMerchantSecret($value)
    {
        return $this->setParameter('merchantSecret', $value);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        return $headers;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function sendData($data)
    {
        $headers = [
            'User-Agent' => $this->getUserAgent(),
            'Authorization' => $this->buildAuthorizationHeader(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if ($this->getHttpMethod() == 'GET') {
            $httpResponse = $this->httpClient->request('GET', $this->getEndpoint() . '?' . http_build_query($data), $headers);
        } else {
            $httpResponse = $this->httpClient->request('POST',  $this->getEndpoint(), $headers, json_encode($data));
        }

        return $this->createResponse(json_decode((string) $httpResponse->getBody(), true), $httpResponse->getStatusCode());
    }

    public function toJSON($data, $options = 0)
    {
        if (version_compare(phpversion(), '5.4.0', '>=') === true) {
            return json_encode($data, $options | 64);
        }
        return str_replace('\\/', '/', json_encode($data, $options));
    }

    protected function createResponse($data, $status_code)
    {
        return $this->response = new Response($this, $data, $status_code);
    }

    protected function buildAuthorizationHeader()
    {
        $merchantId = $this->getMerchantId();
        $merchantSecret = $this->getMerchantSecret();

        return 'Basic ' . base64_encode($merchantId . ':' . $merchantSecret);
    }

    protected function getUserAgent() {

        $subinfo = [];

        // platform
        if ($platform = $this->getUserAgentPlatform()) {
            $subinfo[] = $platform;
        } else {
            $subinfo[] = 'Omnipay-Afterpay/3.0';
        }

        // php version
        $subinfo[] = 'PHP/'.PHP_VERSION;
        $subinfo[] = 'Merchant/'.$this->getMerchantId();

        return 'Omnipay-Afterpay ('.join('; ', $subinfo).')' . $this->getUserAgentMerchantUrl();
    }
}
