<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
class UserAddressGeo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="UserAddress", inversedBy="geo")
     * @ORM\JoinColumn(name="user_address_id", referencedColumnName="id", nullable=false)
     */
    private $address;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=8, nullable=true)
     *
     * @Groups("API_USER")
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=8, nullable=true)
     *
     * @Groups("API_USER")
     */
    private $lng;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?UserAddress
    {
        return $this->address;
    }

    public function setAddress(?UserAddress $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setLat($lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng()
    {
        return $this->lng;
    }

    public function setLng($lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
