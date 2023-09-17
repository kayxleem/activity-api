<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded= [];

    public function user_activity():HasMany
    {
        return $this->hasMany(UserActivity::class, 'activity_id', 'id');
    }

    public function scopeFrom(Builder $query, $date): Builder
    {
        return $query->where('activity_date', '>=', Carbon::parse($date));
    }

    public function scopeTo(Builder $query, $date): Builder
    {
        return $query->where('activity_date', '<=', Carbon::parse($date));
    }

    public function scopeActivityDate(Builder $query, $date): Builder
    {
        return $query->where('activity_date', 'LIKE', '%' . $date . '%');
    }
}
