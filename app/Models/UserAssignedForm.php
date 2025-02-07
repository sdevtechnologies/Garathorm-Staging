<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class KnowledgebaseCategory extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $connection = 'mysql2';
    protected $fillable = [
        'name',
        'status'
    ];

    public $sortable = [
        'name'
    ];
}
