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
     * @Assert\NotBlank
     * @Assert\Url(
     *    protocols = {"http", "https"}
     * )
     * @ORM\Column(type="string", length=180)
     */
    private $codecademyProfile;

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

    /**
     * @Assert\File
     *
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="archive2", fileNameProperty="archiveName2", mimeType="archiveMimeType2", size="archiveSize2")
     *
     * @var File
     */
    private $archiveFile2;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $archiveName2;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $archiveMimeType2;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $archiveSize2;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt2;

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

    public function getCodecademyProfile(): ?string
    {
        return $this->codecademyProfile;
    }

    public function setCodecademyProfile(string $codecademyProfile): self
    {
        $this->codecademyProfile = $codecademyProfile;

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

    public function getArchiveFile2(): ?File
    {
        return $this->archiveFile2;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $archiveFile2
     */
    public function setArchiveFile2(?File $archiveFile2 = null): void
    {
        $this->archiveFile2 = $archiveFile2;

        if (null !== $archiveFile2) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt2 = new \DateTimeImmutable();
        }
    }

    public function getArchiveName2(): ?string
    {
        return $this->archiveName2;
    }

    public function setArchiveName2(?string $archiveName2): self
    {
        $this->archiveName2 = $archiveName2;

        return $this;
    }

    /**
     * Get the value of archiveMimeType2
     *
     * @return  string
     */
    public function getArchiveMimeType2(): ?string
    {
        return $this->archiveMimeType2;
    }

    /**
     * Set the value of archiveMimeType2
     *
     * @param  string  $archiveMimeType2
     *
     * @return  self
     */
    public function setArchiveMimeType2(?string $archiveMimeType2): self
    {
        $this->archiveMimeType2 = $archiveMimeType2;

        return $this;
    }

    public function getArchiveSize2(): ?int
    {
        return $this->archiveSize2;
    }

    public function setArchiveSize2(?int $archiveSize2): self
    {
        $this->archiveSize2 = $archiveSize2;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (
            ($this->archiveFile == null && $this->archiveMimeType == 'application/zip')
            && ($this->archiveFile2 == null && $this->archiveMimeType2 == 'application/zip')
        ) {
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

        if ($this->archiveFile2 == null && $this->archiveMimeType2 ==  null) {
            $context
                ->buildViolation('Veuillez choisir un fichier zip.')
                ->atPath('archiveFile2')
                ->addViolation()
            ;

            return;
        }

        if (!in_array($this->archiveFile2->getMimeType(), [
            'application/zip',
        ])) {
            $context
                ->buildViolation('Mauvais type de fichier. Seuls les fichiers zip sont autorisés.')
                ->atPath('archiveFile2')
                ->addViolation()
            ;
        }
    }
}
