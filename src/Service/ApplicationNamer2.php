<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\ConfigurableInterface;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Util\Transliterator;

/**
 * ApplicationNamer2
 */
class ApplicationNamer2 implements NamerInterface, ConfigurableInterface
{
    /**
     * @var bool
     */
    private $transliterate = false;
    /**
     * @param array $options Options for this namer. The following options are accepted:
     *                       - transliterate: whether the filename should be transliterated or not
     */
    public function configure(array $options): void
    {
        $this->transliterate = isset($options['transliterate']) ? (bool) $options['transliterate'] : $this->transliterate;
    }
    /**
     * {@inheritdoc}
     */
    public function name($object, PropertyMapping $mapping): string
    {
        /* @var $file UploadedFile */
        $file = $mapping->getFile($object);
        $name = $file->getClientOriginalName();
        $firstname = $object->getFirstname();
        $lastname = $object->getLastname();
        if ($this->transliterate) {
            $name = Transliterator::transliterate($name);
            $firstname = Transliterator::transliterate($firstname);
            $lastname = Transliterator::transliterate($lastname);
        }
        return $firstname.'_'.$lastname.'_'.\uniqid().'_website_'.$name;
    }
}

