<?php

namespace Omnipay\AfterPay\Message;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class PurchaseResponse extends Response
{
    protected $liveScript = 'https://www.secure-afterpay.com.au/afterpay.js';
    protected $testScript = 'https://www-sandbox.secure-afterpay.com.au/afterpay.js';

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRedirectResponse()
    {
        $output = <<<EOF
<html>
<head>
    <title>Redirecting...</title>
    <script src="%s" async></script>
</head>
<body>
    <script>
    window.onload = function() {
        AfterPay.init();
        AfterPay.redirect({token: "%s"});
    };
    </script>
</body>
</html>
EOF;

        $output = sprintf($output, $this->getScriptUrl(), $this->getToken());

        return HttpResponse::create($output);
    }

    /**
     * @return string
     */
    public function getScriptUrl()
    {
        $request = $this->getRequest();

        if ($request instanceof PurchaseRequest && $request->getTestMode()) {
            return $this->testScript;
        }

        return $this->liveScript;
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
