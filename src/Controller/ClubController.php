<?php

namespace App\Controller;
    use Doctrine\DBAL\Schema\View;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use  App\Repository\ClubRepository;
    use Doctrine\Persistence\ManagerRegistry;
    use App\Entity\Club;
    use App\Form\ClubType;


    class ClubController extends AbstractController
    {
        #[Route('/club', name: 'app_club')]
        public function index(): Response
        {
            return $this->render('club/index.html.twig', [
                'controller_name' => 'ClubController',]);
        }
                #[Route('/listFormation', name: 'list_formation')]
                public function listFormation()
                {
                    $var1 = "3A32";
                    $var2 = "J12";
                    $formations = array(
                        array('ref' => 'form147', 'Titre' => 'Formation Symfony4', 'Description' => 'pratique',
                            'date_debut' => '12/06/2020', 'date_fin' => '19/06/2020',
                            'nb_participants' => 19),
                        array('ref' => 'form177', 'Titre' => 'Formation SOA', 'Description' => 'theorique'
                        , 'date_debut' => '03/12/2020', 'date_fin' => '10/12/2020', 'nb_participants' => 0),
                        array('ref' => 'form178', 'Titre' => 'Formation Angular',
                            'Description' => 'theorique', 'date_debut' => '10/06/2020', 'date_fin' => '14/06/2020',
                            'nb_participants' => 12));
                    $max_value = max(array_column($formations, 'nb_participants'));
                    $total = array_sum(array_column($formations, 'nb_participants'));
                    return $this->render("club/list.html.twig",
                        array("x" => $var1, "y" => $var2, "max" => $max_value,"total" => $total, "tabFormation" => $formations));
                }
                #[Route('/participer', name: 'reservation_formation')]
                public function reservation()
                {
                    return new Response("nouvelle page");
                }
        #[Route('/clubs', name: 'app_clubs')]

        public function listClub(ClubRepository $repository)
        {
            $clubs= $repository->findAll();
            return $this->render("club/listClub.html.twig",array("tabClubs"=>$clubs));
        }
        #[Route('/addClub',name:'app_addclub')]
        public function addClub(ManagerRegistry $doctrine, Request $request)
        {
            $club= new Club();
            $form=$this->createForm(ClubType::class,$club);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                // if ($form->isValid())
                $em = $doctrine->getManager();
                $em->persist($club);
                $em->flush();
                return $this->redirectToRoute("app_clubs");
            }
            return $this->render("club/addClub.html.twig",
                array("formClub"=>$form->createView())); } //ou bien
            #[Route('/updateClub/{id}',name:'app_updateClub')]
        public function updateClub(ClubRepository $repository,$id,ManagerRegistry $doctrine, Request $request)
        {
            $club=$repository ->find($id);
            $form=$this->createForm(ClubType::class,$club);
            $form->handleRequest($request);
            if ($form->isSubmitted()){
                $em=$doctrine->getManager();
                $em->flush();
                return $this->redirectToRoute("app_clubs");
            }
           return $this->renderForm("club/update.html.twig",
                array("formClub"=>$form));
        }
        #[Route('/removeClub/{id}', name: 'app_removeClub')]

        public function deleteClub(ManagerRegistry $doctrine,$id,ClubRepository $repository)
        {
            $club= $repository->find($id);
            $em= $doctrine->getManager();
            $em->remove($club);
            $em->flush();
            return $this->redirectToRoute("app_clubs");

        }

            }
