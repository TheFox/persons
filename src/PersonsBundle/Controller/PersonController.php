<?php

namespace TheFox\PersonsBundle\Controller;

use TheFox\PersonsBundle\Entity\Person;
use TheFox\PersonsBundle\Form\PersonType;
use TheFox\PersonsBundle\Repository\PersonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends BaseController
{
    /**
     * @param PersonRepository $personRepository
     * @return Response
     */
    public function indexAction(PersonRepository $personRepository): Response
    {
        return $this->render('person/index.html.twig', ['people' => $personRepository->findAll()]);
    }
}
