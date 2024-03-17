<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Services\LanguageService;

class LanguageController extends Controller
{
    private LanguageService $_service;
    public function __construct(LanguageService $service)
    {
        $this->_service = $service;
    }

    public function getLanguage()
    {
        $language = request()->query('language');

        $languageData = $this->_service->getLanguage($language);

        return response()->json($languageData);
    }
}
