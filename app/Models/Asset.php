<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = ['name', 'description', 'status'];

    protected $appends = [
        'default_thumb',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relationship.
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Setters.
     */
    public function setNameAttribute($val)
    {
        $this->attributes['name'] = $val;
        $this->attributes['slug'] = Str::slug($val);
    }

    public function getDefaultThumbAttribute()
    {
        return $this->defaultImageUrl();
    }

    protected function defaultImageUrl()
    {
        return '/img/default-img-asset.gif'; //'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }
}
