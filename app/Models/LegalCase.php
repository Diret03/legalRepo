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
        'user_id',
        'trial_id',
        'title',
        'date',
        'origin',
        'status',
        'context',
        'analysis',
        'resolution',
        'note',
    ];

    public function getStatusAttribute($value)
    {
        $statuses = [
            'accepted' => 'Aceptado',
            'pending' => 'Pendiente',
            'rejected' => 'Rechazado',
        ];

        return $statuses[$value] ?? $value;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trial(){
        return $this->belongsTo(Trial::class);
    }
}
