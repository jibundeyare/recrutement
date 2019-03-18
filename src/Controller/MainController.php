<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    private $generalContactEmail;
    private $technicalContactEmail;

    public function __construct(string $generalContactEmail, string $technicalContactEmail)
    {
        $this->generalContactEmail = $generalContactEmail;
        $this->technicalContactEmail = $technicalContactEmail;
    }

    /**
     * @Route("/", name="main_index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'generalContactEmail' => $this->generalContactEmail,
            'technicalContactEmail' => $this->technicalContactEmail,
        ]);
    }
}
