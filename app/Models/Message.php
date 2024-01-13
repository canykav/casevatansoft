<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function messageReports(): HasMany
    {
        return $this->hasMany(MessageReport::class);
    }

}
