<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class IncidentAnnouncement extends Model
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
        'date_incident',
    ];

    protected $dates = [
        'date_incident',
    ];

    public $sortable = ['title',
    'published',
    'category.name',
    'publisher.name',
    'description',
    'date_incident',
    'created_at'];

    public function category(){
        return $this->belongsTo(IncidentCategory::class,'category_id')->withTrashed();
    }
    public function relatedCategories(){
        return $this->belongsToMany(IncidentCategory::class,'incident_category_incident_announcement')->withTrashed();
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class,'publisher_id')->withTrashed();
    }

}
