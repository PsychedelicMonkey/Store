<?php

namespace App\Http\Controllers;

use App\Models\Blog\Post;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * Return the post index view.
     */
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->with(['author', 'category', 'media'])
            ->orderByDesc('published_at')
            ->simplePaginate();

        return view('post.index', compact('posts'));
    }

    /**
     * Return the post show view.
     */
    public function show(Post $post): View
    {
        if (! $post->isPublished()) {
            throw new NotFoundHttpException;
        }

        $post->load(['author', 'category', 'media', 'tags']);

        return view('post.show', compact('post'));
    }
}
