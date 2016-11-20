<?php

namespace BibliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BibliBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexContactAction(Request $request)
    {   
        if (isset($_POST['action'])){
            
            $name=mysql_real_escape_string($_POST['name']);
            $subject=mysql_real_escape_string($_POST['subject']);
            $message=mysql_real_escape_string($_POST['message']);
            $email=mysql_real_escape_string($_POST['email']);
            
            $message= new Message();
            $message->setAuthorname($name);
            $message->setEmail($email);
            $message->setSubject($subject);
            $message->setMessage($message);
            $message->setIsRead(false);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }
        
                
        
        return $this->render('BibliBundle:Contact:index.html.twig');
    }
}