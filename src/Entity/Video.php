<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[Vich\Uploadable]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[Vich\UploadableField(mapping: 'video_figure', fileNameProperty: 'url')]
    #[Assert\File(
        mimeTypes: 'video/mp4',
        maxSize: '250M',
        maxSizeMessage: 'Please upload a valid video, allowed maximum size is {{ limit }} {{ suffix }}.',
    )]
    private ?File $videoFile = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    private ?Figure $figure = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
    
    /**
     * getId
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * getUrl
     *
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
    
    /**
     * setUrl
     *
     * @param  string $url Url
     * @return self
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
    
    /**
     * getVideoFile
     *
     * @return void
     */
    public function getVideoFile()
    {
        return $this->videoFile;
    }
    
    /**
     * setVideoFile
     *
     * @param  File $url Url
     * @return void
     */
    public function setVideoFile(File $url = null)
    {
        $this->videoFile = $url;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($url) {
            // If 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }
    
    /**
     * getFigure
     *
     * @return Figure
     */
    public function getFigure(): ?Figure
    {
        return $this->figure;
    }
    
    /**
     * setFigure
     *
     * @param  Figure $figure Figure
     * @return self
     */
    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }
    
    /**
     * getUpdatedAt
     *
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
    
    /**
     * setUpdatedAt
     *
     * @param  DateTimeImmutable $updatedAt UpdatedAt
     * @return self
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->url;
    }
}
