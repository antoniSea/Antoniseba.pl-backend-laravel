<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'Images',
        'name',
        'description',
    ];

    public function Images()
    {
        return $this->hasMany(TaskImage::class);
    }
}
