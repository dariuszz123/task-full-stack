<?php

namespace App\Model;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

class UserCollectionResource
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
    protected $currentPage;

    /**
     * @var string|null
     *
     * @Groups("API_USER")
     */
    protected $prevUri;

    /**
     * @var string|null
     *
     * @Groups("API_USER")
     */
    protected $nextUri;

    /**
     * @param User[] $items
     * @param int $currentPage
     * @param string|null $prev
     * @param string|null $next
     */
    public function __construct(array $items, int $currentPage, ?string $prev, ?string $next)
    {
        $this->users = $items;
        $this->currentPage = $currentPage;
        $this->prevUri = $prev;
        $this->nextUri = $next;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return string|null
     */
    public function getPrevUri(): ?string
    {
        return $this->prevUri;
    }

    /**
     * @return string|null
     */
    public function getNextUri(): ?string
    {
        return $this->nextUri;
    }
}
