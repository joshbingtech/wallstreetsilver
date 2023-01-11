<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        $article = new Article;
        $data = [
            'featured_articles' => $article->getFeaturedArticles(),
            'articles_for_carousel' => $article->getArticlesForCarousel(),
        ];
        return view('user/dashboard', $data);
    }
}
