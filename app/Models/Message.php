<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id', 'sender_type', 'sender_id', 'body', 'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function getSenderNameAttribute(): string
    {
        if ($this->sender_type === 'user') {
            return User::find($this->sender_id)?->name ?? 'User';
        }
        if ($this->sender_type === 'professional') {
            $pro = Professional::find($this->sender_id);
            return $pro ? $pro->first_name . ' ' . $pro->last_name : 'Professional';
        }
        return 'Admin';
    }
}