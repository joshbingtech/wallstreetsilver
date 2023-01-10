<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {

        // Fetch records
        $articles = array();
        $articles = Article::join('users', 'articles.user_id', '=', 'users.id')->get(['articles.*', 'users.name', 'users.profile_avatar_url']);

        $data = [
            'current_nav_tab' => 'articles',
            'articles' => $articles,

        ];
        return view('admin/articles', $data);
    }
    public function createView()
    {
        $data = [
            'current_nav_tab' => 'articles',
        ];
        return view('admin/createArticle', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'article-thumbnail' => 'required|image|mimes:gif,jpeg,webp,bmp,png',
            'article-title' => 'required',
            'article' => 'required'
        ]);

        try {
            $thumbnail = $request->file('article-thumbnail');
            $data['thumbnail'] = time().'.'.$thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('/articles'), $data['thumbnail']);
            $data['title'] = $request->input('article-title');
            $data['description'] = $request->input('article');
            $data['user_id'] = Auth::user()->id;
            $data['views'] = 0;

            $article = Article::create($data);
            return redirect('admin/articles');
        } catch(\Exception $e) {
            return back()->with('error','Something went wrong while uploading file. Please try again later.');
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $article_id = $request->get('article_id');
        $article = Article::where('id', $article_id)->first();
        if($article) {
            $deleted_article = Article::where('id', $article_id)->delete();
            notify()->success("You've deleted the article successfully.");
            return response()->json(['success' => "You've deleted the article successfully."]);
        } else {
            notify()->error('Unable to find an article.');
            return response()->json(['error' => 'Unable to find an article.']);
        }
    }
}
