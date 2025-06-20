<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ElasticScoutDriverPlus\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;
    protected $fillable = ['title', 'content', 'user_id'];

    // Relationship: Each post belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function toSearchableArray()
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user->id,
            'title'      => $this->title,
            'content'    => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}
