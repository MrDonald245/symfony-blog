<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    private const POSTS_BY_PAGE = 3;

    /**
     * Shows list of added posts separated by pages.
     *
     * @param int $page current page to be shown
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function feedAction(int $page) {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->getPostsPaginator($page);

        $posts_on_page = $posts->getIterator()->count();
        $posts_count = $posts->count();

        // If requested page is bigger then existed one
        // it redirects a user to a page number 1
        if ($posts_on_page === 0) {
            return $this->redirectToRoute('home_feed', ['page' => 1]);
        }

        $maxPages = ceil($posts_count / self::POSTS_BY_PAGE);

        // Passes special arguments to build a pagination
        return $this->render('home/feed.html.twig', compact('posts', 'maxPages', 'page'));
    }

}
