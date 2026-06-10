<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(
        protected OpenAIService $openAIService
    ) {}

    public function ask(Request $request) {
        $request->validate([
            'message' => 'required|string'
        ]);

        $reply = $this->openAIService->ask($request->message);
        return response()->json(['reply' => $reply]);
    }
}
