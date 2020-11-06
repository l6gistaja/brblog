<?php

namespace App\Controller;

use App\Entity\BlogComment;
use App\Entity\BlogPost;
use App\Repository\BlogCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/blog/comment")
 */
class BlogCommentController extends AbstractController
{

    /**
     * @Route("/new", name="blog_comment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blogComment = new BlogComment();
		$blogComment->setBody($request->get('body'));
		$blogComment->setBlogpost($this->getDoctrine()
			->getRepository(BlogPost::class)
			->find($request->get('blogpost')));
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($blogComment);
		$entityManager->flush();
		return new JsonResponse(array('l' => __LINE__));
    }

}
