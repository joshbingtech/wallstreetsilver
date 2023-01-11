<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
        $validator = Validator::make($request->all(), [
            'article-thumbnail' => 'required|image|mimes:gif,jpeg,webp,bmp,png',
            'article-title' => 'required',
            'article' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try {
            $thumbnail = $request->file('article-thumbnail');
            $data['thumbnail'] = time().'.'.$thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('/articles'), $data['thumbnail']);
            $data['title'] = $request->input('article-title');
            $data['description'] = $request->input('article');
            $data['user_id'] = Auth::user()->id;
            $data['views'] = 0;

            $article = Article::create($data);
            notify()->success("You've created a new article successfully.");
            return response()->json(["success"=> "You've created a new article successfully."]);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later.']);
        }
    }

    public function editView($article_id)
    {
        $article = Article::find($article_id);
        if($article) {
            $data = [
                'current_nav_tab' => 'articles',
                'article' => $article,
            ];
            return view('admin/editArticle', $data);
        } else {
            abort(404);
        }
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article-id' => 'required|numeric',
            'article-thumbnail' => 'image|mimes:gif,jpeg,webp,bmp,png',
            'article-title' => 'required',
            'article' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try {
            $thumbnail = $request->file('article-thumbnail');
            if($thumbnail) {
                $thumbnail_name = time().'.'.$thumbnail->getClientOriginalExtension();
                $thumbnail->move(public_path('/articles'), $thumbnail_name);

                $article = DB::table('articles')->where('id', $request->input('article-id'))
                    ->update(['thumbnail' => $thumbnail_name, 'title' => $request->input('article-title'), 'description' => $request->input('article'), 'user_id' => Auth::user()->id, 'updated_at' => Carbon::now()]);

            } else {
                $article = DB::table('articles')->where('id', $request->input('article-id'))
                    ->update(['title' => $request->input('article-title'), 'description' => $request->input('article'), 'user_id' => Auth::user()->id, 'updated_at' => Carbon::now()]);
            }

            notify()->success("You've edited a new article successfully.");
            return response()->json(["success"=> "You've edited a new article successfully."]);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later.']);
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
