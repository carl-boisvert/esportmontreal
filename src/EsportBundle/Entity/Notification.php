<?php

namespace EsportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 */
class Notification
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $sent;

    /**
     * @var \EsportBundle\Entity\Player
     */
    private $sender;

    /**
     * @var \EsportBundle\Entity\Game
     */
    private $game;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $recipients;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipients = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set type
     *
     * @param string $type
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sent
     *
     * @param \DateTime $sent
     * @return Notification
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return \DateTime 
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Set sender
     *
     * @param \EsportBundle\Entity\Player $sender
     * @return Notification
     */
    public function setSender(\EsportBundle\Entity\Player $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \EsportBundle\Entity\Player 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set game
     *
     * @param \EsportBundle\Entity\Game $game
     * @return Notification
     */
    public function setGame(\EsportBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \EsportBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Add recipients
     *
     * @param \EsportBundle\Entity\NotificationInfos $recipients
     * @return Notification
     */
    public function addRecipient(\EsportBundle\Entity\NotificationInfos $recipients)
    {
        $this->recipients[] = $recipients;

        return $this;
    }

    /**
     * Remove recipients
     *
     * @param \EsportBundle\Entity\NotificationInfos $recipients
     */
    public function removeRecipient(\EsportBundle\Entity\NotificationInfos $recipients)
    {
        $this->recipients->removeElement($recipients);
    }

    /**
     * Get recipients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipients()
    {
        return $this->recipients;
    }
}
