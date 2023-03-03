<?php

namespace App\Tests;

use App\Entity\Figure;
use App\Entity\Video;
use PHPUnit\Framework\TestCase;

class VideoUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $video = new Video();
        $figure = new Figure();

        $video->setUrl('name')
              ->setFigure($figure);

        $this->assertTrue($video->getUrl() === 'name');
        $this->assertTrue($video->getFigure() === $figure);
    }

    public function testIsFalse(): void
    {
        $video = new Video();
        $figure = new Figure();

        $video->setUrl('name')
              ->setFigure($figure);

        $this->assertFalse($video->getUrl() === 'false');
        $this->assertFalse($video->getFigure() === new Figure);
    }

    public function testIsEmpty(): void
    {
        $video = new Video();

        $this->assertEmpty($video->getUrl());
        $this->assertEmpty($video->getFigure());
        $this->assertEmpty($video->getId());
    }
}
