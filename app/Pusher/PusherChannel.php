<?php

namespace App\Pusher;

class PusherChannel
{
    const PUSHER_CHANNEL_NAME_MAIN_CHAT = 'main-chat';
    const PUSHER_CHANNEL_NAME_MANAGER_CHAT = 'manager-chat';
    const PUSHER_CHANNEL_NAME_APPOINTMENT_CHAT = 'appointment-chat';
    const PUSHER_CHANNEL_NAME_EDUCATION_CHAT = 'education-chat';
    const PUSHER_CHANNEL_NAME_MEDICATION_CHAT = 'medication-chat';

    /**
     * @var array
     */
    private static $channelsList = [
        self::PUSHER_CHANNEL_NAME_MAIN_CHAT,
        self::PUSHER_CHANNEL_NAME_MANAGER_CHAT,
        self::PUSHER_CHANNEL_NAME_APPOINTMENT_CHAT,
        self::PUSHER_CHANNEL_NAME_EDUCATION_CHAT,
        self::PUSHER_CHANNEL_NAME_MEDICATION_CHAT
    ];

    /**
     * @return array
     */
    public static function getChannelsList()
    {
        return self::$channelsList;
    }
}