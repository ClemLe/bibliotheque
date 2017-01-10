<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
use BibliBundle\Form\IdentityPictureType;

/**
 * Classe LivreController
 * 
 * Cette classe permet la gestion des livres, leurs ajouts,
 * leurs affichages ainsi que toutes les fonctionnalités
 * concernant les livres
 */
class LivreController extends Controller
{
    /**
     * Ajouter un livre à l'aide d'un formulaire
     * 
     * @param Request $request 
     * @return type La vue permttant d'ajouter un livre
     */
    public function ajouterAction (Request $request){   
        
        $codeErreur=0;
        
        $livre= new Livre();
        $form = $this->createFormBuilder($livre)
                ->add('titre')
                ->add('auteur')
                ->add('dateParution', 'text', array('attr' => array('placeholder' => 'Taper ici l\'annee de parution format YYYY')))
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

    
   /**
     * Affichage de la liste des livres pour permettre une recherche
     * 
     * @return type La vue d'affichage des livres
     */
    public function rechercheLivreAction(){
        
        $livres = $this->getDoctrine()
        ->getRepository('BibliBundle:Livre')
        ->findAll();
        
        
        return $this->render('BibliBundle:Livre:recherche.livre.html.twig',array(
          'livres' => $livres,
        ));
    }
    
    /**
     * Autocomplétion sur le champ auteur lors de l'ajout d'un livre
     * 
     * @return Response la liste des auteurs correspondants aux caractères 
     * entrés dans le champ auteur par l'utilisateur
     */
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
    
    /**
     * Affiche la description d'un livre
     *
     * @param type $idLivre L'identifiant du livre à afficher
     * @return type La vue correspondant au livre désiré
     */
    public function afficherLivreAction($idLivre){
           
        $livre=$this->getDoctrine()
                ->getRepository('BibliBundle:Livre')
                ->findOneBy(array('id' => $idLivre));
        
         $codeMessageUser=null;
         
        $user=$this->getUser();
         
        $livresUser=$this->getDoctrine()
            ->getRepository('BibliBundle:Livre')
            ->findBy(array('user_emprunt' => $user));
       
        $nombreReservationUser=count($livresUser);
        if($$nombreReservationUser =''){
            $nombreReservationUser=0;
        }
        
        return $this->render('BibliBundle:Livre:afficher.un.livre.html.twig',array(
          'livre' => $livre,
          'codeMessageUser' =>$codeMessageUser,
          'nombreReservation'=>$nombreReservationUser
        ));
   
    }
    
    /**
     * Permet de réserver un livre
     * 
     * @param type $idLivre L'identifiant du livre à réserver
     * @return type La vue de description du livre réservé
     */
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
        $nombreReservationUser=0;
        
         return $this->render('BibliBundle:Livre:afficher.un.livre.html.twig',array(
          'livre' => $livre,
          'codeMessageUser' =>$codeMessageUser,
          'nombreReservation'=>$nombreReservationUser
        ));
        
        
    }
    
    /**
     * Recupère la liste des livres réservés par l'utilisateur connecté
     * 
     * @return type La vue affichant la liste des livres réservés par l'utilisateur
     */
    public function mesReservationsAction(){
        
        $user=$this->getUser();
        
        $livres=$this->getDoctrine()
                ->getRepository('BibliBundle:Livre')
                ->findBy(array('user_emprunt' => $user));
        
        return $this->render('BibliBundle:Livre:mes.reservations.html.twig',array(
          'livres' => $livres,
        ));
    }
    
    public function  annulerReservationAction($idLivre){
         $livre=$this->getDoctrine()
                ->getRepository('BibliBundle:Livre')
                ->findOneBy(array('id' => $idLivre));
         
        $livre->setUserEmprunt(null);
        $livre->setDateReservation(null);
        $livre->setDateRetour(null);
        $livre->setEstEmprunte(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($livre);
        $em->flush();
        
       
        return $this->redirectToRoute('bibli_afficher_mes_reservations');
    }
    
}