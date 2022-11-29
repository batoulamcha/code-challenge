<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use AppzForm\Type\CustomerType;
use App\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerApiController extends AbstractApiController
{

    public function indexAction(Request $request): Response
    {
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        return $this->respond($customers);

    }

    public function createAction(Request $request): Response
    {
        $form = $this->buildForm((CustomerType::class));
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Customer $customer */
        $customer = $form->getData();

        $this->getDoctrine()->getManager()->persist($customer);
        $this->getDoctrine()->getManager()->flush();


        return $this->respond($customer);
    }

    public function updateAction(Request $request): Response
    {
        $customerId = $request->get('customerId');

        $customer = $this->getDoctrine()->getRepository(Customer::class)->findOneBy(['id' => $customerId]);

        if (!$customer) {
            throw new NotFoundHttpException('Customer not found');
        }

        $form = $this->buildForm(CustomerType::class, $customer, [
            'method' => $request->getMethod(),
        ]);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Customer $customer */
        $customer = $form->getData();

        $this->getDoctrine()->getManager()->persist($customer);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($customer);
    }

    public function deleteAction(Request $request): Response
    {
        $customerId = $request->get('customerId');

        $customer = $this->getDoctrine()->getRepository(Customer::class)->findOneBy([
            'id' => $customerId,
        ]);

        if (!$customer) {
            throw new NotFoundHttpException('Customer not found');
        }

        $this->getDoctrine()->getManager()->remove($customer);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond(null);
    }
}