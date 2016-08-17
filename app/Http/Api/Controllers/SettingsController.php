<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingsController extends Controller
{
    /**
     * @param Request $request
     *
     * @param UserTransformer $transformer
     *
     * @return Response
     */
    public function json(Request $request, UserTransformer $transformer)
    {
        if (! is_null($user = $request->user())) {
            $user = $transformer->transform($user);
            $user['is_admin'] = false;
        }

        $js = 'window.settings = '.json_encode([
            'user' => $user,
            'asset_url' => asset(''),
            'token' => csrf_token(),
            'locale' => app()->getLocale(),
            'config' => config('portal'),
        ], JSON_PRETTY_PRINT);

        return new Response($js, 200, [
            'Content-Type' => 'text/javascript'
        ]);
    }
}
