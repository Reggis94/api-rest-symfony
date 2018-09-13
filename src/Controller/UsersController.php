<?php
namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
/**
 * @property EntityManagerInterface em
 */
class UsersController extends FOSRestController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }
    public function getUsersAction()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users);
    }
    // "get_users"            [GET] /users
    public function	getUserAction($id)
    {
        $user = $this->userRepository->find($id);
        return $this->view($user);
    }
    // "get_user"             [GET] /users/{id}
    /**
     * @Rest\Post("/users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function	postUsersAction(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    }
    // "post_users"           [POST] /users
    public function	putUserAction(Request $request, int $id)
    {
        $user = $this->userRepository->find($id);
        //$birthday = $request->get('birthday');
        //if ($this->getUser() === $user)
        if ($this->getUser() === $user){
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $email = $request->get('email');
            if(isset($firstname)){
                $user->setFirstname($firstname);
            }
            if(isset($lastname)){
                $user->setLastname($lastname);
            }
            if(isset($email)){
                $user->setEmail($email);
            }
            //if(isset($birthday)){
            //    $user->setBirthday($birthday);
            //}
            $this->em->persist($user);
            $this->em->flush();
        }
        return $this->view($user);
    }
    // "put_user"             [PUT] /users/{id}
    public function	deleteUserAction(User $user)
    {
       $articles = $user->getArticles();
       foreach ($articles as $article)
       {
           $article->setUser(null);
       }
        $this->em->remove($user);
        $this->em->flush();
    }
    // "delete_user"          [DELETE] /users/{id}
}
