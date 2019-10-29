<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * 記事を投稿する
     */
    public function index(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($request->getMethod() === 'POST') {
            $article = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirect('/home');
        } else {
            return $this->render('post/index.html.twig', [
                'message' => '記事投稿フォーム',
                'form' => $form->createView(),
            ]);
        }
    }
}
