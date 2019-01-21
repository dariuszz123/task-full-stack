<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\UserCollectionResourceFactory;
use App\Form\UserType;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends AbstractFOSRestController
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var UserRepository */
    protected $userRepository;

    /** @var UserCollectionResourceFactory */
    protected $collectionFactory;

    /** @var RegistryInterface */
    protected $doctrine;

    /**
     * UsersController constructor.
     * @param FormFactoryInterface $formFactory
     * @param UserRepository $userRepository
     * @param UserCollectionResourceFactory $collectionFactory
     * @param RegistryInterface $doctrine
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        UserRepository $userRepository,
        UserCollectionResourceFactory $collectionFactory,
        RegistryInterface $doctrine
    ) {
        $this->formFactory = $formFactory;
        $this->userRepository = $userRepository;
        $this->collectionFactory = $collectionFactory;
        $this->doctrine = $doctrine;
    }

    /**
     * @Rest\Post(name="users_create", path="/users", options={"method_prefix"=false})
     * @Rest\View(serializerGroups={"API_USER"})
     */
    public function createUserAction(Request $request)
    {
        $user = new User();
        $form = $this->formFactory->create(UserType::class, $user);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $form;
        }

        $manager = $this->doctrine->getManager();
        $manager->persist($user);
        $manager->flush();

        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get(name="users_get", path="/users/{id}", options={"method_prefix"=false})
     * @Rest\View(serializerGroups={"API_USER"})
     */
    public function getUserAction(int $id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return $user;
    }

    /**
     * @Rest\Get(name="users_get_list", path="/users", options={"method_prefix"=false})
     * @Rest\View(serializerGroups={"API_USER"})
     */
    public function getUsersAction(Request $request)
    {
        $offset = (int)$request->query->get('offset', 0);
        $limit = (int)$request->query->get('limit', 100);

        return $this->collectionFactory->createFromUserCollection(
            $this->userRepository->findCollection($limit, $offset)
        );
    }

    /**
     * @Rest\Patch(name="users_update", path="/users/{id}", options={"method_prefix"=false})
     * @Rest\View(serializerGroups={"API_USER"})
     */
    public function updateUserAction(Request $request, $id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $form = $this->formFactory->create(UserType::class, $user, ['method' => 'PATCH']);
        $form->submit($request->request->all(), false);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $form;
        }

        $this->doctrine->getManager()->flush();

        return View::create($user, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete(name="users_delete", path="/users/{id}", options={"method_prefix"=false})
     * @Rest\View(serializerGroups={"API_USER"})
     */
    public function deleteUserAction(int $id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException();
        }

        $manager = $this->doctrine->getManager();
        $manager->remove($user);
        $manager->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
