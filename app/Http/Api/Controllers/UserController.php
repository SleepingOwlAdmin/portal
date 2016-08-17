<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        return $this->response()->paginator(
            User::paginate(),
            new UserTransformer()
        );
    }

    /**
     * @param Request $request
     * @param null $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function show(Request $request, $id = null)
    {
        if (is_null($id)) {
            $user = $request->user();
        } else {
            $user = User::findOrFail($id);
        }

        return $this->response()->item(
            $user,
            new UserTransformer()
        );
    }
}