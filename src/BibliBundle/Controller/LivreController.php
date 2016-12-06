<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//ajout
use BibliBundle\Form\IdentityPictureType;

class LivreController extends Controller
{
    public function ajouterAction (Request $request){   
        
        $codeErreur=0;
        
        $livre= new Livre();
        $form = $this->createFormBuilder($livre)
                ->add('titre')
                ->add('auteur')
                ->add('dateParution')
                ->add('resume')
                ->add('file', 'file', array('required' => true))
                 
                ->getForm()
        ;
        $form->handleRequest($request);
      
            if ($form->isValid()) {
        
                $em = $this->getDoctrine()->getManager();
                $livre->uploadProfilePicture();   
                $em->persist($livre);
                $em->flush();
                    
                $codeErreur = 1;
                
                unset($titre);
                unset($form);
  
                $livre= new Livre();
                $form = $this->createFormBuilder($livre)
                    ->add('titre')
                    ->add('auteur')
                    ->add('dateParution')
                    ->add('resume')
                    ->add('file', 'file', array('required' => true))

                    ->getForm()
                ;
                
            }
    
        
        return $this->render('BibliBundle:AjouterLivre:index.html.twig',array(
          'codeErreur' => $codeErreur,
          'form' => $form->createView()
            ));
    }

    
    
    public function rechercheLivreAction(){
        
        $livres = $this->getDoctrine()
        ->getRepository('BibliBundle:Livre')
        ->findAll();
        
        
        return $this->render('BibliBundle:Livre:recherche.livre.html.twig',array(
          'livres' => $livres,
        ));
    }
    
    
    public function autocompletionAuteurAction(){
        
        $term = $_GET['term'];
    
        $livres = $this->getDoctrine()->getRepository('BibliBundle:Livre')->createQueryBuilder('l')
            ->where('l.auteur LIKE :auteur')
            ->setParameter('auteur', $term.'%')
            ->getQuery()
            ->getResult();
        
        $arrayNomAuteur= array();
        
        foreach ($livres as $livre){
            array_push($arrayNomAuteur, $livre->getAuteur());
        }
         
        return new Response(json_encode($arrayNomAuteur));
        
    }
}