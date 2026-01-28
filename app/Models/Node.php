<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Node extends Model
{
    public $incrementing = false;
    protected $fillable = ['parent_id', 'title', 'created_at'];
    public $timestamps = false; 

    // Relación hijo
    public function children()
    {
        return $this->hasMany(Node::class, 'parent_id');
    }

    // Relación padre
    public function parent()
    {
        return $this->belongsTo(Node::class, 'parent_id');
    }

}