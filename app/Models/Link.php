<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $table = 'links';
    public $timestamps = false;//if created_at, updated_at don't exist

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'slug',
        'address',
        'transitions_limit',
        'current_transitions',
        'at_work',
        'expiration_date',
    ];
}
