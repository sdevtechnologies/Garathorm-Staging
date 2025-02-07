<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Knowledgebase extends Model
{
    use HasFactory, SoftDeletes;
    use Sortable;
    protected $connection = 'mysql2';
    protected $fillable = [
        'title',
        'published',
        'publisher_id',
        'description',
        'url_link',
        'date_knowledgebase',
    ];

    protected $dates = [
        'date_knowledgebase',
    ];

    public $sortable = ['title',
    'published',
    'category.name',
    'publisher.name',
    'description',
    'date_knowledgebase',
    'created_at'];

    public function category(){
        return $this->belongsTo(KnowledgebaseCategory::class,'category_id')->withTrashed();
    }
    public function relatedCategories(){
        return $this->belongsToMany(KnowledgebaseCategory::class,'knowledgebase_category_knowledgebase')->withTrashed();
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class,'publisher_id')->withTrashed();
    }
}
