<?php

namespace EsportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 */
class Game
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $teams;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add teams
     *
     * @param \EsportBundle\Entity\Team $teams
     * @return Game
     */
    public function addTeam(\EsportBundle\Entity\Team $teams)
    {
        $this->teams[] = $teams;

        return $this;
    }

    /**
     * Remove teams
     *
     * @param \EsportBundle\Entity\Team $teams
     */
    public function removeTeam(\EsportBundle\Entity\Team $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $players;


    /**
     * Add players
     *
     * @param \EsportBundle\Entity\Players $players
     * @return Game
     */
    public function addPlayer(\EsportBundle\Entity\Player $players)
    {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     *
     * @param \EsportBundle\Entity\Players $players
     */
    public function removePlayer(\EsportBundle\Entity\Player $players)
    {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $consoles;


    /**
     * Add consoles
     *
     * @param \EsportBundle\Entity\Console $consoles
     * @return Game
     */
    public function addConsole(\EsportBundle\Entity\Console $consoles)
    {
        $this->consoles[] = $consoles;

        return $this;
    }

    /**
     * Remove consoles
     *
     * @param \EsportBundle\Entity\Console $consoles
     */
    public function removeConsole(\EsportBundle\Entity\Console $consoles)
    {
        $this->consoles->removeElement($consoles);
    }

    /**
     * Get consoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConsoles()
    {
        return $this->consoles;
    }
    /**
     * @var string
     */
    private $img;


    /**
     * Set img
     *
     * @param string $img
     * @return Game
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }
}
