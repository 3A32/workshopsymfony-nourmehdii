<?php


namespace App\Controller;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    #[Route('/event',name:'app_event')]
    public function listEvent(EventRepository $repository)
    {
        $event=$repository->findAll();
        return $this->render("event/listevent.html.twig",array("tabEvent"=>$event));
    }
    #[Route('/addEvent',name:'app_addevent')]
    public function addEvent(ManagerRegistry $doctrine, Request $request )
    {
        $event= new Event();
        $form=$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$doctrine->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute("app_event");
        }

        return $this->renderForm("event/addEvent.html.twig",array("formEvent"=>$form));
    }

    #[Route('/updateEvent/{id}',name:'app_updateEvent')]
    public function updateEvent(EventRepository $repository,$id,ManagerRegistry $doctrine, Request $request )
    {
        $event= $repository->find($id);
        $form=$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em=$doctrine->getManager();

            $em->flush();
            return $this->redirectToRoute("app_event");
        }

        return $this->renderForm("event/updateEvent.html.twig",array("formEvent"=>$form));
    }
}
