<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharactersController extends Controller
{
    //
    public function getCharacter()
    {
        $response = Http::withoutVerifying()->get('https://aternia.games/url/sLKZc4');

        if (!$response->ok()) {
            return response()->json(['error' => 'Ошибка получения данных'], 500);
        }

        $html = $response->body();

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        
        // Имя
        $nameNode = $xpath->query('//span[contains(@class, "title_character_name")]')->item(0);
        $name = $nameNode ? $nameNode->nodeValue : null;
        // Инициатива
        $initiativeNode = $xpath->query('//input[@data-branch="stats.initiative"]')->item(0);
        $initiative = $initiativeNode ? trim($initiativeNode->getAttribute('value')) : null;
        
        // Фото
        $imgNode = $xpath->query('//img[@id="character_img"]')->item(0);
        $imgUrl = $imgNode ? $imgNode->getAttribute('src') : null;

        if ($imgUrl && !preg_match('/^https?:\/\//', $imgUrl)) {
            $imgUrl = 'https://aternia.games' . $imgUrl;
        }

        return response()->json([
            'name' => $name,
            'initiative' => $initiative,
            'image' => $imgUrl,
        ]);
    }
}
