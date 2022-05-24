<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/acceuil", name="app_acceuil")
     */
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /*dd($form->getData());*/
            $emailTest = (new Email())
                ->from($form->getData()->getEmail())
                ->to(new Address('contact@safgroupe.fr', 'Service Client'))
                ->cc('contact@stia.tn')
                ->subject($form->getData()->getSubject())
                ->text($form->getData()->getMessage());
//                ->htmlTemplate('email/email.html.twig');
            $mailer->send($emailTest);
//            dd($form->getData()->getEmail());
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre Email a été bien envoyé'
            );
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }

}
