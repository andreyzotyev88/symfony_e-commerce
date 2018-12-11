<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $role = $this->roles;
        if($role) {
            $roles[] = $role->getName();
            return array_unique($roles);
        }else{
            return array_unique(["ROLE_USER"]);
        }
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAllValuesArrays(){
        $return[] = $this->getId();
        $return[] = $this->getUsername();
        $return[] = $this->getFio();
        $return[] = $this->getEmail();
        $return[] = $this->getPhone();
        $return[] = $this->getRolesEntity();
        return $return;
    }

    public function getRolesEntity(): string {
        if($this->roles) {
            return $this->roles->getName();
        }else{
            return "ROLE_USER";
        }
    }

    public function getAllNameValuesArrays(){
        $return[] = "Id";
        $return[] = "Name";
        $return[] = "FIO";
        $return[] = "email";
        $return[] = "phone";
        $return[] = "role";
        return $return;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFio(): ?string
    {
        return $this->fio;
    }

    public function setFio(?string $fio): self
    {
        $this->fio = $fio;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function setRoles(?Roles $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
