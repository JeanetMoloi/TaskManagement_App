<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Line 1: Import the tool
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // Line 2: Use the tool

    protected $fillable = ['title', 'description', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
