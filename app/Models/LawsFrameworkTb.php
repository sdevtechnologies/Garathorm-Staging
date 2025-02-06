<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class LawsFrameworkTb extends Model
{
    use Sortable, SoftDeletes;
    protected $table = 'laws_framework_tb';

    
    protected $connection = 'mysql2';
    protected $fillable = [
        'title',
        'published',
        'publisher_id',
        'description',
        'url_link',
        'date_published',
    ];

    protected $dates = [
        'date_published',
    ];

    public $sortable = ['title','published',
    'description',
    'category.name',
    'publisher.name',
    'date_published',
    'created_at'];

    public function category(){
        return $this->belongsTo(LawCategory::class,'category_id')->withTrashed();
    }
    public function relatedCategories(){
        return $this->belongsToMany(LawCategory::class)->withTrashed();
    }

    public function publisher(){
        return $this->belongsTo(Publisher::class,'publisher_id')->withTrashed();
    }
}
