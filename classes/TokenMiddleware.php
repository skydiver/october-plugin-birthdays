<?php

namespace Martin\Birthdays\Classes;

use App, Closure, Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Martin\Birthdays\Models\Settings;

class TokenMiddleware {

    public function handle($request, Closure $next) {

        if ($request->token != Settings::get('token')) {
            return App::make('Cms\Classes\Controller')->setStatusCode(404)->run('/404');
        }

        return $next($request);

    }

}

?>