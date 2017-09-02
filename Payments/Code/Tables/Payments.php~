<?php

namespace Kopokopo\Payments\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payments
 *
 * @ORM\Table(name="kopokopo_payments")
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
     * @var string
     *
     * @ORM\Column(name="transaction_reference", type="string", length=255, nullable=true)
     */
    protected $transaction_reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", length=11, nullable=true)
     */
    protected $user_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", length=11, nullable=true)
     */
    protected $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_phone", type="string", length=255, nullable=true)
     */
    protected $sender_phone;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", length=11, nullable=true)
     */
    protected $created_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    protected $date_created;

    /**
     * @var integer
     *
     * @ORM\Column(name="modified_by", type="integer", length=11, nullable=true)
     */
    protected $modified_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     */
    protected $date_modified;


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
     * Set transactionReference
     *
     * @param string $transactionReference
     *
     * @return Payments
     */
    public function setTransactionReference($transactionReference)
    {
        $this->transaction_reference = $transactionReference;

        return $this;
    }

    /**
     * Get transactionReference
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->transaction_reference;
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Payments
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set senderPhone
     *
     * @param string $senderPhone
     *
     * @return Payments
     */
    public function setSenderPhone($senderPhone)
    {
        $this->sender_phone = $senderPhone;

        return $this;
    }

    /**
     * Get senderPhone
     *
     * @return string
     */
    public function getSenderPhone()
    {
        return $this->sender_phone;
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
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
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
     * Get dateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        // Add your code here
    }
}

