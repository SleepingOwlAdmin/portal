<?php

namespace App\Http\Api\Controllers;

use App\Contracts\LikeableContract;
use App\Http\Api\Transformers\LikeTransformer;
use Dingo\Api\Transformer\Factory;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LikesController extends Controller
{
    /**
     * @param Request $request
     * @param Factory $factory
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request, Factory $factory)
    {
        $object = $this->loadObject($request);

        return $this->response()->collection(
            $object->likes()->with('user')->get(),
            new LikeTransformer()
        );
    }

    /**
     * @param Request $request
     * @param Factory $factory
     *
     * @return mixed
     */
    public function likeOrDislike(Request $request, Factory $factory)
    {
        $object = $this->loadObject($request);
        $user = $request->user();

        if ($object->likedByUser($user)) {
            $object->dislike($user);
        } else {
            $object->like($user);
        }

        $likes = $object->likes()->with('user')->get();

        return $this->response()->array([
            'count' => (int) $object->fresh()->total_likes,
            'likes' => ($likes->count() > 0) ? $factory->transform($likes) : [],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return LikeableContract
     */
    protected function loadObject(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|string|morph_exist',
            'id' => 'required|integer',
        ]);

        $class = get_class_by_type($request->input('type'));

        $object = (new $class)->findOrFail($request->input('id'));

        if (! ($object instanceof LikeableContract)) {
            throw new BadRequestHttpException("Class {$class} must be likeable");
        }

        return $object;
    }
}