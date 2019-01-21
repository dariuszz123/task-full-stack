<?php

namespace App\Model;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class UserCollection
{
    /**
     * @var User[]
     *
     * @Groups("API_USER")
     */
    protected $users;

    /**
     * @var int
     *
     * @Groups("API_USER")
     */
    protected $limit;

    /**
     * @var int
     *
     * @Groups("API_USER")
     */
    protected $offset;

    /**
     * @var int|null
     *
     * @Groups("API_USER")
     */
    protected $nextOffset;

    /**
     * @param User[] $users
     * @param int $limit
     * @param int $offset
     * @param int $nextOffset
     */
    public function __construct(array $users, int $limit = 10, int $offset = 0, ?int $nextOffset = null)
    {
        $this->users = $users;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->nextOffset = $nextOffset;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getNextOffset(): ?int
    {
        return $this->nextOffset;
    }
}
