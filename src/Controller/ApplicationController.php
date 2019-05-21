<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/candidature")
 */
class ApplicationController extends Controller
{
    private $generalContactEmail;
    private $technicalContactEmail;

    public function __construct(string $generalContactEmail, string $technicalContactEmail)
    {
        $this->generalContactEmail = $generalContactEmail;
        $this->technicalContactEmail = $technicalContactEmail;
    }

    /**
     * @Route("/", name="application_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($application);
            $entityManager->flush();

            // get application url
            $applicationUrl = $this->generateUrl('application_show', ['id' => $application->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

            // send registration confirmation email
            $message = (new \Swift_Message('Pop School Lens - Merci pour votre candidature !'))
            ->setFrom($this->generalContactEmail)
            ->setTo($application->getEmail())
            ->setReplyTo($this->technicalContactEmail)
            ->setBody(
                $this->renderView('email/application_confirmation.html.twig', [
                    'applicationUrl' => $applicationUrl,
                    'generalContactEmail' => $this->generalContactEmail,
                    'technicalContactEmail' => $this->technicalContactEmail,
                ]), 'text/html')
            ->addPart(
                $this->renderView('email/application_confirmation.txt.twig', [
                    'applicationUrl' => $applicationUrl,
                    'generalContactEmail' => $this->generalContactEmail,
                    'technicalContactEmail' => $this->technicalContactEmail,
                ]), 'text/plain')
            ;

            $mailer->send($message);

            return $this->redirectToRoute('application_show', [
                'id' => $application->getId(),
            ]);
        }

        return $this->render('application/new.html.twig', [
            'application' => $application,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="application_show", methods={"GET"})
     */
    public function show(Application $application): Response
    {
        return $this->render('application/show.html.twig', [
            'generalContactEmail' => $this->generalContactEmail,
            'technicalContactEmail' => $this->technicalContactEmail,
            'application' => $application,
        ]);
    }
}
