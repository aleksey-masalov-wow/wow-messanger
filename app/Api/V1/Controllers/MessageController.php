<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use App\Api\V1\Request\MessageStoreRequest;
use App\Api\V1\Request\MessageUpdateRequest;
use App\Api\V1\Responses\Response;
use App\Http\Controllers\Controller;
use App\Model\Message;
use App\Pusher\PusherChannel;
use App\Pusher\PusherEvent;
use Pusher\Pusher;
use Pusher\PusherException;

class MessageController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function get()
    {
        $messages = Message::oldest()->get();

        return Response::get(['messages' => $this->prepareMessagesApiResponse($messages)]);
    }

    /**
     * @param MessageStoreRequest $request
     * @return JsonResponse
     */
    public function create(MessageStoreRequest $request)
    {
        $message = new Message();
        $message->sender_id = (int)$request->input('sender_id');
        $message->channel = $request->input('channel');
        $message->message = $request->input('message');
        $message->save();

        $res = $this->sendMessage($request->input('channel'), PusherEvent::PUSHER_EVENT_NAME_CHAT_UPDATED, $request->input('message'));

        return Response::get(['messages' => []]);
    }

    /**
     * @param MessageUpdateRequest $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(MessageUpdateRequest $request, $id)
    {
        $message = Message::find((int)$id);
        $message->message = $request->input('message');
        $message->save();

        return Response::get(['messages' => []]);
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $message = Message::find((int)$id);
        $message->delete();

        return Response::get(['messages' => []]);
    }

    /**
     * @param Collection $messages
     * @return array
     */
    private function prepareMessagesApiResponse($messages)
    {
        $apiResponse = [];

        foreach ($messages as $message) {
            $messageItem['id'] = (int)$message->id;
            $messageItem['senderId'] = (int)$message->sender_id;
            $messageItem['channel'] = !empty($message->channel) ? $message->channel : '';
            $messageItem['message'] = !empty($message->message) ? $message->message : '';
            $messageItem['createdAt'] = !empty($message->created_at) ? $message->created_at->format('d/m/Y H:i:s') : '';
            $messageItem['updatedAt'] = !empty($message->updated_at) ? $message->updated_at->format('d/m/Y H:i:s') : '';
            $messageItem['userName'] = $message->user ? $message->user->name : '';

            $apiResponse[] = $messageItem;
        }

        return $apiResponse;
    }

    /**
     * @param string $channel
     * @param string $event
     * @param string $message
     * @return bool
     */
    public function sendMessage($channel, $event, $message)
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