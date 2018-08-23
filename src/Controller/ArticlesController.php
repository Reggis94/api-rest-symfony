<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Article;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;


 class ArticlesController extends FOSRestController
 {
     private $articleRepository;
     private $em;

     public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $em)
     {
         $this->articleRepository = $articleRepository;
         $this->em = $em;
     }

     public function getArticlesAction()
     {
         $articles = $this->articleRepository->findAll();
         return $this->view($articles);
     }
     // "get_articles"            [GET] /articles
     public function	getArticleAction($id)
     {
         $article = $this->articleRepository->find($id);
         return $this->view($article);
     }
     // "get_article"             [GET] /articles/{id}
     /**
      * @Rest\Post("/articles")
      * @ParamConverter("article", converter="fos_rest.request_body")
      */
     public function postArticlesAction(Article $article)
     {
         $this->em->persist($article);
         $this->em->flush();
         return $this->view($article);
     }
/*
     public function	deleteUserAction($id)
     {
         $user = $this->userRepository->find($id);
         $this->em->remove($user);
         $this->em->flush();
     }
     // "delete_user"          [DELETE] /users/{id}
     */


 }
