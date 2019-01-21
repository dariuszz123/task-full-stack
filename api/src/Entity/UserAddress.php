<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 */
class UserAddress
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="address")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups("API_USER")
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("API_USER")
     */
    private $suite;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups("API_USER")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @SerializedName("zipcode")
     *
     * @Groups("API_USER")
     */
    private $zipCode;

    /**
     * @ORM\OneToOne(targetEntity="UserAddressGeo", mappedBy="address", cascade={"persist", "remove"})
     *
     * @Groups("API_USER")
     */
    private $geo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getSuite(): ?string
    {
        return $this->suite;
    }

    public function setSuite(?string $suite): self
    {
        $this->suite = $suite;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getGeo(): ?UserAddressGeo
    {
        return $this->geo;
    }

    public function setGeo(?UserAddressGeo $geo): self
    {
        if ($geo) {
            $geo->setAddress($this);
        }

        $this->geo = $geo;

        return $this;
    }

}
