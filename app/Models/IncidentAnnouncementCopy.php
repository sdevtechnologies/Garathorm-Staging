<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class IncidentAnnouncementCopy extends Model
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
        'date_incident',
    ];

    protected $dates = [
        'date_incident',
    ];

    public $sortable = ['title',
    'category.name',
    'publisher.name',
    'description',
    'date_incident'];

    public function category(){
        return $this->belongsTo(IncidentCategory::class,'category_id')->withTrashed();
    }
    public function publisher(){
        return $this->belongsTo(Publisher::class,'publisher_id')->withTrashed();
    }

}
