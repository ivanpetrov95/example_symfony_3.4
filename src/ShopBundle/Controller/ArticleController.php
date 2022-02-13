<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Article;
use ShopBundle\Entity\Comment;
use ShopBundle\Form\ArticleType;
use ShopBundle\Services\ArticleServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{

    private $articleService;

    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @Route("/article/create", name="create_article")
     */
    public function createArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->articleService->createAnArticle($article, $this->getUser());

            $this->redirectToRoute("profile");
        }
        return $this->render('@Shop/Article/create_article.html.twig', [
            "form" => $form->createView(),
            "errors" => $form->getErrors()
        ]);
    }



//      /**
//     * @Route("/articles", name="view_articles")
//     * @return \Symfony\Component\HttpFoundation\Response|null
//     */
//    public function viewAllArticlesAction()
//    {
//        $user = $this->getUser();
//        $articles = $this->articleService->getAllArticles();
//        return $this->render("@Shop/Article/view_articles.html.twig", ["articles" => $articles, "user" => $user]);
//    }

    /**
     * @Route("/article/{id}", name="view_specific_article")
     * @param int $id
     */
    public function viewSpecificArticleAction(int $id)
    {
        $article = $this->articleService->getSpecificArticle($id);
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['post' => $id]);
        return $this->render("@Shop/Article/view_specific_article.html.twig", ["article" => $article, "comments" => $comments]);
    }

    /**
     * @Route("/article/edit/{id}", name="edit_article")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editArticleAction(int $id, Request $request)
    {

        // TO DO: check if the user is author of the article being edited
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->articleService->editAnArticle($id, $article);
            return $this->redirectToRoute("view_articles");
        }
        return $this->render("@Shop/Article/edit_article.html.twig", [
            "form" => $form->createView(),
            "id" => $id
        ]);
    }

    /**
     * @Route("/ajax/all/articles", name="all_articles")
     */
    public function allArticles(Request $request)
    {
        $user = $this->getUser();
        $allArticles = $this->articleService->getAllArticles();
        if ($request->isXmlHttpRequest())
        {
            $arrayResult = [];
            $arrIndex = 0;
            /**
             * @var Article $article
             */
            foreach($allArticles as $article)
            {
                $tempArr = [
                    'articleTitle' => $article->getTitle(),
                    'articleContent' => $article->getContent(),
                    'articleAuthor' => $article->getAuthorName(),
                    'articleId' => $article->getId()
                ];
                $arrayResult[$arrIndex++] = $tempArr;
            }
            $arrayResult['user'] = $user->getUsername();
            return new JsonResponse($arrayResult);
        }
        else
        {
            return $this->render('@Shop/Article/view_articles.html.twig');
        }
    }
}
