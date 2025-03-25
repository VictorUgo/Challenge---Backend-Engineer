<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RegisteredAgent extends Model
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'state', 'name', 'email', 'capacity',
    ];

    public function companies()
    {
        return $this->hasMany(Company::class, 'registered_agent_id');
    }
}
