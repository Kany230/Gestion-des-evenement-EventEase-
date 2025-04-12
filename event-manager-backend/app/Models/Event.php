<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'caregory',
        'max_participants',
        'user_id',
    ];

    protected $casts = [
        'satrt_date' =>'datetime',
        'end_date' => 'datetime'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function registrations(){
        return $this->hasMany(Registrationn::class);
    }

    public function participants(){
        return $this->belongsToMany(User::class, 'registrationns');
    }
}
