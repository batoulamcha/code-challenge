<?php

namespace App\Controller;

use App\Form\CustomerType;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    private $CustomerRepository;
    private $entityManager;

    public function __construct(CustomerRepository $CustomerRepository, ManagerRegistry $doctrine)
    {
        $this->CustomerRepository = $CustomerRepository;
        $this->entityManager = $doctrine->getManager();
    }
    /**
     * @Route("/customer", name="customer_list")
     */
    public function index(): Response
    {
        $customer = $this->CustomerRepository->findAll();
        return $this->render('customer/index.html.twig', [
            'customers' => $customer,
        ]);
    }

    /**
     * @Route("/customer/create", name="customer_create")
     */

    public function create(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'New customer was added'
            );
            return $this->redirectToRoute('customer_list');
        }

        return $this->renderForm('customer/create.html.twig', [
            'form' => $form,
        ]);
    }


    /**
     * @Route("/customer/update/{id}", name="customer_update")
     */
    public function update(Customer $customer, Request $request): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $this->entityManager->persist($customer);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'customer info was updated'
            );
            return $this->redirectToRoute('customer_list');
        }

        return $this->renderForm('customer/edit.html.twig', [
            'form' => $form
        ]);
    }

    
        /**
     * @Route("/customer/delete/{id}", name="customer_delete")
     */
    public function delete(Customer $customer): Response
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
        $this->addFlash(
            'success',
            'customer was removed'
        );

        return $this->redirectToRoute('customer_list');
    }

    /**
     * @Route("/number", name="number_validation")
     */
    public function validate(): Response
    {
        $customer = $this->CustomerRepository->findAll();
        return $this->render('customer/number.php', [
            'customers' => $customer,
        ]);
    }

}