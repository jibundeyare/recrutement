<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use EasySlugger\Slugger;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 * @Vich\Uploadable
 */
class Application
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=180)
     */
    private $firstname;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=180)
     */
    private $lastname;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @Assert\Length(min=0, max=500)
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @Assert\File
     * 
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="archive", fileNameProperty="archiveName", mimeType="archiveMimeType", size="archiveSize")
     * 
     * @var File
     */
    private $archiveFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $archiveName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $archiveMimeType;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */ 
    private $archiveSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->creationDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getArchiveFile(): ?File
    {
        return $this->archiveFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $archiveFile
     */
    public function setArchiveFile(?File $archiveFile = null): void
    {
        $this->archiveFile = $archiveFile;

        if (null !== $archiveFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getArchiveName(): ?string
    {
        return $this->archiveName;
    }

    public function setArchiveName(?string $archiveName): self
    {
        $this->archiveName = $archiveName;

        return $this;
    }

    /**
     * Get the value of archiveMimeType
     *
     * @return  string
     */ 
    public function getArchiveMimeType(): ?string
    {
        return $this->archiveMimeType;
    }

    /**
     * Set the value of archiveMimeType
     *
     * @param  string  $archiveMimeType
     *
     * @return  self
     */ 
    public function setArchiveMimeType(?string $archiveMimeType): self
    {
        $this->archiveMimeType = $archiveMimeType;

        return $this;
    }

    public function getArchiveSize(): ?int
    {
        return $this->archiveSize;
    }
    
    public function setArchiveSize(?int $archiveSize): self
    {
        $this->archiveSize = $archiveSize;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->archiveFile == null && $this->archiveMimeType == 'application/zip') {
            return;
        }

        if ($this->archiveFile == null && $this->archiveMimeType ==  null) {
            $context
                ->buildViolation('Veuillez choisir un fichier zip.')
                ->atPath('archiveFile')
                ->addViolation()
            ;

            return;
        }

        if (!in_array($this->archiveFile->getMimeType(), [
            'application/zip',
        ])) {
            $context
                ->buildViolation('Mauvais type de fichier. Seuls les fichiers zip sont autorisés.')
                ->atPath('archiveFile')
                ->addViolation()
            ;
        }
    }
}
