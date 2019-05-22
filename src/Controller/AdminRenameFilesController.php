<?php

namespace App\Controller;

use App\Entity\Application;
use App\Repository\ApplicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Util\Transliterator;

/**
 * @Route("/admin/rename-files")
 */
class AdminRenameFilesController extends Controller
{
    /**
     * @Route("/", name="adminrenamefiles_index")
     */
    public function index(Request $request, ApplicationRepository $applicationRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $applications = $applicationRepository->findAll();

        $targetDirectory = $this->get('kernel')->getProjectDir().'/public/archive';
        $renameLogFile = $this->get('kernel')->getProjectDir().'/rename.log';

        $filesystem = new Filesystem();

        if (!$filesystem->exists($renameLogFile)) {
            $filesystem->dumpFile($renameLogFile, '');
        }

        $renameLog = file($renameLogFile, FILE_IGNORE_NEW_LINES);

        foreach ($applications as $application) {
            $filename = $application->getArchiveName();

            if (!in_array($filename, $renameLog)) {
                $firstname = Transliterator::transliterate($application->getFirstname());
                $lastname = Transliterator::transliterate($application->getLastname());
                $newFilename = $firstname.'_'.$lastname.'_'.$filename;

                // update file name
                $application->setArchiveName($newFilename);

                // rename file
                $filesystem->rename($targetDirectory.'/'.$filename, $targetDirectory.'/'.$newFilename);

                // save changes
                $entityManager->persist($application);
                $entityManager->flush();

                $renameLog[] = $newFilename;
                file_put_contents($renameLogFile, implode("\n", $renameLog));
            }
        }

        return new Response(
            'OK',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
    }
}

