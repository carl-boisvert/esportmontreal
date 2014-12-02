<?php

namespace EsportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationInfos
 */
class NotificationInfos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $isRead;

    /**
     * @var \DateTime
     */
    private $readTime;

    /**
     * @var \EsportBundle\Entity\Player
     */
    private $player;


    public function __construct(){
        $this->isRead = false;
        $this->readTime = new \DateTime();
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
     * Set isRead
     *
     * @param boolean $isRead
     * @return NotificationInfos
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean 
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set readTime
     *
     * @param \DateTime $readTime
     * @return NotificationInfos
     */
    public function setReadTime($readTime)
    {
        $this->readTime = $readTime;

        return $this;
    }

    /**
     * Get readTime
     *
     * @return \DateTime 
     */
    public function getReadTime()
    {
        return $this->readTime;
    }

    /**
     * Set player
     *
     * @param \EsportBundle\Entity\Player $player
     * @return NotificationInfos
     */
    public function setPlayer(\EsportBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \EsportBundle\Entity\Player 
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
