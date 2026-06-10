<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public function ask($prompt)
    {
        $model = env('CLOUDFLARE_MODEL', '@cf/openai/gpt-oss-120b');
        $requestBody = [
            'model' => $model,
            'temperature' => 0.2,
            'max_output_tokens' => 400,
            'input' => [
                'prompt' => "Bạn là trợ lý tư vấn mua hàng. Trả lời bằng tiếng Việt, ngắn gọn và rõ ràng. Nếu người dùng chỉ bày tỏ cảm nhận, hãy trả lời phù hợp mà không hỏi thêm. Nếu cần hỏi thêm thì chỉ hỏi một câu và không lặp lại cùng nội dung.\n\nYêu cầu: {$prompt}\n\nTrả lời:",
            ]
        ];

        $response = Http::withToken(env('CLOUDFLARE_API_KEY'))
            ->post('https://api.cloudflare.com/client/v4/accounts/' . env('CLOUDFLARE_ACCOUNT_ID') . '/ai/run', $requestBody);

        $body = $response->json();
        Log::info('CF status: ' . $response->status());
        Log::info('CF body: ' . $response->body());

        if (!$response->successful()) {
            Log::error('CF ask failed', ['status' => $response->status(), 'body' => $body]);
            return 'Xin lỗi, trợ lý hiện đang gặp sự cố. Vui lòng thử lại sau.';
        }

        if (isset($body['result']['choices'][0]['text'])) {
            return $this->normalizeResponse($body['result']['choices'][0]['text']);
        }

        if (isset($body['result']['response'])) {
            return $this->normalizeResponse($body['result']['response']);
        }

        if (isset($body['result']['output'][0]['content'])) {
            return $this->normalizeResponse($body['result']['output'][0]['content']);
        }

        if (isset($body['result']['output_text'])) {
            return $this->normalizeResponse($body['result']['output_text']);
        }

        Log::error('CF ask unexpected response format', ['body' => $body]);
        return 'Xin lỗi, tôi không thể phản hồi lúc này.';
    }

    protected function normalizeResponse(string $text): string
    {
        $text = str_replace(['\\n', '\\r', '\\t'], ["\n", "\r", "\t"], $text);
        $text = strip_tags($text);
        $text = preg_replace('/\*\*([^*]+)\*\*/', '$1', $text);
        $text = preg_replace('/<[^>]+>/', '', $text);

        $lines = preg_split('/\r?\n/', $text);
        $cleanLines = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                if (empty($cleanLines) || end($cleanLines) === '') {
                    continue;
                }
                $cleanLines[] = '';
                continue;
            }
            if (!empty($cleanLines) && $line === end($cleanLines)) {
                continue;
            }
            $cleanLines[] = $line;
        }

        $text = implode("\n", $cleanLines);
        $text = preg_replace('/(.*?)(?:\n\1)+/s', '$1', $text);
        $text = trim($text);
        return $text;
    }
}
