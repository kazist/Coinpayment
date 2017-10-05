<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Coinpayment\Transactions\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Kazist\Service\Email\Email;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class TransactionsModel extends BaseModel {

    public function syncCoinpaymentTransactions() {

        $factory = new KazistFactory();

        $content = json_decode($this->request->getContent());

        $exist = new \stdClass();
        $exist->transaction_reference = $content->transaction_reference;

        $content->name = $content->first_name . ' ' . $content->middle_name . ' ' . $content->last_name;

        $factory->saveRecord('#__coinpayment_transactions', $content, array('transaction_reference=:transaction_reference'), $exist);
    }

}
