<?php

namespace Darkbluesun\GoldfishBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serial;

/**
 * Workspace
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serial\ExclusionPolicy("all")
 */
class Workspace
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @Serial\Expose()
     * @Serial\Groups({"client_list","client_details","project_list","project_details","task_list","task_details"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;

    /**
     * @var boolean
     *
     * @ORM\OneToMany(targetEntity="Client", mappedBy="workspace")
     */
    protected $clients;

    /**
     * @var boolean
     *
     * @ORM\OneToMany(targetEntity="Project", mappedBy="workspace")
     */
    protected $projects;

    /**
     * @var boolean
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="workspace")
     */
    protected $tasks;

    /**
     * @var boolean
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="workspace")
     */
    protected $comments;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="workspaces")
     */
    private $users;

    /**
     * Constructor function. Needed to initialise arrays of child objects
     */
    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Workspace
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
     * Set private
     *
     * @param boolean $private
     * @return Workspace
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Add clients
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Client $clients
     * @return Workspace
     */
    public function addClient(\Darkbluesun\GoldfishBundle\Entity\Client $clients)
    {
        $this->clients[] = $clients;

        return $this;
    }

    /**
     * Remove clients
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Client $clients
     */
    public function removeClient(\Darkbluesun\GoldfishBundle\Entity\Client $clients)
    {
        $this->clients->removeElement($clients);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Add projects
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Project $projects
     * @return Workspace
     */
    public function addProject(\Darkbluesun\GoldfishBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Project $projects
     */
    public function removeProject(\Darkbluesun\GoldfishBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add tasks
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Task $tasks
     * @return Workspace
     */
    public function addTask(\Darkbluesun\GoldfishBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Task $tasks
     */
    public function removeTask(\Darkbluesun\GoldfishBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Add comments
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Comment $comments
     * @return Workspace
     */
    public function addComment(\Darkbluesun\GoldfishBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\Comment $comments
     */
    public function removeComment(\Darkbluesun\GoldfishBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add users
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\User $users
     * @return Workspace
     */
    public function addUser(\Darkbluesun\GoldfishBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Darkbluesun\GoldfishBundle\Entity\User $users
     */
    public function removeUser(\Darkbluesun\GoldfishBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
