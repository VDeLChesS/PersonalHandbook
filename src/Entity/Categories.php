<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, SuggestedTasks>
     */
    #[ORM\OneToMany(targetEntity: SuggestedTasks::class, mappedBy: 'category')]
    private Collection $suggestedTasks;

    /**
     * @var Collection<int, Tasks>
     */
    #[ORM\OneToMany(targetEntity: Tasks::class, mappedBy: 'category')]
    private Collection $tasks;

    /**
     * @var Collection<int, MyNotes>
     */
    #[ORM\OneToMany(targetEntity: MyNotes::class, mappedBy: 'category')]
    private Collection $myNotes;

    /**
     * @var Collection<int, Events>
     */
    #[ORM\OneToMany(targetEntity: Events::class, mappedBy: 'category')]
    private Collection $events;

    /**
     * @var Collection<int, Appointments>
     */
    #[ORM\OneToMany(targetEntity: Appointments::class, mappedBy: 'category')]
    private Collection $appointments;

    public function __construct()
    {
        $this->suggestedTasks = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->myNotes = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, SuggestedTasks>
     */
    public function getSuggestedTasks(): Collection
    {
        return $this->suggestedTasks;
    }

    public function addSuggestedTask(SuggestedTasks $suggestedTask): static
    {
        if (!$this->suggestedTasks->contains($suggestedTask)) {
            $this->suggestedTasks->add($suggestedTask);
            $suggestedTask->setCategory($this);
        }

        return $this;
    }

    public function removeSuggestedTask(SuggestedTasks $suggestedTask): static
    {
        if ($this->suggestedTasks->removeElement($suggestedTask)) {
            // set the owning side to null (unless already changed)
            if ($suggestedTask->getCategory() === $this) {
                $suggestedTask->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Tasks $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setCategory($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getCategory() === $this) {
                $task->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MyNotes>
     */
    public function getMyNotes(): Collection
    {
        return $this->myNotes;
    }

    public function addMyNote(MyNotes $myNote): static
    {
        if (!$this->myNotes->contains($myNote)) {
            $this->myNotes->add($myNote);
            $myNote->setCategory($this);
        }

        return $this;
    }

    public function removeMyNote(MyNotes $myNote): static
    {
        if ($this->myNotes->removeElement($myNote)) {
            // set the owning side to null (unless already changed)
            if ($myNote->getCategory() === $this) {
                $myNote->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setCategory($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCategory() === $this) {
                $event->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Appointments>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointments $appointment): static
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setCategory($this);
        }

        return $this;
    }

    public function removeAppointment(Appointments $appointment): static
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getCategory() === $this) {
                $appointment->setCategory(null);
            }
        }

        return $this;
    }
}
