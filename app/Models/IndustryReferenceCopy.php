<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class IndustryReferenceCopy extends Model
{
    use HasFactory, SoftDeletes;
    use Sortable;

    protected $connection = 'mysql2';
    protected $fillable = [
        'title',
        'category_id',
        'publisher_id',
        'description',
        'url_link',
        'date_published',
    ];

    protected $dates = [
        'date_published',
    ];

    public $sortable = ['title',
    'category.name',
    'publisher.name',
    'description',
    'date_published'];

    public function category(){
        return $this->belongsTo(IndustryCategory::class,'category_id')->withTrashed();
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class,'publisher_id')->withTrashed();
    }
}
