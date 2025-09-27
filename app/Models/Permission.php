<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
     protected $fillable = ['name','description'];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_permission');
    }
}
