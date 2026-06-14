<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik', 'nama', 'email', 'phone',
        'jabatan', 'divisi', 'tanggal_masuk',
        'status', 'atasan_id', 'photo',
    ];

    public function atasan()
    {
        return $this->belongsTo(Employee::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(Employee::class, 'atasan_id');
    }
}
