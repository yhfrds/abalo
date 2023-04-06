<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbShoppingcart extends Model
{
    use HasFactory;
    protected $table = 'ab_shoppingcart';
    protected $fillable = ['ab_creator_id']; // so that we can use them in our Article::create and Article::update models
    public $timestamps = false; //because we dont have updated_at and created_at
}
