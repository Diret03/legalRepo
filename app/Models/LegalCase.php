<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalCase extends Model
{
    use HasFactory, HasTags, SoftDeletes;

    protected $table = 'cases';
    protected $fillable = [
        'user_id',
        'trial_id',
        'title',
        'status',
        'context',
        'analysis',
        'resolution',
        'note',
        'rejection_message',
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
