<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class LegalCase extends Model
{
    use HasFactory, HasTags;

    protected $table = 'cases';

    protected $fillable = [
        'title',
        'date',
        'origin',
        'context',
        'analysis',
        'resolution',
        'trial_id'
    ];

    public function trial(){
        return $this->belongsTo(Trial::class);
    }

}
