<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'user_id',
        'views',
    ];

    public function countAllArticles()
    {
        return $this->count();
    }

    public function countArticlesOfCurrentMonth()
    {
        return $this->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    }

    public function getFeaturedArticles()
    {
        return $this->orderBy('views', 'desc')->limit(5)->get();
    }
}
