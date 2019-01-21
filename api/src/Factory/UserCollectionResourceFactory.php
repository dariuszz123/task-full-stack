<?php


namespace App\Factory;


use App\Model\UserCollection;
use App\Model\UserCollectionResource;
use Symfony\Component\Routing\RouterInterface;

class UserCollectionResourceFactory
{
    /** @var RouterInterface */
    protected $router;

    /**
     * UserCollectionResourceFactory constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function createFromUserCollection(UserCollection $collection): UserCollectionResource
    {
        return new UserCollectionResource(
            $collection->getUsers(),
            $this->getPage($collection),
            $this->getPrevUri($collection),
            $this->getNextUri($collection)
        );
    }

    private function getPrevUri(UserCollection $collection): ?string
    {
        if (!$collection->getOffset()) {
            return null;
        }

        $prevOffset = $collection->getOffset() - $collection->getLimit();

        if ($prevOffset < 0) {
            $prevOffset = 0;
        }

        return $this->router->generate('users_get_list', ['offset' => $prevOffset, 'limit' => $collection->getLimit()]);
    }

    private function getNextUri(UserCollection $collection): ?string
    {
        if (!$collection->getNextOffset()) {
            return null;
        }

        return $this->router->generate(
            'users_get_list',
            ['offset' => $collection->getNextOffset(), 'limit' => $collection->getLimit()]
        );
    }

    private function getPage(UserCollection $collection)
    {
        if (!$collection->getLimit() || !$collection->getOffset()) {
            return 1;
        }

        return ceil($collection->getOffset() / $collection->getLimit()) + 1;
    }
}