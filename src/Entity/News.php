<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $symlink;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_create;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_update;

    public function __construct()
    {
        $this->date_create = new \DateTime("now");
        $this->date_update = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSymlink(): ?string
    {
        return $this->symlink;
    }

    public function setSymlink(?string $symlink): self
    {
        $this->symlink = $symlink;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return (string)$this->date_update;
    }

    public function setDateUpdate(\DateTimeInterface $date_update): self
    {
        $this->date_update = new \DateTime("now");

        return $this;
    }

    /**
     * @return array
     */
    public function getAllValuesArrays(){
        $return[] = $this->getId();
        $return[] = $this->getActive();
        $return[] = $this->getTitle();
        $return[] = $this->getSymlink();
        $return[] = $this->getDescription();
        $return[] = $this->getDateCreate()->format('Y-m-d H:i:s');
        //$return[] = $this->getDateUpdate()->format('Y-m-d H:i:s');


        return $return;
    }

    /**
     * @return array
     */
    public function getAllNameValuesArrays(){
        $return[] = "Id";
        $return[] = "Active";
        $return[] = "Title";
        $return[] = "Symlink";
        $return[] = "Description";
        $return[] = "DateCreate";
        //$return[] = "DateUpdate";
        return $return;
    }
}
