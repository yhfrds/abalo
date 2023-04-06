<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbShoppingcartItem extends Model
{
    use HasFactory;
    protected $table = 'ab_shoppingcart_item';
    protected $fillable = ['ab_shoppingcart_id','ab_article_id'];
    public $timestamps = false;
}
