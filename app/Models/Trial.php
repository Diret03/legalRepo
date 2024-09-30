<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class Trial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'subject_id'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function cases() {
        return $this->hasMany(LegalCase::class);
    }
}
