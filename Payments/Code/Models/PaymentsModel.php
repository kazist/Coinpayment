<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Coinpayment\Payments\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Payments\Payments\Code\Models\PaymentsModel AS BasePaymentsModel;
use Kazist\Service\Email\Email;
use Kazist\Service\Database\Query;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class PaymentsModel extends BasePaymentsModel {

    public $code = '';

    public function appendSearchQuery($query) {

        $this->ingore_search_query = true;
        return parent:: appendSearchQuery($query);
    }

    public function notificationTransaction($payment_id) {
        $this->processCoinpayment($payment_id);
    }

    public function completeTransaction($payment_id) {
        $this->notificationTransaction($payment_id);
    }

    public function cancelTransaction($payment_id) {
        parent::cancelTransaction($payment_id);
    }

    public function getUrlByPaymentId() {

        $factory = new KazistFactory();

        return $this->generateUrl('affiliates.affiliates');
    }

    public function processCoinpayment($payment_id) {

        $is_valid = false;
        $order_currency = 'USD';

        $factory = new KazistFactory();

        // Fill these in with the information from your CoinPayments.net account.
        $cp_merchant_id = $factory->getSetting('coinpayment_merchant');
        $cp_ipn_secret = $factory->getSetting('coinpayment_merchant_ipn_secret_key');

        $payment = $this->getPayment($payment_id);
        $gateway = $this->getGatewayByShortName('coinpayment');

        //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field.
        $deductions = json_decode($payment->deductions);
        $required_amount = (isset($deductions->amount) && $deductions->amount) ? $deductions->amount : $payment->amount;

        $order_total = $paid_amount = $payment->amount;

        if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') {
            errorAndDie('IPN Mode is not HMAC');
        }

        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            errorAndDie('No HMAC signature sent.');
        }

        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
            errorAndDie('Error reading POST data');
        }

        if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) {
            errorAndDie('No or incorrect Merchant ID passed');
        }

        $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret));
        if ($hmac != $_SERVER['HTTP_HMAC']) {
            errorAndDie('HMAC signature does not match');
        }

        // HMAC Signature verified at this point, load some variables.

        $data['payment_id'] = $payment_id;
        $data['txn_id'] = $_POST['txn_id'];
        $data['item_name'] = $_POST['item_name'];
        $data['item_number'] = $_POST['item_number'];
        $data['amount1'] = floatval($_POST['amount1']);
        $data['amount2'] = floatval($_POST['amount2']);
        $data['currency1'] = $_POST['currency1'];
        $data['currency2'] = $_POST['currency2'];
        $data['status'] = intval($_POST['status']);
        $data['status_text'] = $_POST['status_text'];

        $paid_amount = (isset($data['amount1']) && $data['amount1']) ? $data['amount1'] : 0;

        if (!$payment->successful) {
            
            $factory->saveRecord('#__coinpayment_payments', $data, array('payment_id=:payment_id'), array('payment_id' => $payment_id));

            if ($data['status'] >= 100 || $data['status'] == 2) {
                // payment is complete or queued for nightly payout, success

                $payment->type = 'coinpayment';
                $payment->gateway_id = $gateway->id;
                $payment->code = $data['txn_id'];
                $payment->receipt_no = $payment->receipt_no;

                parent::savePaidAmount($payment, $required_amount, $paid_amount);

                if ($paid_amount >= $required_amount) {
                    parent::successfulTransaction($payment_id, $this->code);
                } else {
                    parent::failTransaction($payment_id);
                }

                $is_valid = false;
            } else if ($data['status'] < 0) {
                //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent

                $is_valid = false;
                parent::failTransaction($payment_id);
            } else {
                //payment is pending, you can optionally add a note to the order page

                $is_valid = false;
                parent::pendingTransaction($payment_id);
            }
        }

        return $is_valid;
    }

}
