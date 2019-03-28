<?php

namespace App\Pusher;

class PusherEvent
{
    const PUSHER_EVENT_NAME_MAIN_CHAT_UPDATE = 'main-chat-update';
    const PUSHER_EVENT_NAME_MANAGER_CHAT_UPDATE = 'manager-chat-update';
    const PUSHER_EVENT_NAME_APPOINTMENT_CHAT_UPDATE = 'appointment-chat-update';
    const PUSHER_EVENT_NAME_EDUCATION_CHAT_UPDATE = 'education-chat';
    const PUSHER_EVENT_NAME_MEDICATION_CHAT_UPDATE = 'medication-chat';

    /**
     * @var array
     */
    private static $eventsList = [
        self::PUSHER_EVENT_NAME_MAIN_CHAT_UPDATE,
        self::PUSHER_EVENT_NAME_MANAGER_CHAT_UPDATE,
        self::PUSHER_EVENT_NAME_APPOINTMENT_CHAT_UPDATE,
        self::PUSHER_EVENT_NAME_EDUCATION_CHAT_UPDATE,
        self::PUSHER_EVENT_NAME_MEDICATION_CHAT_UPDATE
    ];

    /**
     * @return array
     */
    public static function getEventsList()
    {
        return self::$eventsList;
    }
}