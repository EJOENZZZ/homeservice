<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'recipient_type', 'recipient_id', 'type',
        'title', 'body', 'url', 'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public static function send(string $type, int $id, string $notifType, string $title, string $body = '', string $url = ''): void
    {
        static::create([
            'recipient_type' => $type,
            'recipient_id'   => $id,
            'type'           => $notifType,
            'title'          => $title,
            'body'           => $body,
            'url'            => $url,
            'is_read'        => false,
        ]);
    }
}