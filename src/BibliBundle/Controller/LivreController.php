<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
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
                ->add('dateParution', 'text', array('attr' => array('placeholder' => 'Taper ici l\'année de parution format YYYY')))
                ->add('resume')
                ->add('file', 'file', array('required' => true))
                 
                ->getForm()
        ;
        $form->handleRequest($request);
      
            if ($form->isValid()) {
        
                $em = $this->getDoctrine()->getManager();
                $livre->uploadProfilePicture();
                $livre->setEstEmprunte(false);
                $em->persist($livre);
                $em->flush();
                    
                $codeErreur = 1;
     
            }
        return $this->render('BibliBundle:Livre:ajouter.livre.html.twig',array(
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
    
    public function afficherLivreAction($idLivre){
           
        $livre=$this->getDoctrine()
                ->getRepository('BibliBundle:Livre')
                ->findOneBy(array('id' => $idLivre));
        
         $codeMessageUser=null;
        
        return $this->render('BibliBundle:Livre:afficher.un.livre.html.twig',array(
          'livre' => $livre,
          'codeMessageUser' =>$codeMessageUser
        ));
   
    }
    
    
    public function reserverLivreAction($idLivre){
        
        $livre=$this->getDoctrine()
                ->getRepository('BibliBundle:Livre')
                ->findOneBy(array('id' => $idLivre));
        
        
        $user=$this->getUser();
        
        $livre->setUserEmprunt($user);
        $livre->setDateReservation(new \DateTime("now"));
        $livre->setDateRetour(new \DateTime('+30 day'));
        $livre->setEstEmprunte(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($livre);
        $em->flush();
        
        $codeMessageUser=1;
        
         return $this->render('BibliBundle:Livre:afficher.un.livre.html.twig',array(
          'livre' => $livre,
          'codeMessageUser' =>$codeMessageUser
        ));
        
        
    }
    
    public function mesReservationsAction(){
        
        
        $user=$this->getUser();
        
        $livres=$this->getDoctrine()
                ->getRepository('BibliBundle:Livre')
                ->findBy(array('user_emprunt' => $user));
        
        return $this->render('BibliBundle:Livre:mes.reservations.html.twig',array(
          'livres' => $livres,
        ));
    }
}