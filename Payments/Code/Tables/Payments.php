<?php

namespace Coinpayment\Payments\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payments
 *
 * @ORM\Table(name="coinpayment_payments", indexes={@ORM\Index(name="modified_by_index", columns={"modified_by"}), @ORM\Index(name="created_by_index", columns={"created_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Payments extends \Kazist\Table\BaseTable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="payment_id", type="integer", length=11)
     */
    protected $payment_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", length=11)
     */
    protected $user_id;

    /**
     * @var string
     *
     * @ORM\Column(name="txn_id", type="string", length=255, nullable=false)
     */
    protected $txn_id;

    /**
     * @var string
     *
     * @ORM\Column(name="item_name", type="string", length=255, nullable=false)
     */
    protected $item_name;

    /**
     * @var string
     *
     * @ORM\Column(name="item_number", type="string", length=255, nullable=false)
     */
    protected $item_number;

    /**
     * @var string
     *
     * @ORM\Column(name="amount1", type="string", length=255, nullable=false)
     */
    protected $amount1;

    /**
     * @var string
     *
     * @ORM\Column(name="amount2", type="string", length=255, nullable=false)
     */
    protected $amount2;

    /**
     * @var string
     *
     * @ORM\Column(name="currency1", type="string", length=255, nullable=false)
     */
    protected $currency1;

    /**
     * @var string
     *
     * @ORM\Column(name="currency2", type="string", length=255, nullable=false)
     */
    protected $currency2;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="status_text", type="string", length=255, nullable=false)
     */
    protected $status_text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     */
    protected $date_modified;

    /**
     * @var integer
     *
     * @ORM\Column(name="modified_by", type="integer", length=11, nullable=true)
     */
    protected $modified_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    protected $date_created;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", length=11, nullable=true)
     */
    protected $created_by;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set paymentId
     *
     * @param integer $paymentId
     *
     * @return Payments
     */
    public function setPaymentId($paymentId)
    {
        $this->payment_id = $paymentId;

        return $this;
    }

    /**
     * Get paymentId
     *
     * @return integer
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Payments
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set txnId
     *
     * @param string $txnId
     *
     * @return Payments
     */
    public function setTxnId($txnId)
    {
        $this->txn_id = $txnId;

        return $this;
    }

    /**
     * Get txnId
     *
     * @return string
     */
    public function getTxnId()
    {
        return $this->txn_id;
    }

    /**
     * Set itemName
     *
     * @param string $itemName
     *
     * @return Payments
     */
    public function setItemName($itemName)
    {
        $this->item_name = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * Set itemNumber
     *
     * @param string $itemNumber
     *
     * @return Payments
     */
    public function setItemNumber($itemNumber)
    {
        $this->item_number = $itemNumber;

        return $this;
    }

    /**
     * Get itemNumber
     *
     * @return string
     */
    public function getItemNumber()
    {
        return $this->item_number;
    }

    /**
     * Set amount1
     *
     * @param string $amount1
     *
     * @return Payments
     */
    public function setAmount1($amount1)
    {
        $this->amount1 = $amount1;

        return $this;
    }

    /**
     * Get amount1
     *
     * @return string
     */
    public function getAmount1()
    {
        return $this->amount1;
    }

    /**
     * Set amount2
     *
     * @param string $amount2
     *
     * @return Payments
     */
    public function setAmount2($amount2)
    {
        $this->amount2 = $amount2;

        return $this;
    }

    /**
     * Get amount2
     *
     * @return string
     */
    public function getAmount2()
    {
        return $this->amount2;
    }

    /**
     * Set currency1
     *
     * @param string $currency1
     *
     * @return Payments
     */
    public function setCurrency1($currency1)
    {
        $this->currency1 = $currency1;

        return $this;
    }

    /**
     * Get currency1
     *
     * @return string
     */
    public function getCurrency1()
    {
        return $this->currency1;
    }

    /**
     * Set currency2
     *
     * @param string $currency2
     *
     * @return Payments
     */
    public function setCurrency2($currency2)
    {
        $this->currency2 = $currency2;

        return $this;
    }

    /**
     * Get currency2
     *
     * @return string
     */
    public function getCurrency2()
    {
        return $this->currency2;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Payments
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set statusText
     *
     * @param string $statusText
     *
     * @return Payments
     */
    public function setStatusText($statusText)
    {
        $this->status_text = $statusText;

        return $this;
    }

    /**
     * Get statusText
     *
     * @return string
     */
    public function getStatusText()
    {
        return $this->status_text;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }

    /**
     * Get modifiedBy
     *
     * @return integer
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        // Add your code here
    }
}

