<?php
/**
 * @package     Hosting
 * @subpackage  Services
 * @copyright   Copyright (C) 2025 Rameva.ru. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Rameva\Hosting\Services;

use Joomla\CMS\Uri\Uri;

\defined('_JEXEC') or die;

/**
 * Robokassa Service Class
 *
 * @since  1.0.0
 */
class RobokassaService
{
    /**
     * Merchant login
     *
     * @var    string
     * @since  1.0.0
     */
    protected $merchantLogin;

    /**
     * Password 1 (for signature generation)
     *
     * @var    string
     * @since  1.0.0
     */
    protected $password1;

    /**
     * Password 2 (for callback verification)
     *
     * @var    string
     * @since  1.0.0
     */
    protected $password2;

    /**
     * Test mode flag
     *
     * @var    bool
     * @since  1.0.0
     */
    protected $testMode;

    /**
     * Constructor
     *
     * @param   string  $merchantLogin  Merchant login
     * @param   string  $password1      Password 1
     * @param   string  $password2      Password 2
     * @param   bool    $testMode       Test mode
     *
     * @since   1.0.0
     */
    public function __construct($merchantLogin, $password1, $password2, $testMode = true)
    {
        $this->merchantLogin = $merchantLogin;
        $this->password1 = $password1;
        $this->password2 = $password2;
        $this->testMode = $testMode;
    }

    /**
     * Generate payment URL
     *
     * @param   float   $amount      Amount
     * @param   int     $invoiceId   Invoice ID
     * @param   string  $description Description
     * @param   array   $params      Additional parameters
     *
     * @return  string|false
     *
     * @since   1.0.0
     */
    public function generatePaymentUrl($amount, $invoiceId, $description, $params = [])
    {
        if (!$this->merchantLogin || !$this->password1) {
            return false;
        }

        $baseUrl = $this->testMode 
            ? 'https://auth.robokassa.ru/Merchant/Index.aspx'
            : 'https://auth.robokassa.ru/Merchant/Index.aspx';

        $paymentParams = [
            'MerchantLogin' => $this->merchantLogin,
            'OutSum' => number_format($amount, 2, '.', ''),
            'InvId' => $invoiceId,
            'Description' => $description,
            'Culture' => 'ru',
            'Encoding' => 'utf-8'
        ];

        // Add custom parameters
        foreach ($params as $key => $value) {
            if (strpos($key, 'Shp_') === 0) {
                $paymentParams[$key] = $value;
            }
        }

        // Generate signature
        $signatureString = $this->merchantLogin . ':' . $paymentParams['OutSum'] . ':' . $invoiceId . ':' . $this->password1;
        
        // Add custom parameters to signature
        ksort($paymentParams);
        foreach ($paymentParams as $key => $value) {
            if (strpos($key, 'Shp_') === 0) {
                $signatureString .= ':' . $value;
            }
        }

        $paymentParams['SignatureValue'] = md5($signatureString);

        if ($this->testMode) {
            $paymentParams['IsTest'] = 1;
        }

        return $baseUrl . '?' . http_build_query($paymentParams);
    }

    /**
     * Verify payment callback
     *
     * @param   array  $data  Callback data
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function verifyCallback($data)
    {
        if (!isset($data['OutSum'], $data['InvId'], $data['SignatureValue'])) {
            return false;
        }

        $signatureString = $data['OutSum'] . ':' . $data['InvId'] . ':' . $this->password2;

        // Add custom parameters to signature
        $customParams = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'Shp_') === 0) {
                $customParams[$key] = $value;
            }
        }

        ksort($customParams);
        foreach ($customParams as $value) {
            $signatureString .= ':' . $value;
        }

        $expectedSignature = strtoupper(md5($signatureString));
        $receivedSignature = strtoupper($data['SignatureValue']);

        return $expectedSignature === $receivedSignature;
    }

    /**
     * Verify result callback
     *
     * @param   array  $data  Result data
     *
     * @return  bool
     *
     * @since   1.0.0
     */
    public function verifyResult($data)
    {
        return $this->verifyCallback($data);
    }

    /**
     * Get payment status
     *
     * @param   int  $invoiceId  Invoice ID
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function getPaymentStatus($invoiceId)
    {
        $url = 'https://auth.robokassa.ru/Merchant/WebService/Service.asmx/OpState';
        
        $params = [
            'MerchantLogin' => $this->merchantLogin,
            'InvoiceID' => $invoiceId,
            'Signature' => md5($this->merchantLogin . ':' . $invoiceId . ':' . $this->password2)
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return false;
        }

        // Parse XML response
        $xml = simplexml_load_string($response);
        
        if ($xml === false) {
            return false;
        }

        return [
            'state' => (string) $xml->State,
            'state_code' => (int) $xml->StateCode
        ];
    }

    /**
     * Calculate commission
     *
     * @param   float   $amount  Amount
     * @param   string  $method  Payment method
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function calculateCommission($amount, $method = '')
    {
        $url = 'https://auth.robokassa.ru/Merchant/WebService/Service.asmx/CalcOutSumm';
        
        $params = [
            'MerchantLogin' => $this->merchantLogin,
            'IncCurrLabel' => $method,
            'IncSum' => $amount,
            'Signature' => md5($this->merchantLogin . ':' . $amount . ':' . $this->password2)
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return false;
        }

        // Parse XML response
        $xml = simplexml_load_string($response);
        
        if ($xml === false) {
            return false;
        }

        return [
            'out_sum' => (float) $xml->OutSum
        ];
    }

    /**
     * Get available payment methods
     *
     * @return  array|false
     *
     * @since   1.0.0
     */
    public function getPaymentMethods()
    {
        $url = 'https://auth.robokassa.ru/Merchant/WebService/Service.asmx/GetCurrencies';
        
        $params = [
            'MerchantLogin' => $this->merchantLogin,
            'Language' => 'ru'
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            ]
        ]);

        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return false;
        }

        // Parse XML response
        $xml = simplexml_load_string($response);
        
        if ($xml === false) {
            return false;
        }

        $methods = [];
        foreach ($xml->Groups->Group as $group) {
            foreach ($group->Items->Currency as $currency) {
                $methods[] = [
                    'code' => (string) $currency['Label'],
                    'name' => (string) $currency['Name'],
                    'min_sum' => (float) $currency['MinValue'],
                    'max_sum' => (float) $currency['MaxValue']
                ];
            }
        }

        return $methods;
    }
}