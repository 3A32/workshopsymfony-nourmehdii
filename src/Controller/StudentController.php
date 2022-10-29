<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

   /* #[Route('/liststudent', name: 'app_liststudent')]
    public function listStudent(StudentRepository $repository)
    {
        $student = $repository->findAll();

        return $this->render("student/listStudent.html.twig", array("tabstudent" => $student));
    }*/

    #[Route('/addStudent', name: 'app_addStudent')]
    public function addStudent(ManagerRegistry $doctrine, Request $request)
    {
        $student = new Student();
        $form = $this->createForm(studentT::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // if ($form->isValid())
            $em = $doctrine->getManager();
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute("app_students");
        }
        return $this->render("student/addStudent.html.twig",
            array("formStudent" => $form->createView()));
    } //ou bien

    #[Route('/updateStudent/{id}', name: 'app_updateStudent')]
    public function updateStudent(StudentRepository $repository, $id, ManagerRegistry $doctrine, Request $request)
    {
        $student = $repository->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute("app_Student");
        }
        return $this->renderForm("student/update.html.twig",
            array("formStudent" => $form));
    }

    #[Route('/removeStudent/{id}', name: 'app_removeStudent')]
    public function deleteStudent(ManagerRegistry $doctrine, $id, StudentRepository $repository)
    {
        $student = $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute("app_students");

    }
    #[Route('/liist', name: 'liistapp')]
    public function liist(StudentRepository $repository,Request $request){

        $students= $repository->findAll();
        $studentsByNce=$repository->getStudentsOrdredByNCE();
        $formSearch= $this->createForm(SearchstudentType::class);
        $formSearch->handleRequest($request) ;
        $topStudents= $repository->topStudent();
        if($formSearch->isSubmitted()){
            $nsc=$formSearch->getData();
            $result= $repository->findStudentByNCE($nsc);
            return $this->renderForm("student/liist.html.twig",
                array("students"=>$result,"byNCE"=>$studentsByNce,"searchForm"=>$formSearch,"topStudents"=>$topStudents));
        }
        return $this->renderForm("student/liist.html.twig",
            array("students"=>$students,
                "byNCE"=>$studentsByNce,
                "searchForm"=>$formSearch,
                "topStudents"=>$topStudents ));

    }
}
