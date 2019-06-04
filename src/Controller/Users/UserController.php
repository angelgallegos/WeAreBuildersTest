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
     * @Rest\Get("/user")
     *
     * @return Response
     */
    public function show()
    {
        $user = $this->userService->getCurrent();

        if(is_null($user)){

            return $this->handleView($this->view([], Response::HTTP_NOT_FOUND));
        }

        return $this->handleView($this->view($user, Response::HTTP_OK));
    }
}