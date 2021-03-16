<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Musonza\Chat\Facades\ChatFacade as Chat;

class ChatController extends Controller
{
    public function index()
    {
        // TODO: tampilkan list conversation
    }

    public function createConversation(Request $request)
    {
        $participants = User::whereIn('id', $request->participants)->get()->toArray();
        Chat::createConversation($participants)
            ->makePrivate($request->private)
            ->makeDirect($request->direct);

        return ['message' => 'OK'];
    }

    public function getConversation($id)
    {
        return Chat::conversations()->getById($id);
    }

    public function updateCOnversationDetail(Request $request)
    {
        $conversation = Chat::conversations()->getById($request->id);
        $conversation->update(['data' => $request->only(['title', 'description'])]);
        return $conversation;
    }

    public function sendMessage(Request $request)
    {
        $conversation = Chat::conversations()->getById($request->conversation);

        $message = Chat::message($request->message)
            ->type($request->type ?: 'text')
            ->from(auth()->user())
            ->to($conversation)
            ->send();

        return $message;
    }

    public function merAsRead($id)
    {
        $message = Chat::messages()->getById($id);
        Chat::message($message)->setParticipant(auth()->user())->markRead();
        return ['message' => 'OK'];
    }

    public function unreadMessageCount()
    {
        return Chat::messages()->setParticipant(auth()->user())->unreadCount();
    }

    public function deleteMessage($id)
    {
        $message = Chat::messages()->getById($id);
        Chat::message($message)->setParticipant(auth()->user())->delete();
        return ['message' => 'OK'];
    }

    public function clearConversation($id)
    {
        Chat::conversation($conversation)->setParticipant(auth()->user())->clear();
        return ['message' => 'OK'];
    }
}
