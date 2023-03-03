<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\Image;
use App\Entity\User;
use App\Entity\Video;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class FigureUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $figure = new Figure();
        $category = new Category();
        $user = new User();
        $datetime =  new DateTimeImmutable();

        $figure->setName('nom')
                ->setSlug('slug')
                ->setCategory($category)
                ->setDescription('description')
                ->setCreatedBy($user)
                ->setUpdatedBy($user)
                ->setCreatedAt($datetime)
                ->setUpdatedAt($datetime);

        $this->assertTrue($figure->getName() === 'nom');
        $this->assertTrue($figure->getSlug() === 'slug');
        $this->assertTrue($figure->getCategory() === $category);
        $this->assertTrue($figure->getDescription() === 'description');
        $this->assertTrue($figure->getCreatedBy() === $user);
        $this->assertTrue($figure->getUpdatedBy() === $user);
        $this->assertTrue($figure->getCreatedAt() === $datetime);
        $this->assertTrue($figure->getUpdatedAt() === $datetime);
    }

    public function testIsFalse(): void
    {
        $figure = new Figure();
        $category = new Category();
        $user = new User();
        $datetime =  new DateTimeImmutable();

        $figure->setName('nom')
                ->setSlug('slug')
                ->setCategory($category)
                ->setDescription('description')
                ->setCreatedBy($user)
                ->setUpdatedBy($user)
                ->setCreatedAt($datetime)
                ->setUpdatedAt($datetime);

        $this->assertFalse($figure->getName() === 'false');
        $this->assertFalse($figure->getSlug() === 'false');
        $this->assertFalse($figure->getCategory() === new Category);
        $this->assertFalse($figure->getDescription() === 'false');
        $this->assertFalse($figure->getCreatedBy() === new User);
        $this->assertFalse($figure->getUpdatedBy() === new User);
        $this->assertFalse($figure->getCreatedAt() === new DateTimeImmutable());
        $this->assertFalse($figure->getUpdatedBy() === new DateTimeImmutable());
    }

    public function testIsEmpty(): void
    {
        $figure = new Figure();

        $this->assertEmpty($figure->getName());
        $this->assertEmpty($figure->getSlug());
        $this->assertEmpty($figure->getCategory());
        $this->assertEmpty($figure->getDescription());
        $this->assertEmpty($figure->getCreatedBy());
        $this->assertEmpty($figure->getUpdatedBy());
        $this->assertEmpty($figure->getCreatedAt());
        $this->assertEmpty($figure->getUpdatedBy());
        $this->assertEmpty($figure->getId());
    }

    public function testGetAddRemoveImage() {
        $figure = new Figure();
        $image = new Image();

        $this->assertEmpty($figure->getImages());

        $figure->addImage(($image));
        $this->assertContains($image, $figure->getImages());

        $figure->removeImage(($image));
        $this->assertEmpty($figure->getImages());
    }

    public function testGetAddRemoveVideo() {
        $figure = new Figure();
        $video = new Video();

        $this->assertEmpty($figure->getVideos());

        $figure->addVideo(($video));
        $this->assertContains($video, $figure->getVideos());

        $figure->removeVideo(($video));
        $this->assertEmpty($figure->getVideos());
    }

    public function testGetAddRemoveComment() {
        $figure = new Figure();
        $comment = new Comment();

        $this->assertEmpty($figure->getComments());

        $figure->addComment(($comment));
        $this->assertContains($comment, $figure->getComments());

        $figure->removeComment(($comment));
        $this->assertEmpty($figure->getComments());
    }
}
