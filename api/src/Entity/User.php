<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups("API_USER")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("API_USER")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups("API_USER")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("API_USER")
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="UserAddress", mappedBy="user", cascade={"persist", "remove"})
     *
     * @Groups("API_USER")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("API_USER")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("API_USER")
     */
    private $website;

    /**
     * @ORM\OneToOne(targetEntity="UserCompany", mappedBy="user", cascade={"persist", "remove"})
     *
     * @Groups("API_USER")
     */
    private $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getAddress(): ?UserAddress
    {
        return $this->address;
    }

    public function setAddress(?UserAddress $address): self
    {
        if ($address) {
            $address->setUser($this);
        }

        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getCompany(): ?UserCompany
    {
        return $this->company;
    }

    public function setCompany(?UserCompany $company): self
    {
        if ($company) {
            $company->setUser($this);
        }

        $this->company = $company;

        return $this;
    }

}
