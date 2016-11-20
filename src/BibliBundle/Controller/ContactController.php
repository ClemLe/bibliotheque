<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexContactAction(Request $request)
    {   
        
        $codeErreur=null;
        if (isset($_POST['action'])){
            
            $name=mysql_real_escape_string($_POST['name']);
            $subject=mysql_real_escape_string($_POST['subject']);
            $messagebody=mysql_real_escape_string($_POST['message']);
            $email=mysql_real_escape_string($_POST['email']);
            
            $message= new Message();
            $message->setAuthorname($name);
            $message->setEmail($email);
            $message->setSubject($subject);
            $message->setMessage($messagebody);
            $message->setIsRead(false);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            
            $codeErreur=1;
        }
        
                
        
        return $this->render('BibliBundle:Contact:index.html.twig',array(
          'codeErreur' => $codeErreur,
        ));
    }
}