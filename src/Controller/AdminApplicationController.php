<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/candidature")
 */
class AdminApplicationController extends Controller
{
    /**
     * @Route("/", name="admin_application_index", methods={"GET"})
     */
    public function index(ApplicationRepository $applicationRepository): Response
    {
        return $this->render('admin/application/index.html.twig', [
            'applications' => $applicationRepository->findAllReverseOrder(),
        ]);
    }

    /**
     * @Route("/new", name="admin_application_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->redirectToRoute('admin_application_index');
        }

        return $this->render('admin/application/new.html.twig', [
            'application' => $application,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_application_show", methods={"GET"})
     */
    public function show(Application $application): Response
    {
        return $this->render('admin/application/show.html.twig', [
            'application' => $application,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_application_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Application $application): Response
    {
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_application_index', [
                'id' => $application->getId(),
            ]);
        }

        return $this->render('admin/application/edit.html.twig', [
            'application' => $application,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_application_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Application $application): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($application);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_application_index');
    }
}
