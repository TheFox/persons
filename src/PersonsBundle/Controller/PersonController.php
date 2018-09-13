<?php

namespace TheFox\PersonsBundle\Controller;

use TheFox\PersonsBundle\Entity\Person;
use TheFox\PersonsBundle\Form\PersonType;
use TheFox\PersonsBundle\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TheFox\PersonsBundle\Security\PersonVoter;

class PersonController extends BaseController
{
    /**
     * @param PersonRepository $personRepository
     * @return Response
     */
    public function listAction(PersonRepository $personRepository): Response
    {
        $user = $this->getUser();
        $persons = $personRepository->findByUser($user);
        $data = [
            'persons' => $persons,
        ];
        $response = $this->render('person/list.html.twig', $data);
        return $response;
    }

    public function newAction(Request $request): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            return $this->redirectToRoute('thefox_persons_frontend_person_list');
        }

        $data = [
            'person' => $person,
            'form' => $form->createView(),
        ];
        $response = $this->render('person/new.html.twig', $data);
        return $response;
    }

    public function showAction(Person $person): Response
    {
        $this->denyAccessUnlessGranted(PersonVoter::SHOW, $person);
        
        $data = ['person' => $person];
        $response = $this->render('person/show.html.twig', $data);
        return $response;
    }

    public function editAction(Request $request, Person $person): Response
    {
        $this->denyAccessUnlessGranted(PersonVoter::EDIT, $person);

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $data = ['id' => $person->getId()];
            $response = $this->redirectToRoute('thefox_persons_frontend_person_edit', $data);
            return $response;
        }

        $data = [
            'person' => $person,
            'form' => $form->createView(),
        ];
        $response = $this->render('person/edit.html.twig', $data);
        return $response;
    }

    public function deleteAction(Request $request, Person $person): Response
    {
        $this->denyAccessUnlessGranted(PersonVoter::DELETE, $person);

        $id = sprintf('delete%d', $person->getId());
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid($id, $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($person);
            $em->flush();
        }

        $response = $this->redirectToRoute('thefox_persons_frontend_person_list');
        return $response;
    }
}
