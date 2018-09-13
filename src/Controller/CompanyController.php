<?php
namespace App\Controller;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class CompanyController extends FOSRestController
{
    private $companyRepository;
    private $em;
    public function __construct(CompanyRepository $companyRepository, EntityManagerInterface $em)
    {
        $this->companyRepository = $companyRepository;
        $this->em = $em;
    }
    /**
     * @Rest\View(serializerGroups={"company"})
     */
    public function getCompaniesAction()
    {
        $company = $this->companyRepository->findAll();
        return $this->view($company);
    }
    /**
     * @Rest\View(serializerGroups={"company"})
     */
    public function getCompanyAction(Company $company)
    {
        return $this->view($company);
    }
    /**
     * @Rest\View(serializerGroups={"company"})
     * @Rest\Post("/company")
     * @ParamConverter("company", converter="fos_rest.request_body")
     * @param Company $company
     * @return \FOS\RestBundle\View\View
     */
    public function postCompaniesAction(Company $company)
    {
        if($this->getUser()){
            $company->setMaster($this->getUser());
        }
        $this->em->persist($company);
        $this->em->flush();
        return $this->view($company);
    }
    /**
     * @Rest\View(serializerGroups={"company"})
     * @param int $id
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function putCompanyAction(int $id, Request $request)
    {
        $name = $request->get('name');
        $slogan = $request->get('slogan');
        $phoneNumber = $request->get('phoneNumber');
        $address = $request->get('address');
        $websiteUrl = $request->get('websiteUrl');
        $pictureUrl = $request->get('pictureUrl');
        $company = $this->companyRepository->find($id);
        if ($company->getMaster() == $this->getUser() || $this->isGranted('ROLE_ADMIN')) {
            if ($name) {
                $company->setName($name);
            }
            if ($slogan) {
                $company->setSlogan($slogan);
            }
            if ($phoneNumber) {
                $company->setPhoneNumber($phoneNumber);
            }
            if ($ad) {
                $company->setAddress($ad);
            }
            if ($websiteUrl) {
                $company->setWebsiteUrl($websiteUrl);
            }
            if ($pictureUrl) {
                $company->setPictureUrl($pictureUrl);
            }
        }
        $this->em->persist($company);
        $this->em->flush();
        return $this->view($company);
    }
    public function deleteCompanyAction(Company $company)
    {
        if ($company->getMaster() == $this->getUser() or $this->isGranted('ROLE_ADMIN')) {
            $this->em->remove($company);
            $this->em->flush();
        }
    }
}
