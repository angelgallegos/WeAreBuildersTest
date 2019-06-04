<?php

namespace App\Controller\Follow;

use App\Controller\BaseController;
use App\Entity\Follow\Follower;
use App\Form\Follow\FollowerType;
use App\Service\Follow\FollowerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * User controller.
 *
 * @author Ángel Gallegos Andrade
 *
 * @Route("/api", name="api_")
 */
class FollowerController extends BaseController
{
    private $followerService;

    private $tokenStorageService;

    public function __construct(FollowerService $followerService, TokenStorageInterface $tokenStorage)
    {
        $this->followerService = $followerService;

        $this->tokenStorageService = $tokenStorage;
    }

    /**
     * Follows a user
     *
     * @Rest\Post("/follower/follow")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function follow(Request $request): Response
    {
        $follower = new Follower();
        $form = $this->createForm(FollowerType::class, $follower);

        $data = $this->followerService->follow($request->request->all());

        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $follower = $this->followerService->save($follower);

            return $this->handleView($this->view($follower, Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($this->getErrorsMessages($form), Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Blocks a follower
     *
     * @Rest\Put("/follower/block")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function block(Request $request): Response
    {
        $relations = $this->followerService->relations($request->request->get("user"));

        if(empty($relations)){

            return $this->handleView($this->view([], Response::HTTP_NOT_FOUND));
        }

        $this->followerService->block($relations);

        return $this->handleView($this->view(["status" => "success", "message" => "User blocked"], Response::HTTP_CREATED));
    }

    /**
     * Mutes a follower
     *
     * @Rest\Put("/follower/mute")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function mute(Request $request): Response
    {
        $follower = $this->followerService->findFollowing($request->request->get("user"));

        if(is_null($follower)){

            return $this->handleView($this->view([], Response::HTTP_NOT_FOUND));
        }

        $this->followerService->mute($follower);


        return $this->handleView($this->view(["status" => "success", "message" => "User muted"], Response::HTTP_CREATED));
    }
}