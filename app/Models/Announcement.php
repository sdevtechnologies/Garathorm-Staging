<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Announcement extends Model
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
        'date_announcement',
    ];

    protected $dates = [
        'date_announcement',
    ];

    public $sortable = ['title',
    'published',
    'category.name',
    'publisher.name',
    'description',
    'date_announcement',
    'created_at'];

    public function category(){
        return $this->belongsTo(AnnouncementCategory::class,'category_id')->withTrashed();
    }
    public function relatedCategories(){
        return $this->belongsToMany(AnnouncementCategory::class,'announcement_category_announcement')->withTrashed();
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class,'publisher_id')->withTrashed();
    }
}
