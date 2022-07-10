<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    public $fillable = ['name', 'user_id'];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAuthUser($query)
    {
        $query->whereBelongsTo(Auth::user());
    }
}
