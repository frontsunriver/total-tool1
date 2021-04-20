<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class NewsToNewsCategory extends Model
{
    //
    use Sortable;


    public function images(){


        return $this->belongsTo('App\Images');


    }

    public function news_categories_description(){


        return $this->belongsTo('App\News_categories_description');


    }

    public $sortbale = ['news_id','created_at'];
    public $sortableAs = ['is_feature'];

}
