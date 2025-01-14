<?php

namespace App\Trello\Webhook;

use App\Trello\Webhook\Actions\Updatecard;
use Illuminate\Http\Request;

class Realization
{
    protected const Commands = [
        'updateCard' => Updatecard::class,


    ];

    public function take(Request $request)
    {
//        Cache::forever('webhook-trello',$request->all());
        $action = $request->input('action');

        if(isset($action['type'])) {

            return self::Commands[$action['type']];
       }

        return false;
    }
}
