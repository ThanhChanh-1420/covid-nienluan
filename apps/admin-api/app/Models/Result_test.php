<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Models\User;

class Result_test extends Model
{
    use HasFactory, Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'user_id',
        'create_by',
    ];
    /**
     *   Atrr for the trait filters
     *   @var array
     */
    protected $filterable = [
        'id',
        'status',
        'user_id',
        'create_by',
    ];

    /**
     * Get all of the result_test's image.
     */
    public function image()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    /**
     * Get result_test's user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
     /**
     * Get result_test's user create by.
     */
    public function user_create_by()
    {
        return $this->belongsTo(User::class, 'create_by', 'id');
    }
}
