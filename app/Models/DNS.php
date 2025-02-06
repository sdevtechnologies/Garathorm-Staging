<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class DNS extends Model
{
    use HasFactory, SoftDeletes;
    use Sortable;

    protected $connection = 'mysql2';
    protected $fillable = [
        'title',
        'category',
        'description',
        'url_link',
        'date_issue',
    ];

    protected $dates = [
        'date_issue',
    ];

    public $sortable = ['title',
    'category',
    'description',
    'date_issue'];
}
