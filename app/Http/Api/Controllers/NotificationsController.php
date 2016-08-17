<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Transformers\NotificationTransformer;
use App\Repositories\NotificationsRepository;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    /**
     * @var NotificationsRepository
     */
    private $repository;

    /**
     * NotificationsController constructor.
     *
     * @param NotificationsRepository $repository
     */
    public function __construct(NotificationsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function recent(Request $request)
    {
        return $this->response()->collection(
            $this->repository->recent($request->user()),
            new NotificationTransformer()
        );
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function markAsRead(Request $request)
    {
        $this->validate($request, [
            'ids' => 'array'
        ]);

        $this->repository->markAsRead($request->user(), $request->input('ids', []));

        return true;
    }
}