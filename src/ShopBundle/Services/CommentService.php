<?php


namespace ShopBundle\Services;


use ShopBundle\Entity\Article;
use ShopBundle\Entity\Comment;
use ShopBundle\Entity\User;
use ShopBundle\Repository\CommentRepository;

class CommentService implements CommentServiceInterface
{
    public $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function createComment(Comment $comment, Article $article, User $author)
    {
        $comment->setPost($article);
        $comment->setAuthor($author);
        $this->commentRepository->createComment($comment);
    }

    public function editComment(int $id, Comment $comment)
    {
        /**
         * @var Comment $oldComment
         */
        $oldComment = $this->getSpecificComment($id);
//        var_dump($oldComment->getAuthor());
        $this->commentRepository->editComment($oldComment, $comment);
    }

    public function getSpecificComment(int $id):Comment
    {
        return $this->commentRepository->find($id);
    }

    public function deleteComment(int $id)
    {
        $comment = $this->getSpecificComment($id);
        $this->commentRepository->deleteComment($comment);
    }
}