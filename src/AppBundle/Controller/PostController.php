<?php
/**
 * Created by PhpStorm.
 * User: eboch
 * Date: 10/23/2017
 * Time: 1:27 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * Show a post by id
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(int $id) {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        if (!$post) {
            throw $this->createNotFoundException('No post found for id ' . $id);
        }

        return $this->render('post/show.html.twig', ['post' => $post]);
    }

    /**
     * Create a new post
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request) {
        if ($request->isMethod('post')) {
            $title = $request->request->get('title');
            $author = $request->request->get('author');
            $text = $request->request->get('text');
            $publication_date = new DateTime();

            $post = new Post();
            $post->setTitle($title)
                ->setAuthor($author)
                ->setText($text)
                ->setPublicationDate($publication_date);

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/new.html.twig');
    }

    /**
     * Edit post by id
     *
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(int $id, Request $request) {
        if ($request->isMethod('post')) {
            $title = $request->request->get('title');
            $author = $request->request->get('author');
            $text = $request->request->get('text');

            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository(Post::class)->find($id);

            if (!$post) {
                throw $this->createNotFoundException(
                    'No post found for id ' . $post
                );
            }

            $post->setTitle($title)
                ->setAuthor($author)
                ->setText($text);

            $em->flush();

            return $this->redirectToRoute('post_show', ['id' => $id]);
        }

        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        return $this->render('post/edit.html.twig', ['post' => $post]);
    }
}