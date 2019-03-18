<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                'label' => 'Prénom',
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('email')
            ->add('comment', null, [
                'label' => 'Commentaire',
            ])
            ->add('archiveFile', VichFileType::class, [
                'label' => 'Archive (seuls les fichiers zip sont autorisés)',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'download_label' => function (Application $application) {
                    return $application->getArchiveName();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
