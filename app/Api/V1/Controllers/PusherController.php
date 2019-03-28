<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Api\V1\Responses\Response;
use App\Http\Controllers\Controller;
use App\Pusher\PusherChannel;
use App\Pusher\PusherEvent;
use Pusher\Pusher;
use Pusher\PusherException;

class PusherController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $message = $request->has('message') ? $request->input('message') : '';

        return $this->send(PusherChannel::PUSHER_CHANNEL_NAME_MAIN_CHAT, PusherEvent::PUSHER_EVENT_NAME_MAIN_CHAT_UPDATE, $message)
            ? Response::get()
            : Response::error();
    }

    /**
     * @param string $channel
     * @param string $event
     * @param string $message
     * @return bool
     */
    public function send($channel, $event, $message)
    {
        if (!$this->isValidChannel($channel)) {
            \Log::error('Pusher Channel [' . $channel . '] is not valid!');
            return false;
        }

        if (!$this->isValidEvent($event)) {
            \Log::error('Pusher Event [' . $event . '] is not valid!');
            return false;
        }

        return $this->push($channel, $event, $message);
    }

    /**
     * @param string $channel
     * @return bool
     */
    private function isValidChannel($channel)
    {
        return in_array($channel, PusherChannel::getChannelsList());
    }

    /**
     * @param string $event
     * @return bool
     */
    private function isValidEvent($event)
    {
        return in_array($event, PusherEvent::getEventsList());
    }

    /**
     * @param string $channel
     * @param string $event
     * @param string $message
     * @return bool
     * @throws PusherException
     */
    private function push($channel, $event, $message)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                config('broadcasting.connections.pusher.options.cluster'),
                'useTLS' => true
            ]
        );

        return $pusher->trigger($channel, $event, $message);
    }
}