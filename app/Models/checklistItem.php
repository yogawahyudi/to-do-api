<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class checklistItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='checklist_items';
    protected $fillable = [
        'item_name',
        'completed',
        'checklist_id'
    ];


}

