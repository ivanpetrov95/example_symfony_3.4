<?php

namespace ShopBundle\Controller;


use ShopBundle\Entity\Article;
use ShopBundle\Entity\Comment;
use ShopBundle\Entity\User;
use ShopBundle\Form\CommentType;
use ShopBundle\Services\ArticleServiceInterface;
use ShopBundle\Services\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{

    private $commentService;
    private $articleService;

    public function __construct(CommentServiceInterface $commentService, ArticleServiceInterface $articleService)
    {
        $this->commentService = $commentService;
        $this->articleService = $articleService;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/comment/create/{id}", name="create_comment")
     */
    public function createCommentAction(Request $request, int $id): Response
    {
        $comment = new Comment();
        /**
         * @var Article $article
         */
        $article = $this->articleService->getSpecificArticle($id);
        /**
         * @var User $author
         */
        $author = $this->getUser();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $this->commentService->createComment($comment, $article, $author);
            return $this->redirectToRoute("view_articles");
        }
        return $this->render("@Shop/Comment/create_comment.html.twig", ["form" => $form->createView(), "id" => $id]);
    }

    /**
     * @param Request $request
     * @Route("/edit/comment/{id}", name="edit_comment")
     * @param int $id
     * @return Response
     */
    public function editCommentAction(Request $request, int $id): Response
    {
        /**
         * @var Comment $comment
         */
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $this->commentService->editComment($id, $comment);
            return $this->redirectToRoute("view_articles");
        }
        return $this->render("@Shop/Comment/edit_comment.html.twig", ["form" => $form->createView(), "id" => $id]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/comment/delete/{id}", name="delete_comment")
     */
    public function deleteCommentAction(Request $request, int $id)
    {
//        $em = $this->getDoctrine()->getManager();
//        $foundComment = $em->getRepository(Comment::class)->find($id);
//        if(!empty($foundComment))
//        {
//            $em->remove($foundComment);
//            $em->flush();
            $this->commentService->deleteComment($id);
            return $this->redirectToRoute("view_articles");
//        }
    }
}