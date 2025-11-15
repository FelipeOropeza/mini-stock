<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'details',
    ];

    public static function write($userId, $action, $details = null)
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
        ]);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
