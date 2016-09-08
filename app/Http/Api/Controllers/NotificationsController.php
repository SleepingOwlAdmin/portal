<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Transformers\NotificationTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function recent(Request $request)
    {
        return $this->response()->collection(
            $request->user()->unreadNotifications()->get(),
            new NotificationTransformer()
        );
    }

    /**
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     */
    public function get(Request $request, $id)
    {
        return $this->response()->item(
            $request->user()->unreadNotifications()->find($id),
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

        $request
            ->user()
            ->unreadNotifications()
            ->whereIn('id', $request->input('ids', []))
            ->update(['read_at' => Carbon::now()]);
    }
}