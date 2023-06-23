<?php

namespace App\Tests;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class CommentUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $comment = new Comment();
        $figure = new Figure();
        $user = new User;
        $datetime = new DateTime();

        $comment->setMessage('message')
            ->setCreatedBy($user)
            ->setFigure($figure)
            ->setUpdatedAt($datetime)
            ->setCreatedAt($datetime);

        $this->assertTrue($comment->getMessage() === 'message');
        $this->assertTrue($comment->getCreatedBy() === $user);
        $this->assertTrue($comment->getFigure() === $figure);
        $this->assertTrue($comment->getCreatedAt() === $datetime);
        $this->assertTrue($comment->getUpdatedAt() === $datetime);
    }

    public function testIsFalse(): void
    {
        $comment = new Comment();
        $figure = new Figure();
        $user = new User;
        $datetime = new DateTime();

        $comment->setMessage('message')
            ->setCreatedBy($user)
            ->setFigure($figure)
            ->setUpdatedAt($datetime)
            ->setCreatedAt($datetime);

        $this->assertFalse($comment->getMessage() === 'false');
        $this->assertFalse($comment->getCreatedBy() === new User);
        $this->assertFalse($comment->getFigure() === new Figure);
        $this->assertFalse($comment->getCreatedAt() === new DateTime());
        $this->assertFalse($comment->getUpdatedAt() === new DateTime());
    }

    public function testIsEmpty(): void
    {
        $comment = new Comment();

        $this->assertEmpty($comment->getMessage());
        $this->assertEmpty($comment->getCreatedBy());
        $this->assertEmpty($comment->getFigure());
        $this->assertEmpty($comment->getCreatedAt());
        $this->assertEmpty($comment->getUpdatedAt());
        $this->assertEmpty($comment->getId());
    }
}
