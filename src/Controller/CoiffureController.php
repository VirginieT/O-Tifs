<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CoiffureRepository;
use App\Entity\Coiffure;
use App\Form\CoiffureType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class CoiffureController extends AbstractController
{
    /**
     * @Route("/coiffure", name="browse_coiffure")
     */
    public function browse(CoiffureRepository $coiffureRepository): Response
    {
        $allCoiffure = $coiffureRepository->findAll();
        return $this->render('coiffure/browse.html.twig', [
            'coiffures' => $allCoiffure,
        ]);
    }

    /**
     * @Route("/coiffure/{id}/read", name="read_coiffure")
     */
    public function read(int $id, CoiffureRepository $coiffureRepository): Response
    {
        $coiffure = $coiffureRepository->find($id);
        return $this->render('coiffure/read.html.twig', [
            'coiffure' => $coiffure,
        ]);
    }


    /**
     * @Route("/coiffure/{id}/edit", name="edit_coiffure")
     */
    public function edit (Coiffure $coiffure, Request $request, ManagerRegistry $doctrine) : Response
    {
        $form = $this->createForm(CoiffureType::class, $coiffure);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $this->addFlash('succes', 'Coiffure modifié avec succés');
            $entityManager->flush();
            return $this->redirectToRoute('browse_coiffure');
        }
        
        return $this->render('coiffure/edit.html.twig',[
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/coiffure/add", name="add_coiffure")
     */
    public function add (Request $request, ManagerRegistry $doctrine) : Response
    {
        $coiffure = new Coiffure();
        $form = $this->createForm(CoiffureType::class, $coiffure);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($coiffure);
            $this->addFlash('succes', 'Coiffure ajouté avec succés');
            $entityManager->flush();
            return $this->redirectToRoute('browse_coiffure');
        }
        
        return $this->render('coiffure/add.html.twig',[
            'form' => $form->createView(),
        ]);

    }

        /**
     * @Route("/coiffure/{id}/delete", name="delete_coiffure")
     */
    public function delete (Coiffure $coiffure, Request $request, ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        foreach ($coiffure->getPersons() as $currentPerson)
        {
            $entityManager->remove($currentPerson);
        }

        $entityManager->remove($coiffure);
        $entityManager->flush();

        $this->addFlash('success', 'Coiffure supprimé');

        return $this->redirectToRoute('browse_coiffure');
    }
}
