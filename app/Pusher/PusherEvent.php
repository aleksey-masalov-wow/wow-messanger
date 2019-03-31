<?php

namespace App\Pusher;

class PusherEvent
{
    const PUSHER_EVENT_NAME_CHAT_UPDATED = 'chat-updated';

    /**
     * @var array
     */
    private static $eventsList = [
        self::PUSHER_EVENT_NAME_CHAT_UPDATED,
    ];

    /**
     * @return array
     */
    public static function getEventsList()
    {
        return self::$eventsList;
    }
}