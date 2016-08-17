<?php

namespace App\Http\Forms;

use App\Comment;
use App\Contracts\CommentableContract;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentForm extends Form
{
    public function rules()
    {
        return [
            'comment' => 'required|string|min:2',
            'to.id' => 'required|integer',
            'to.type' => 'required|string|morph_exist'
        ];
    }

    /**
     * @return Comment
     */
    public function persist()
    {
        $this->isValid();

        $class = get_class_by_type($this->request->input('to.type'));

        $object = (new $class)->findOrFail($this->request->input('to.id'));

        if (! ($object instanceof CommentableContract)) {
            throw new BadRequestHttpException("Class {$class} must be commentable");
        }

        return $object->addComment(
            $this->comment,
            $this->request()->user()
        );
    }
}