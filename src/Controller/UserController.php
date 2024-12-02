<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Entity\Adresse; 
use App\Form\AdresseType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Annotation\Route; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    /**
     * @Route("/",name="client_list")
     */
    public function home(Request $request) 
    { 
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
        $clients= [];

        if($form->isSubmitted() && $form->isValid()) 
        {
            $nom = $propertySearch->getNom();
            if ($nom!="")
            $clients= $this->getDoctrine()->getRepository(Personne::class)->findBy(['nom' => $nom] );
            else
            $clients= $this->getDoctrine()->getRepository(Personne::class)->findAll();
        }
         
        return $this->render('clients/index.html.twig',[ 'form'=>$form->createView(), 'clients'=> $clients]); 
        
    }


    /**
     * @Route("/new", name="new_client") 
     * Method({"GET", "POST"})
     */
    public function new(Request $request) 
    { 
        $client = new Personne(); 
        $form = $this->createForm(PersonneType::class,$client); 
        $form->handleRequest($request); 
            if($form->isSubmitted() && $form->isValid()) 
            { 
                $client = $form->getData(); 
                $entityManager = $this->getDoctrine()->getManager(); 
                $entityManager->persist($client); 
                $entityManager->flush(); 
                return $this->redirectToRoute('client_list'); 
            } 
        return $this->render('clients/new.html.twig',['form' => $form->createView()]); 
    }

        /** 
        * @Route("/show/{id}", name="client_show") 
        */ 
        public function show($id) 
        { 
            $client = $this->getDoctrine()->getRepository(Personne::class)->find($id); 
            return $this->render('clients/show.html.twig', ['client' => $client]); 
        }

        /** 
        * @Route("/edit/{id}", name="edit_client") 
        * Method({"GET", "POST"}) 
        */ 
        public function edit(Request $request, $id) 
        { 
             $client = new Personne(); 
             $client = $this->getDoctrine()->getRepository(Personne::class)->find($id); 
             $form = $this->createForm(PersonneType::class,$client); 
             $form->handleRequest($request); 
                if($form->isSubmitted() && $form->isValid()) 
                { 
                    $entityManager = $this->getDoctrine()->getManager(); 
                    $entityManager->flush(); 
                    return $this->redirectToRoute('client_list'); 
                } 
            return $this->render('clients/edit.html.twig', ['form' => $form->createView()]);
        }

        /** 
        * @Route("/delete/{id}", name="delete_client") 
        * Method({"DELETE"}) 
        */ 
        public function delete(Request $request, $id) 
        { 
             $client = $this->getDoctrine()->getRepository(Personne::class)->find($id); 
             $entityManager = $this->getDoctrine()->getManager(); 
             $entityManager->remove($client); 
             $entityManager->flush();
             echo "Data delete";
             return $this->redirectToRoute('client_list');
        }


        /** 
        * @Route("/newAdr", name="new_adresse") 
        * Method({"GET", "POST"}) 
        */ 
        public function newAdresse(Request $request) 
        { 
             $adresse = new Adresse(); 
             $form = $this->createForm(AdresseType::class,$adresse); 
             $form->handleRequest($request); 
                if($form->isSubmitted() && $form->isValid()) 
                { 
                    $client = $form->getData(); 
                    $entityManager = $this->getDoctrine()->getManager(); 
                    $entityManager->persist($adresse); 
                    $entityManager->flush(); 
                } 
            return $this->render('clients/newAdresse.html.twig',['form'=> $form->createView()]); 
        }
        



}
