<?php

namespace App\Http\Controllers;

use App\Modules\Services\GameService;
use Illuminate\Http\Request;

class GameApiController extends Controller
{
    private GameService $_service;
    public function __construct(GameService $service)
    {
        $this->_service = $service;
    }

    public function all()
    {
        $title = request()->query('title');
        $tag = request()->query('tag');
        $amount = request()->query('per_page');
        $language = request()->query('language');

        $games = $this->_service->all($amount, $language);

        if (!is_null($title) && $title !== '') {
            return $this->filterByTitle($title, $games);
        } else if (!is_null($tag) && $tag !== 'Any' && $tag !== '') {
            return $this->filterByTag($tag, $games);
        }

        return response()->json($games);
    }

    public function getGameById($id)
    {
        $language = request()->query('language');

        $game = $this->_service->find($id, $language);

        if (is_null($game)) {
            return response(["error" => "game not found"], 404);
        }
        return response()->json($game);
    }

    public function updateGame($id)
    {
        $game = $this->_service->find($id);

        if (is_null($game)) {
            return response(["error" => "game not found"], 404);
        }
        $this->_service->update($id, request()->all());
        return response(['message' => 'game updated', 'data' => $game]);
    }

    public function createGame(Request $request)
    {
        $game = $this->_service->createGame($request->all());

        if ($this->_service->hasErrors()) {
            return response([
                'status' => 400,
                'message' => 'Validation error',
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => 'Game created successfully',
            'data' => $game,
        ], 201);
    }

    public function deleteGame($id)
    {
        if (is_null($this->_service->find($id))) {
            return response(["error" => "game not found"], 404);
        }
        $this->_service->deleteGame($id);
        return response(['message' => 'game deleted']);
    }

    private function filterByTag($tag, $games)
    {
        $games = $games->filter(function ($game) use ($tag) {
            foreach ($game->languages as $language) {
                if (in_array(strtolower($tag), $language->tags)) {
                    return true;
                }
            }
            return false;
        });
        return response()->json($games);
    }

    private function filterByTitle($title, $games)
    {
        $games = $games->filter(function ($game) use ($title) {
            return str_contains(strtolower($game->title), strtolower($title));
        });
        return response()->json($games);
    }
}
