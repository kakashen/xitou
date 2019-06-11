<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function insert(Request $request)
    {
        return $this->chat->insert($request->toArray());
    }

}
