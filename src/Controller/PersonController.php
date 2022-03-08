<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonRepository;
use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends AbstractController
{
    /**
     * @Route("/person", name="browse_person")
     */
    public function browse(personRepository $personRepository): Response
    {
        $allperson = $personRepository->findAll();
        return $this->render('person/browse.html.twig', [
            'persons' => $allperson,
        ]);
    }

    /**
     * @Route("/person/{id}/read", name="read_person")
     */
    public function read(int $id, personRepository $personRepository): Response
    {
        $person = $personRepository->find($id);
        return $this->render('person/read.html.twig', [
            'person' => $person,
        ]);
    }


    /**
     * @Route("/person/{id}/edit", name="edit_person")
     */
    public function edit(Person $person, Request $request, ManagerRegistry $doctrine) : Response
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $this->addFlash('succes', 'Personne modifié avec succés');
            $entityManager->flush();
            return $this->redirectToRoute('browse_person');
        }
        
        return $this->render('person/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/person/add", name="add_person")
     */
    public function add(Request $request, ManagerRegistry $doctrine) : Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($person);
            $this->addFlash('succes', 'Personne ajouté avec succés');
            $entityManager->flush();
            return $this->redirectToRoute('browse_person');
        }
        
        return $this->render('person/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/person/{id}/delete", name="delete_person")
     */
    public function delete(Person $person, Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($person);
        $entityManager->flush();

        $this->addFlash('success', 'Personne supprimé');

        return $this->redirectToRoute('browse_person');
    }
}