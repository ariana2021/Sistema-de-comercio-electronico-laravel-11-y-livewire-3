<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content'];

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }
}
