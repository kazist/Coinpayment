<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of TransactionsController
 *
 * @author sbc
 */

namespace Coinpayment\Transactions\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Controller\BaseController;

class TransactionsController extends BaseController {

    public function listenerAction() {

        $factory = new KazistFactory();

        $this->model->syncCoinpaymentTransactions();

        $data = array(
            "status" => "01",
            "description" => "Accepted",
            "subscriber_message" => $factory->getSetting("coinpayment_listener_response_message")
        );

        return $this->json($data);
    }

}
