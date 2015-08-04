<?php
/**
 * MQMailQueue
 * Copyright (c) 2014 Milq Media.
 *
 * @author      Johan Kuijt <johan@milq.nl>
 * @copyright   2014 Milq Media.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://milq.nl
 */

namespace MQMailQueueTest\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mailQueue")
 *
 */
class MailQueue
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
     * @var integer
     * @ORM\Column(type="integer", length=1)
     */
    protected $prio;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $send;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $recipientName;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $recipientEmail;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $senderName;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $senderEmail;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $subject;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $bodyHTML;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $bodyText;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $error;
    
    /**
     * @var date
     * @ORM\Column(type="datetime", length=100)
     */
    protected $createDate;
    
    /**
     * @var date
     * @ORM\Column(type="datetime")
     */
    protected $scheduleDate;
    
    /**
     * @var date
     * @ORM\Column(type="datetime", length=100, nullable=true)
     */
    protected $sendDate;

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
     * Set prio
     *
     * @param integer $prio
     * @return MailQueue
     */
    public function setPrio($prio)
    {
        $this->prio = $prio;

        return $this;
    }

    /**
     * Get prio
     *
     * @return integer 
     */
    public function getPrio()
    {
        return $this->prio;
    }

    /**
     * Set send
     *
     * @param boolean $send
     * @return MailQueue
     */
    public function setSend($send)
    {
        $this->send = $send;

        return $this;
    }

    /**
     * Get send
     *
     * @return boolean 
     */
    public function getSend()
    {
        return $this->send;
    }

    /**
     * Set recipientName
     *
     * @param string $recipientName
     * @return MailQueue
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * Get recipientName
     *
     * @return string 
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * Set recipientEmail
     *
     * @param string $recipientEmail
     * @return MailQueue
     */
    public function setRecipientEmail($recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;

        return $this;
    }

    /**
     * Get recipientEmail
     *
     * @return string 
     */
    public function getRecipientEmail()
    {
        return $this->recipientEmail;
    }

    /**
     * Set senderName
     *
     * @param string $senderName
     * @return MailQueue
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }

    /**
     * Get senderName
     *
     * @return string 
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * Set senderEmail
     *
     * @param string $senderEmail
     * @return MailQueue
     */
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;

        return $this;
    }

    /**
     * Get senderEmail
     *
     * @return string 
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return MailQueue
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set bodyHTML
     *
     * @param string $bodyHTML
     * @return MailQueue
     */
    public function setBodyHTML($bodyHTML)
    {
        $this->bodyHTML = $bodyHTML;

        return $this;
    }

    /**
     * Get bodyHTML
     *
     * @return string 
     */
    public function getBodyHTML()
    {
        return $this->bodyHTML;
    }

    /**
     * Set bodyText
     *
     * @param string $bodyText
     * @return MailQueue
     */
    public function setBodyText($bodyText)
    {
        $this->bodyText = $bodyText;

        return $this;
    }

    /**
     * Get bodyText
     *
     * @return string 
     */
    public function getBodyText()
    {
        return $this->bodyText;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return MailQueue
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set sendDate
     *
     * @param \DateTime $sendDate
     * @return MailQueue
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;

        return $this;
    }

    /**
     * Get sendDate
     *
     * @return \DateTime 
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * Set error
     *
     * @param string $error
     * @return MailQueue
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return string 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set scheduleDate
     *
     * @param \DateTime $scheduleDate
     *
     * @return MailQueue
     */
    public function setScheduleDate($scheduleDate)
    {
        $this->scheduleDate = $scheduleDate;

        return $this;
    }

    /**
     * Get scheduleDate
     *
     * @return \DateTime
     */
    public function getScheduleDate()
    {
        return $this->scheduleDate;
    }
}
