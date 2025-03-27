<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'points', 'used_points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availablePoints(): int
    {
        return $this->points - $this->used_points;
    }
}