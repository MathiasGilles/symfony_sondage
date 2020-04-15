<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SondageController extends AbstractController
{
    /**
     * @Route("/sondage", name="sondage")
     */
    public function index(SondageRepository $repo)
    {
        $sondages = $repo->findAll();
        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondages,
        ]);
    }

    /**
     * @Route("/sondage/new",name="sondage_new")
     * @Route("/sondage/edit/{id}",name="sondage_edit")
     */
    public function new(Sondage $sondage = null, Request $request)
    {
        if (!$sondage) {
            $sondage = new Sondage();
        }
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($sondage);
            $manager->flush();

            $this->addFlash("success","Sondage sauvegardé");
            return $this->redirectToRoute('sondage');
        }

        return $this->render('sondage/sondage_new.html.twig', [
            'formSondage' => $form->createView()
        ]);
    }

    /**
     * @Route("/sondage/delete/{id}",name="sondage_delete")
     */
    public function delete($id = null, SondageRepository $repo)
    {

        if ($id != null) {
            $sondage = $repo->find($id);
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($sondage);
            $manager->flush();
        }
        $this->addFlash("success","Sondage supprimé");
        return $this->redirectToRoute('sondage');
    }

    /**
     * @Route("/task/detail/{id}",name="task_detail")
     */
    public function detail($id, SondageRepository $repo)
    {

        $sondage = $repo->find($id);

        return $this->render('sondage/sondage_detail.html.twig', [
            'sondage' => $sondage,
        ]);
    }
}
