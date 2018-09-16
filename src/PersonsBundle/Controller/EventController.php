<?php

namespace TheFox\PersonsBundle\Controller;

use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TheFox\PersonsBundle\Entity\Event;
use TheFox\PersonsBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TheFox\PersonsBundle\Repository\PersonRepository;
use TheFox\PersonsBundle\Security\Voter\EventVoter;

final class EventController extends BaseController
{
    public function newAction(Request $request, PersonRepository $personRepository): Response
    {
        // Person
        $personId = intval($request->get('person_id'));
        $person = $personRepository->find($personId);
        if (null === $person) {
            throw new NotFoundHttpException(sprintf('Person %d not found.', $personId));
        }

        // Event
        $event = new Event();
        $event->setPerson($person);
        if ($person->getDefaultEventType()) {
            $event->setType($person->getDefaultEventType());
        } else {
            $event->setType(1000);
        }

        // Security
        $this->denyAccessUnlessGranted(EventVoter::NEW, $event);

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Person
            $person->setUpdatedAt(Carbon::now('UTC'));

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            // Template
            $data = [
                'id' => $event->getId(),
            ];
            $response = $this->redirectToRoute('thefox_persons_frontend_event_show', $data);
            return $response;
        }

        // Template
        $data = [
            'event' => $event,
            'form' => $form->createView(),
        ];
        $response = $this->render('event/new.html.twig', $data);
        return $response;
    }

    public function showAction(Event $event): Response
    {
        // Security
        $this->denyAccessUnlessGranted(EventVoter::SHOW, $event);

        // Person
        $person = $event->getPerson();

        // Template
        $data = [
            'person' => $person,
            'event' => $event,
        ];
        $response = $this->render('event/show.html.twig', $data);
        return $response;
    }

    public function editAction(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Person
            $person = $event->getPerson();
            $person->setUpdatedAt(Carbon::now('UTC'));

            // Save
            $this->getDoctrine()->getManager()->flush();

            // Template
            $data = [
                'id' => $event->getId(),
            ];
            $response = $this->redirectToRoute('thefox_persons_frontend_event_show', $data);
            return $response;
        }

        // Template
        $data = [
            'event' => $event,
            'form' => $form->createView(),
        ];
        $response = $this->render('event/edit.html.twig', $data);
        return $response;
    }

    public function deleteAction(Request $request, Event $event): Response
    {
        // Person
        $person = $event->getPerson();

        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            // Person
            $person->setUpdatedAt(Carbon::now('UTC'));

            // Event
            $event->delete();

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        // Template
        $data = [
            'id' => $person->getId(),
        ];
        $response = $this->redirectToRoute('thefox_persons_frontend_person_show', $data);
        return $response;
    }
}
