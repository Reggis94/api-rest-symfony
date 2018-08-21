<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;



class UsersController extends FOSRestController
{

	private $userRepository;

	public function getUserAction(User $user)
	{
		return $this->view($user);
	} // "get_user"             [GET] /users/{id}

	/**
* @Rest\Post("/users")
* @ParamConverter("user", converter="fos_rest.request_body")
*/

	public function postUsersAction()
	{
		$this->em->persist($user);
		$this->em->flush();
		return $this->view($user);
	} // "post_users"           [POST] /users

	public function putUserAction($id)
	{} // "put_user"             [PUT] /users/{id}

	public function deleteUserAction($id)
	{} // "delete_user"          [DELETE] /users/{id}

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function getUsersAction()
	{
		$users = $this->userRepository->findAll();
		return $this->view($users);
	}
}
