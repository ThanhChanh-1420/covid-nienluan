<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'url',
        'imageable_id',
        'imageable_type',
    ];
    /**
     * Get the parent imageable model;
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
