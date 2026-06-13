<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $searchQuery = $request->string('q')->trim()->toString();
        $activeCategory = $request->string('category')->trim()->toString();
        $activeTag = $request->string('tag')->trim()->toString();

        $categories = BlogCategory::active()
            ->withCount('publishedPosts')
            ->orderBy('order')
            ->get();

        $postsQuery = BlogPost::published()->with('category', 'author');

        if ($searchQuery !== '') {
            $postsQuery->search($searchQuery);
        }

        if ($activeCategory !== '') {
            $postsQuery->whereHas('category', fn ($q) => $q->where('slug', $activeCategory));
        }

        if ($activeTag !== '') {
            $postsQuery->whereHas('tags', fn ($q) => $q->where('slug', $activeTag));
        }

        $featuredPost = BlogPost::published()
            ->with('category', 'author')
            ->where('is_featured', true)
            ->latest('published_at')
            ->first();

        if (! $featuredPost) {
            $featuredPost = BlogPost::published()->with('category', 'author')->latest('published_at')->first();
        }

        $posts = $postsQuery->latest('published_at')->paginate(9)->withQueryString();

        $recentPosts = BlogPost::published()
            ->with('category')
            ->latest('published_at')
            ->take(4)
            ->get();

        $popularTags = BlogTag::active()
            ->where('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->take(12)
            ->get();

        $stats = [
            'posts' => BlogPost::published()->count(),
            'categories' => $categories->count(),
        ];

        return view('frontend.pages.blog', compact(
            'posts',
            'categories',
            'featuredPost',
            'recentPosts',
            'popularTags',
            'stats',
            'searchQuery',
            'activeCategory',
            'activeTag'
        ));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)->published()->with('category', 'author', 'tags')->firstOrFail();
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->with('category')
            ->latest('published_at')
            ->take(4)
            ->get();
        $categories = BlogCategory::active()->withCount('publishedPosts')->orderBy('order')->get();
        $prevPost = BlogPost::published()->where('published_at', '>', $post->published_at)->latest('published_at')->first();
        $nextPost = BlogPost::published()->where('published_at', '<', $post->published_at)->oldest('published_at')->first();

        return view('frontend.pages.blog-detail', compact('post', 'recentPosts', 'categories', 'prevPost', 'nextPost'));
    }
}
