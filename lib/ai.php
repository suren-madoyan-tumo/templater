<?php
require_once __DIR__.'/prompt.php';

function call_openai(array $form): array {
	[$sys, $userJson] = build_prompt($form);

	$payload = [
		"model" => OPENAI_MODEL,
		"messages" => [
			["role" => "system", "content" => $sys],
			["role" => "user", "content" => $userJson]
		],
		"temperature" => 0.7,
		"response_format" => ["type" => "json_object"], // ensures valid JSON
		"max_tokens" => 900
	];

	$ch = curl_init("https://api.openai.com/v1/chat/completions");
	curl_setopt_array($ch, [
		CURLOPT_POST => true,
		CURLOPT_HTTPHEADER => [
			"Authorization: Bearer " . OPENAI_API_KEY,
			"Content-Type: application/json"
		],
		CURLOPT_POSTFIELDS => json_encode($payload),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_TIMEOUT => 120
	]);

	$raw = curl_exec($ch);
	if ($raw === false) throw new Exception("cURL error: " . curl_error($ch));
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($code >= 400) throw new Exception("OpenAI HTTP $code: $raw");

	$data = json_decode($raw, true);
	$content = $data['choices'][0]['message']['content'] ?? '';
	$json = json_decode($content, true);
	if (!$json) throw new Exception("Model did not return valid JSON.");
	return $json;
}
