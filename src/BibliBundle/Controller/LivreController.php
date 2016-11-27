<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
//ajout
use BibliBundle\Form\IdentityPictureType;

class LivreController extends Controller
{
    public function ajouterAction (Request $request){   
        
        $codeErreur=null;
        
        $livre= new Livre();
        $form = $this->createFormBuilder($livre)
                ->add('file')
   
                ->getForm()
        ;
        $form->handleRequest($request);
       
        if ($request->getMethod() === 'POST') {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $livre->uploadProfilePicture();   
                $em->persist($livre);
                $em->flush();
                    
                $codeErreur = 1;
            }
        }
        
        return $this->render('BibliBundle:AjouterLivre:index.html.twig',array(
          'codeErreur' => $codeErreur,
          'form' => $form->createView()
            ));
    }

    
    
    public function rechercheLivreAction(){
        return $this->render('BibliBundle:Livre:recherche.livre.html.twig');
    }
}