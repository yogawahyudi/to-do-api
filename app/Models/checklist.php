<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class checklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'checklists';

    protected $fillable = [
        'name'
    ];

    /**
     * Get all of the checklistItems for the checklist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistItems(): HasMany
    {
        return $this->hasMany(checklistItem::class, 'checklist_id', 'id');
    }
}
