<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'table_name',
        'columns',
        'filters',
    ];

    protected $casts = [
        'columns' => 'array',
        'filters' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
