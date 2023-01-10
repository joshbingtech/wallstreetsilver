<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        $user = new User;
        $article = new Article;

        $data = [
            'current_nav_tab' => 'dashboard',
            'total_user_records' => $user->countAllRecords(),
            'total_admins' => $user->countAllAdmins(),
            'total_journalists' => $user->countAllJournalists(),
            'total_users' => $user->countAllUsers(),
            'total_articles' => $article->countAllArticles(),
            'total_articles_current_month' => $article->countArticlesOfCurrentMonth(),
            'featured_articles' => $article->getFeaturedArticles(),
        ];
        return view('admin/dashboard', $data);
    }
}
