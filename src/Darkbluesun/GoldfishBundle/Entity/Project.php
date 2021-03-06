<?php

namespace Darkbluesun\GoldfishBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use JMS\Serializer\Annotation as Serial;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ProjectRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Project
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @Serial\Groups({"project_list","project_details","client_details","task_list","task_details"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Serial\Groups({"project_list","project_details","client_details","task_list","task_details"})
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @Serial\Type("DateTime<'Y-m-d\TH:i:s.uO'>")
     * @Serial\Groups({"project_list","project_details","client_details","client_details"})
     * @ORM\Column(name="due_date", type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var integer
     *
     * @Serial\Groups({"project_list","project_details","client_details"})
     * @ORM\Column(name="budget", type="integer")
     */
    private $budget;

    /**
     * @var string
     *
     * @Serial\Groups({"project_details", "project_list"})
     * @ORM\ManyToOne(targetEntity="Workspace",inversedBy="projects")
     * @ORM\JoinColumn(name="workspace_id",referencedColumnName="id")
     * @Serial\Type("Darkbluesun\GoldfishBundle\Entity\Workspace")
     */
    protected $workspace;

    /**
     * @Serial\Groups({"project_list", "project_details"})
     * @ORM\ManyToOne(targetEntity="Client",inversedBy="projects")
     * @ORM\JoinColumn(name="client_id",referencedColumnName="id", onDelete="SET NULL")
     * @Serial\Type("Darkbluesun\GoldfishBundle\Entity\Client")
     */
    protected $client;

    /**
     * @Serial\Groups({"project_details"})
     * @ORM\OneToMany(targetEntity="Task", mappedBy="project")
     * @Serial\Type("Darkbluesun\GoldfishBundle\Entity\Task")
     */
    protected $tasks;

    /**
     * @Serial\Groups({"project_details"})
     * @ORM\OneToMany(targetEntity="ProjectComment", mappedBy="project")
     * @Serial\Type("Darkbluesun\GoldfishBundle\Entity\ProjectComment")
     */
    protected $comments;

    /**
     * @Serial\Groups({"project_details"})
     * @ORM\OneToMany(targetEntity="TimeEntry", mappedBy="project")
     * @Serial\Type("Darkbluesun\GoldfishBundle\Entity\TimeEntry")
     */
    protected $timeEntries;

    /**
     * Constructor function. Needed to initialise arrays of child objects
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->timeEntries = new ArrayCollection();
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
     * @return Project
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
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Project
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set budget
     *
     * @param integer $budget
     * @return Project
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return integer 
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set workspace
     *
     * @param Workspace $workspace
     * @return Project
     */
    public function setWorkspace(Workspace $workspace = null)
    {
        $this->workspace = $workspace;

        return $this;
    }

    /**
     * Get workspace
     *
     * @return Workspace 
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Set client
     *
     * @param Client $client
     * @return Project
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add task.
     *
     * @param Task $task
     *
     * @return Project
     */
    public function addTask(Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setProject($this);
        }

        return $this;
    }

    /**
     * Remove task.
     *
     * @param Task $task
     *
     * @return Project
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks.
     *
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Add comment.
     *
     * @param ProjectComment $comment
     *
     * @return Project
     */
    public function addComment(ProjectComment $comment)
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProject($this);
        }

        return $this;
    }

    /**
     * Remove comment.
     *
     * @param ProjectComment $comment
     *
     * @return Project
     */
    public function removeComment(ProjectComment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments.
     *
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * Add timeEntry
     *
     * @param TimeEntry $timeEntry
     *
     * @return Project
     */
    public function addTimeEntry(TimeEntry $timeEntry)
    {
        $this->timeEntries->add($timeEntry);
        $timeEntry->setProject($this);

        return $this;
    }

    /**
     * Remove timeEntry
     *
     * @param TimeEntry $timeEntry
     *
     * @return Project
     */
    public function removeTimeEntry(TimeEntry $timeEntry)
    {
        $this->timeEntries->removeElement($timeEntry);

        return $this;
    }

    /**
     * Get timeEntries
     *
     * @return ArrayCollection
     */
    public function getTimeEntries()
    {
        return $this->timeEntries;
    }
}
