<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index(QuestionRepository $repo)
    {
        $questions = $repo->findAll();
        return $this->render('question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/question/new",name="question_new")
     * @Route("/question/edit/{id}",name="question_edit")
     */
    public function new(Question $question = null, Request $request)
    {
        if (!$question) {
            $question = new Question();
        }
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($question);
            $manager->flush();

            $this->addFlash("success", "Question sauvegardé");
            return $this->redirectToRoute('question');
        }

        return $this->render('question/question_new.html.twig', [
            'formQuestion' => $form->createView()
        ]);
    }

    /**
     * @Route("/question/delete/{id}",name="question_delete")
     */
    public function delete($id = null, QuestionRepository $repo)
    {

        if ($id != null) {
            $question = $repo->find($id);
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($question);
            $manager->flush();
        }
        $this->addFlash("success", "Question supprimé");
        return $this->redirectToRoute('question');
    }

    /**
     * @Route("/question/detail/{id}",name="question_detail")
     */
    public function detail($id, QuestionRepository $repo)
    {

        $question = $repo->find($id);

        return $this->render('question/question_detail.html.twig', [
            'question' => $question,
        ]);
    }
}
