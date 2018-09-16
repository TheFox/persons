<?php

namespace TheFox\PersonsBundle\Controller;

use TheFox\PersonsBundle\Entity\Person;
use TheFox\PersonsBundle\Form\PersonType;
use TheFox\PersonsBundle\Form\QuickPersonType;
use TheFox\PersonsBundle\Repository\EventRepository;
use TheFox\PersonsBundle\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TheFox\PersonsBundle\Security\Voter\PersonVoter;

final class PersonController extends BaseController
{
    /**
     * @param PersonRepository $personRepository
     * @return Response
     */
    public function listAction(PersonRepository $personRepository): Response
    {
        // Security
        $this->denyAccessUnlessGranted(PersonVoter::LIST);

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
        // User
        $user = $this->getUser();

        // Person
        $person = new Person();
        $person->setUser($user);

        // Form
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $parameters = ['id' => $person->getId()];
            return $this->redirectToRoute('thefox_persons_frontend_person_show', $parameters);
        }

        // Template
        $data = [
            'person' => $person,
            'form' => $form->createView(),
        ];
        $response = $this->render('person/new.html.twig', $data);
        return $response;
    }

    public function newQuickAction(Request $request): Response
    {
        // User
        $user = $this->getUser();

        // Person
        $person = new Person();
        $person->setUser($user);

        // Form
        $form = $this->createForm(QuickPersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $parameters = ['id' => $person->getId()];
            return $this->redirectToRoute('thefox_persons_frontend_person_show', $parameters);
        }

        // Template
        $data = [
            'person' => $person,
            'form' => $form->createView(),
        ];
        $response = $this->render('person/new.html.twig', $data);
        return $response;
    }

    public function showAction(Request $request, Person $person, EventRepository $eventRepository): Response
    {
        // Security
        $this->denyAccessUnlessGranted(PersonVoter::SHOW, $person);

        $showAllEvents = boolval($request->get('all_events'));
        if ($showAllEvents) {
            $events = $eventRepository->findEventsByPerson($person);
        } else {
            $events = $eventRepository->findEventsByPerson($person, 10);
        }

        // Template
        $data = [
            'person' => $person,
            'events' => $events,
        ];
        $response = $this->render('person/show.html.twig', $data);
        return $response;
    }

    public function editAction(Request $request, Person $person): Response
    {
        // Security
        $this->denyAccessUnlessGranted(PersonVoter::EDIT, $person);

        // Form
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $data = ['id' => $person->getId()];
            $response = $this->redirectToRoute('thefox_persons_frontend_person_edit', $data);
            return $response;
        }

        // Template
        $data = [
            'person' => $person,
            'form' => $form->createView(),
        ];
        $response = $this->render('person/edit.html.twig', $data);
        return $response;
    }

    public function deleteAction(Request $request, Person $person): Response
    {
        // Security
        $this->denyAccessUnlessGranted(PersonVoter::DELETE, $person);

        $id = sprintf('delete%d', $person->getId());
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid($id, $token)) {
            $person->delete();

            $em = $this->getDoctrine()->getManager();
            //$em->remove($person);
            $em->flush();
        }

        // Template
        $response = $this->redirectToRoute('thefox_persons_frontend_person_list');
        return $response;
    }
}
