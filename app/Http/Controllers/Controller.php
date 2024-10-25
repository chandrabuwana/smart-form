<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected function logEvent($user, $action, $params, $link, $status)
    {
        DB::table("SMF_EVENT_LOG_HISTORY_ACTION")->insert(
            [
                "user" => $user,
                "action" => $action,
                "params" => $params,
                "part_link" => $link,
                "status_warning" => $status,
                "created_by" => $user,
                "created_at" => now()
            ]
        );
    }
}
