<?php

namespace App\Http\Controllers;

use OpenAI;
use Illuminate\Http\Request;

class ChatGenerator extends Controller
{
    public function index(Request $request)
    {
        if ($request->title == null) {
            return;
        }

        $title = $request->title;

        $client = OpenAI::client(config('app.openai_api_key'));
        $result = $client->completions()->create([
            "model" => "text-davinci-003",
            "temperature" => 0.7,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            'max_tokens' => 600,
            'prompt' => sprintf('Write article about: %s', $title),
        ]);

        $content = trim($result['choices'][0]['text']);


        return view('index', compact('title', 'content'));
    }
}
