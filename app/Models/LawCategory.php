<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class LawCategory extends Model
{
    use HasFactory, SoftDeletes, Sortable;
    protected $connection = 'mysql2';

    protected $fillable = [
        'name'
    ];

    public $sortable = [
        'name'
    ];
}
