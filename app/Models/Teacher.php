<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'full_name',
        'gender',
        'address',
        'phone_number',
        'specialization',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
