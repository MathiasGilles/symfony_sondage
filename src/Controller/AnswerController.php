<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    /**
     * @Route("/answer", name="answer")
     */
    public function index(AnswerRepository $repo)
    {
        $answers = $repo->findAll();
        return $this->render('answer/index.html.twig', [
            'answers' => $answers,
        ]);
    }

    /**
     * @Route("/answer/new",name="answer_new")
     * @Route("/answer/edit/{id}",name="answer_edit")
     */
    public function new(Answer $answer = null, Request $request)
    {
        if (!$answer) {
            $answer = new Answer();
        }
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($answer);
            $manager->flush();

            $this->addFlash("success", "Réponse sauvegardé");
            return $this->redirectToRoute('answer');
        }

        return $this->render('answer/answer_new.html.twig', [
            'formAnswer' => $form->createView()
        ]);
    }

    /**
     * @Route("/answer/delete/{id}",name="answer_delete")
     */
    public function delete($id = null, AnswerRepository $repo)
    {

        if ($id != null) {
            $answer = $repo->find($id);
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($answer);
            $manager->flush();
        }
        $this->addFlash("success", "Réponse supprimé");
        return $this->redirectToRoute('answer');
    }

    /**
     * @Route("/answer/detail/{id}",name="answer_detail")
     */
    public function detail($id, AnswerRepository $repo)
    {

        $answer = $repo->find($id);

        return $this->render('answer/answer_detail.html.twig', [
            'answer' => $answer,
        ]);
    }
}
