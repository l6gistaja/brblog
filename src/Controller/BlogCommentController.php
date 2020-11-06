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
		$blogComment->setHidden(0);
		$blogComment->setBlogpost($this->getDoctrine()
			->getRepository(BlogPost::class)
			->find($request->get('blogpost')));
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($blogComment);
		$entityManager->flush();
		return new JsonResponse(array('l' => __LINE__));
    }
	
	/**
     * @Route("/updates", name="blog_comment_updates", methods={"GET","POST"})
     */
    public function updates(Request $request): Response
    {
		return new JsonResponse($this->getDoctrine()->getRepository(BlogComment::class)->findUpdates(
			$request->get('post'),
			$request->get('last')
		));
    }
	
	/**
     * @Route("/delete", name="blog_comment_delete", methods={"GET","POST"})
     */
    public function delete(Request $request): Response
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN');
		$entityMgr = $this->getDoctrine()->getManager();
		$entityMgr->remove($this->getDoctrine()
			->getRepository(BlogComment::class)
			->find($request->get('id')));
		$entityMgr->flush();
		return new JsonResponse(array('l' => __LINE__));
    }
	
	/**
     * @Route("/hide", name="blog_comment_hide", methods={"GET","POST"})
     */
    public function hide(Request $request): Response
    {
		$this->denyAccessUnlessGranted('ROLE_ADMIN');
		$entityManager = $this->getDoctrine()->getManager();
		$blogComment = $entityManager->getRepository(BlogComment::class)->find($request->get('id'));
		$blogComment->setHidden($request->get('hide'));
		$entityManager->flush();
		return new JsonResponse(array('l' => __LINE__));
    }

}
