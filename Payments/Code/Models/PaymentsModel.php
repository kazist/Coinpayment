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

    public function checkMpesaCodeExist($mpesa_code) {

        $factory = new KazistFactory();

        $query = new Query();
        $query->select('kt.*');
        $query->from('#__coinpayment_transactions', 'kt');
        $query->where('kt.transaction_reference=:transaction_reference');
        $query->setParameter('transaction_reference', $mpesa_code);
        $record = $query->loadObject();

        if (is_object($record)) {
            if (!(int) $record->used) {
                return true;
            } else {
                $factory->enqueueMessage('The code [' . $mpesa_code . '] is already used.', 'error');
                return false;
            }
        } else {
            $factory->enqueueMessage('The code [' . $mpesa_code . '] Provided does not exist.', 'error');
            return false;
        }
    }

    public function processCoinpayment($payment_id, $mpesa_code) {

        $is_valid = true;

        $factory = new KazistFactory();

        $gateway = $this->getGatewayByName('coinpayment');

        $coinpayment_obj = $this->getCoinpaymentTransaction(trim($mpesa_code));
        $payment = $this->getPaymentById($payment_id);
        $deductions = json_decode($payment->deductions);
        $required_amount = ($deductions->amount) ? $deductions->amount : $payment->amount;
        $paid_amount = $coinpayment_amount = ($coinpayment_obj->amount) ? $coinpayment_obj->amount : '';

        // $paid_amount = $this->getConverterAmount($paid_amount, $gateway, false);
        //  $required_amount = $this->getConverterAmount($required_amount, $gateway, false);

        $payment->code = $mpesa_code;
        $payment->receipt_no = $payment->receipt_no;
        $payment->type = 'coinpayment';
        $payment->gateway_id = $gateway->id;

        if ($required_amount > $coinpayment_amount) {
            $paid_amount = $required_amount;
        }

        if (!is_object($coinpayment_obj)) {
            $factory->enqueueMessage('Mpesa Code (' . $mpesa_code . ') does not exist.', 'error');
            return false;
        }

        parent::savePaidAmount($payment, $required_amount, $paid_amount);

        if ($paid_amount < $required_amount) {
            $is_valid = false;
        }

        $this->saveCoinpaymentPayment($paid_amount, $mpesa_code,$coinpayment_obj->sender_phone);
        $this->updateCoinpayment($coinpayment_obj);

        return $is_valid;
    }

    public function saveCoinpaymentPayment($amount, $mpesa_code,$phone) {

        $factory = new KazistFactory();
        $user = $factory->getUser();

        $coinpayment_obj = new \stdClass();
        $coinpayment_obj->transaction_reference = $mpesa_code;
        $coinpayment_obj->user_id = $user->id;
        $coinpayment_obj->sender_phone = $phone;
        $coinpayment_obj->amount = $amount;

        $factory->saveRecord('#__coinpayment_payments', $coinpayment_obj);
    }

    public function updateCoinpayment($coinpayment_obj) {

        $factory = new KazistFactory();
        $user = $factory->getUser();

        $coinpayment_obj->used = 1;
        $coinpayment_obj->date_used = date('Y-m-d H:i:s');
        $coinpayment_obj->used_by = $user->id;

        $factory->saveRecord('#__coinpayment_transactions', $coinpayment_obj);
    }

    public function getCoinpaymentTransaction($mpesa_code) {

        $query = new Query();
        $query->select('kt.*');
        $query->from('#__coinpayment_transactions', 'kt');
        $query->where('kt.transaction_reference=:transaction_reference');
        $query->setParameter('transaction_reference', $mpesa_code);

        $record = $query->loadObject();

        return $record;
    }

}
