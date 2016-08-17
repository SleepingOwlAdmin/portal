<?php

namespace App\Http\Api\Controllers;

use App\Comment;
use App\Contracts\CommentableContract;
use App\Http\Api\Transformers\CommentTransformer;
use App\Http\Forms\CommentForm;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentsController extends Controller
{

    public function index(Request $request)
    {
        $object = $this->loadObject($request);

        return $this->response()->collection(
            $object->comments()->orderBy('created_at', 'asc')->get(),
            new CommentTransformer()
        );
    }

    /**
     * @param int $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        return $this->response()->item(
            Comment::findOrFail($id),
            new CommentTransformer()
        );
    }

    /**
     * @param CommentForm $form
     *
     * @return \Dingo\Api\Http\Response
     */
    public function create(CommentForm $form)
    {
        return $this->response()->item(
            $form->persist(),
            new CommentTransformer()
        );
    }

    /**
     * @param int $id
     *
     * @return \Dingo\Api\Http\Response
     */
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return $this->response()->accepted();
    }

    /**
     * @param Request $request
     *
     * @return CommentableContract
     */
    protected function loadObject(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|string|morph_exist',
            'id' => 'required|integer',
        ]);

        $class = get_class_by_type($request->input('type'));

        $object = (new $class)->findOrFail($request->input('id'));

        if (! ($object instanceof CommentableContract)) {
            throw new BadRequestHttpException("Class {$class} must be commentable");
        }

        return $object;
    }
}