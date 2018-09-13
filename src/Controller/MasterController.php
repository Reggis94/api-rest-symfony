<?php
namespace App\Controller;
use App\Entity\Master;
use App\Repository\MasterRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
class MasterController extends FOSRestController
{
    private $masterRepository;
    private $em;
    public function __construct(MasterRepository $masterRepository, EntityManagerInterface $em)
    {
        $this->masterRepository = $masterRepository;
        $this->em =$em;
    }
    /**
     * @Rest\View(serializerGroups={"master"})
     */
    public function getMastersAction()
    {
        $masters = $this->masterRepository->findAll();
        return $this->view($masters);
    } // "get_users"            [GET] /masters
    /**
     * @Rest\View(serializerGroups={"master"})
     */
    public function getMasterAction(Master $master)
    {
        if ($this->getUser()) {
            return $this->view($master);
        }
    } // "get_user"             [GET] /masters/{id}
    /**
     * @Rest\View(serializerGroups={"master"})
     * @Rest\Post("/masters")
     * @ParamConverter("master", converter="fos_rest.request_body")
     * @param Master $master
     * @return \FOS\RestBundle\View\View|JsonResponse
     */
    public function postMastersAction(Master $master)
    {
        $this->em->persist($master);
        $this->em->flush();
        return $this->view($master);
    } // "post_users"           [POST] /masters
    /**
     * @Rest\View(serializerGroups={"master"})
     * @param int $id
     * @param Request $request
     *@return \FOS\RestBundle\View\View|JsonResponse
     */
    public function putMasterAction(int $id, Request $request)
    {
        $master = $this->masterRepository->find($id);
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $email = $request->get('email');
        if($master == $this->getUser()) {
            if ($firstname) {
                $master->setFirstname($firstname);
            }
            if ($lastname) {
                $master->setLastname($lastname);
            }
            if ($email) {
                $master->setEmail($email);
            }
        }
        $this->em->persist($master);
        $this->em->flush();
        return $this->view($master);
    } // "put_user"             [PUT] /masters/{id}
    public function deleteMasterAction(Master $master)
    {
            $this->em->remove($master);
            $this->em->flush();
    } // "delete_user"          [DELETE] /masters/{id}
}
