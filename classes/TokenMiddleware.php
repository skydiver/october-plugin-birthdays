<?php

namespace Martin\Birthdays\Classes;

use App, Closure, Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Martin\MonitorClient\Models\Settings;

class TokenMiddleware {

    public function handle($request, Closure $next) {

        if (Settings::get('disable') == 1) {
            return App::make('Cms\Classes\Controller')->setStatusCode(404)->run('/404');
        }

        if ($request->token != Settings::get('token')) {
            Logs::create(['token' => $request->token, 'result' => 'failed']);
            return App::make('Cms\Classes\Controller')->setStatusCode(404)->run('/404');
        }

        Logs::create(['token' => $request->token, 'result' => 'successful']);

        return $next($request);

    }

}

?>