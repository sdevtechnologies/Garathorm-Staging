<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class VAPTCategory extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $fillable = [
        'name'
    ];

    public $sortable = [
        'name'
    ];
}
