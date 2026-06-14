<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
}
