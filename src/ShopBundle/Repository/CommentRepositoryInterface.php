<?php


namespace ShopBundle\Repository;


use ShopBundle\Entity\Comment;

interface CommentRepositoryInterface
{
    public function createComment(Comment $comment);
    public function editComment(Comment $oldComment, Comment $newComment);
    public function deleteComment(Comment $comment);
}