<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use OpenAI\Client as OpenAIClient;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = \OpenAI::factory()
            ->withBaseUri('https://open.keyai.shop/v1')
            ->withApiKey(env('OPENAI_API_KEY'))
            ->withHttpClient(new \GuzzleHttp\Client(['timeout' => 60]))
            ->make();
    }

    public function generateQuery($prompt)
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo-16k-0613',
            'messages' => [
                [
                    'role' => 'user',
                    'content' =>
                    "Convert the following job search prompt into a SQL query Note i need to get all the information (like select * from ), column named title,
                        a salary column named max_salary, with a table named careers
                        . Only take 10 newest record base on column named created_at: '{$prompt}'"
                ],
            ],
        ]);

        return $response['choices'][0]['message']['content'] ?? null;
    }

    public function callFunction($prompt, $functions)
    {


        $content = $this->client->chat()->create([
            'model' => 'gpt-4o', // Sử dụng GPT-4 hoặc mô hình khác
            'messages' => [
                [
                    'role' => 'assistant',
                    'content' => 'You are a virtual assistant for a job search system called Job Board'
                ],
                ['role' => 'user', 'content' => $prompt]
            ],
            'functions' => $functions, // Danh sách các function đã định nghĩa
            'function_call' => 'auto' // Để OpenAI tự động gọi function khi cần
        ]);

        return $content;
    }

}
