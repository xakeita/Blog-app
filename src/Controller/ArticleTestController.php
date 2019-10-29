<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("/article")
 */
class ArticleTestController extends AbstractController
{
    /**
     * 記事一覧を取得
     *
     * @Route("/", name="app_article_index")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * 新規登録
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @Route("/new", name="app_article_new", methods={"POST", "GET"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();
                $entityManager->persist($article);
                $entityManager->flush();

                $this->addFlash('success', 'add article');
                return $this->redirectToRoute('app_article_index');
            }
        }
        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * 記事を編集する
     *
     * @Route("/{id}/edit", name="app_article_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();
                $this->addFlash('success', 'edit article');
                return $this->redirectToRoute('app_article_index');
            }
        }
       return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
       ]);
    }

    /**
     * @Route("/{id}/show", name="app_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }


    /**
     * @Route("/{id}/delete", name="app_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager)
    {
        if ($this->isCsrfTokenValid('article_delete', $request->get('_delete_token'))) {
            $entityManager->remove($article);
            $this->addFlash('success', 'delete article');
        }
        return $this->redirectToRoute('app_article_index');
    }


}
