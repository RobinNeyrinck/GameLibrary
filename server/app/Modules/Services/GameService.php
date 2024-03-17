<?php

namespace App\Modules\Services;

use App\Models\Game;
use App\Modules\Services\Service;
use App\Models\GameLanguage;
use Illuminate\Database\Eloquent\Model;

class GameService extends Service
{
    public array $rules = [
        'title' => 'required|max:255',
        'rating' => 'required|numeric',
        'language' => 'required|max:255',
        'description' => 'required|max:255',
        'price' => 'required|numeric',
        'tags' => 'required'
    ];
    protected Model $model;


    public function __construct(Game $model)
    {
        parent::__construct($model);
    }

    public function all($per_page = 10, $language)
    {
        if ($language === 'all' || is_null($language)) {
            $games = $this->model::with('languages')->paginate($per_page);
        } else {
            $games = $this->model::with(['languages' => function ($query) use ($language) {
                $query->where('language', $language);
            }])->paginate($per_page);
        }

        foreach ($games as $game) {
            $this->decodeTags($game->languages);
        }

        return $games;
    }

    public function find($id, $language = 'all')
    {
        if($language === 'all' || is_null($language)) {
            $game =  $this->model->with('languages')->firstWhere('id', $id);
        }
        else {
            $game =  $this->model->with(['languages' => function ($query) use ($language) {
                $query->where('language', $language);
            }])->firstWhere('id', $id);
        }

        if (is_null($game)) {
            return null;
        }

        $this->decodeTags($game->languages);
        return $game;
    }

    public function update($id, $gameData)
    {
        $game = $this->model->firstWhere('id', $id);

        $game->update($gameData);
    }

    public function createGame($data)
    {
        $this->validate($data);

        if ($this->hasErrors()) {
            return [
                'errors' => $this->getErrors()
            ];
        }

        $game = Game::create([
            'title' => $data['title'],
            'rating' => $data['rating'],
            'price' => $data['price']
        ]);

        $gameLanguage = GameLanguage::create([
            'language' => $data['language'],
            'description' => $data['description'],
            'tags' => json_encode($data['tags']),
            'game_id' => $game->id
        ]);

        $game->languages()->save($gameLanguage);

        return $game;
    }

    public function deleteGame($id)
    {
        $game = $this->model->firstWhere('id', $id);
        $game->languages()->delete();
        $game->delete();
    }

    private function decodeTags($languages)
    {
        foreach ($languages as $language) {
            $language->tags = json_decode($language->tags);
        }
    }
}
