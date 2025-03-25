<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'state', 'registered_agent_type', 'registered_agent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registeredAgent()
    {
        return $this->belongsTo(RegisteredAgent::class, 'registered_agent_id');
    }
}
