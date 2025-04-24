<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SmartSearchService
{
    private HttpClientInterface $client;
    private string $openAiKey;

    public function __construct(HttpClientInterface $client, string $openAiKey)
    {
        $this->client = $client;
        $this->openAiKey = $openAiKey;
    }

    public function parseQuery(string $query): array
    {
        $prompt = <<<EOT
            Tu es un assistant qui analyse des recherches d’hôtels. Extrais les informations suivantes :
            - city (ville)
            - features (liste des équipements, ex: piscine, wifi, jacuzzi)
            - type (type de chambre ou ambiance, ex: romantique, familiale)
            - toute autre information pertinente, comme les étoiles d'hôtels ou les vues des chambres etc.

            Exemple de réponse attendue :
            {"city": "Marseille", "features": ["piscine"], "type": null}

            Requête : "$query"
            EOT;

        $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->openAiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.2,
            ],
        ]);

        $data = $response->toArray();
        $json = $data['choices'][0]['message']['content'] ?? '{}';

        return json_decode($json, true) ?? [];
    }
}
