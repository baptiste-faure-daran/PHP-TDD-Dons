<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'description', 'published_at', 'author'];

    public function user() {
        return $this->belongsTo(User::class, 'author');
    }

    public function authentification()
    {
        $user = User::factory()-> create();

        $response = $this->actingAs($user)
            -> withSession(['foo' => 'bar'])
            -> get ('/');
    }
}
