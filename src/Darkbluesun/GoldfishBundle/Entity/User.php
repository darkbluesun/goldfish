<?php

namespace Darkbluesun\GoldfishBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Workspace", mappedBy="users")
     */
    protected $workspaces;

    /**
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="assignee")
     */
    protected $tasks;

    /**
     * @ORM\OneToMany(targetEntity="TimeEntry", mappedBy="user")
     */
    protected $timeEntries;


    public function __construct()
    {
        parent::__construct();
        $this->tasks = new ArrayCollection();
        $this->workspaces = new ArrayCollection();
        $this->timeEntries = new ArrayCollection();
    }

    public function getFirstName() {
        return $this->firstName;
    }
    public function setFirstName($value) {
        $this->firstName = $value;
        return $this;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function setLastName($value) {
        $this->lastName = $value;
        return $this;
    }
    public function getName() {
        return $this->firstName.($this->lastName?' '.$this->lastName:'');
    }

    /**
     * Add workspace
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Workspace $workspace
     * @return User
     */
    public function addWorkspace(\Darkbluesun\GoldfishBundle\Entity\Workspace $workspace)
    {
        $this->workspaces[] = $workspace;

        return $this;
    }

    /**
     * Remove workspace
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Workspace $workspace
     */
    public function removeWorkspace(\Darkbluesun\GoldfishBundle\Entity\Workspace $workspace)
    {
        $this->workspaces->removeElement($workspace);
    }

    /**
     * Get workspaces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWorkspaces()
    {
        return $this->workspaces;
    }

    public function getWorkspace() {
        return $this->workspaces[0];
    }

    public function __toString() {
        return $this->firstName ? : $this->username;
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
     * Set image
     *
     * @param string $image
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add timeEntries
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\TimeEntry $timeEntries
     * @return User
     */
    public function addTimeEntry(\Darkbluesun\GoldfishBundle\Entity\TimeEntry $timeEntries)
    {
        $this->timeEntries[] = $timeEntries;

        return $this;
    }

    /**
     * Remove timeEntries
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\TimeEntry $timeEntries
     */
    public function removeTimeEntry(\Darkbluesun\GoldfishBundle\Entity\TimeEntry $timeEntries)
    {
        $this->timeEntries->removeElement($timeEntries);
    }

    /**
     * Get timeEntries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTimeEntries()
    {
        return $this->timeEntries;
    }
}
