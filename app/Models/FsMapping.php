<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'acc_code',
        'fs_group',
        'fs_line',
        'ls',
        'ls_name',
        'mapping_no',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}