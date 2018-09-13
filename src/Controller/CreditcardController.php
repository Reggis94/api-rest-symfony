<?php
namespace App\Controller;
use App\Entity\Creditcard;
use App\Repository\CreditcardRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
class CreditcardController extends FOSRestController
{
    private $creditcardRepository;
    private $em;
    public function __construct(CreditcardRepository $creditcardRepository, EntityManagerInterface $em)
    {
        $this->creditcardRepository = $creditcardRepository;
        $this->em = $em;
    }
    public function getCreditcardsAction()
    {
        $card = $this->creditcardRepository->findAll();
        return $this->view($card);
    }
    public function getCreditcardAction(Creditcard $creditcard)
    {
        return $this->view($creditcard);
    }
    /**
     * @ParamConverter("credit", converter="fos_rest.request_body")
     * @param Creditcard $creditcard
     * @return \FOS\RestBundle\View\View|JsonResponse
     */
    public function postCreditcardsAction(Creditcard $creditcard)
    {
        $creditcard->setCompany($this->getUser());
        $this->em->persist($creditcard);
        $this->em->flush();
        return $this->view($creditcard);
    }
    /**
     *
     * @param int $id
     * @param Request $request
     * @return \FOS\RestBundle\View\View|JsonResponse
     */
    public function putCreditcardsAction(int $id, Request $request)
    {
    }
    public function deleteCreditcardsAction(Creditcard $creditcard)
    {
            $this->em->remove($creditcard);
            $this->em->flush();
    }
}
