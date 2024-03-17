<?php

namespace App\Modules\Services;

use App\Models\Language;
use App\Modules\Services\Service;
use Illuminate\Database\Eloquent\Model;

class LanguageService extends Service
{
    protected Model $model;


    public function __construct(Language $model)
    {
        parent::__construct($model);
    }

    public function getLanguage($language)
    {
        if($language === 'all' || is_null($language)){
            $languageData = $this->model->all();
        } else {
            $languageData = $this->model::where('language', $language)->get();
        }

        return $languageData;
    }
}