<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Theme extends Model
{
    /**
     * sortable variable
     *
     * @var array
     */
    public $sortable = [
        'mode',
        'title',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mode',
        'title',
        'pdf',
        'img_preview',
    ];
}
