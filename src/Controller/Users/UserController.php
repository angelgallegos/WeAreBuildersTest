<?php


namespace App\Controller\Users;

use App\Controller\BaseController;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User\User;
use App\Form\User\UserType;

/**
 * User controller.
 *
 * @author Ángel Gallegos Andrade
 *
 * @Route("/api", name="api_")
 */
class UserController extends BaseController
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Lists all users.
     *
     * @Rest\Get("/user/{id}")
     *
     * @param int id
     *
     * @return Response
     */
    public function show(int $id)
    {
        $user = $this->userService->get($id);

        if(is_null($user)){

            return $this->handleView($this->view([], Response::HTTP_NOT_FOUND));
        }

        return $this->handleView($this->view($user, Response::HTTP_OK));
    }

    /**
     * Updates a user
     *
     * @Rest\Put("/user/{id}")
     *
     * @param int $id
     * @param Request $request
     *
     * @return mixed
    */
    public function update(int $id, Request $request)
    {
        $user = $this->userService->get($id);

        if(is_null($user)){

            return $this->handleView($this->view([], Response::HTTP_NOT_FOUND));
        }

        $form = $this->createForm(UserType::class, $user);

        $data = $this->userService->update($user, $request->request->all());

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userService->save($user);

            return $this->handleView($this->view($user, Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($this->getErrorsMessages($form), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}