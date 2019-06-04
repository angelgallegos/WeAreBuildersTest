<?php


namespace App\Controller\Users;


use App\Controller\BaseController;
use App\Entity\User\User;
use App\Form\User\RegistrationFormType;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * User controller.
 *
 * @author Ángel Gallegos Andrade
 *
 * @Route("/user", name="register_")
 */
class RegisterController extends BaseController
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Creates a user.
     *
     * @Rest\Post("/register")
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userService->save($user);

            return $this->handleView($this->view($user, Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($this->getErrorsMessages($form), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}