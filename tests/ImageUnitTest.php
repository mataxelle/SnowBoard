<?php

namespace App\Tests;

use App\Entity\Figure;
use App\Entity\Image;
use PHPUnit\Framework\TestCase;

class ImageUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $image = new Image();
        $figure = new Figure();

        $image->setName('name')
            ->setFigure($figure);

        $this->assertTrue($image->getName() === 'name');
        $this->assertTrue($image->getFigure() === $figure);
    }

    public function testIsFalse(): void
    {
        $image = new Image();
        $figure = new Figure();

        $image->setName('name')
            ->setFigure($figure);

        $this->assertFalse($image->getName() === 'false');
        $this->assertFalse($image->getFigure() === new Figure);
    }

    public function testIsEmpty(): void
    {
        $image = new Image();

        $this->assertEmpty($image->getName());
        $this->assertEmpty($image->getFigure());
        $this->assertEmpty($image->getId());
    }
}
