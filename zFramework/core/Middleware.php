<?php

namespace zFramework\Core;

class Middleware
{
    /**
     * Check Middlewares
     * @param array $middlewares
     * @param object $callback
     * @return array|int
     */
    public static function middleware(array $middlewares, object $callback = null)
    {
        $declined = [];

        foreach ($middlewares as $middleware) {
            $call = new $middleware();
            if (!call_user_func_array([$call, '__construct'], [])) {
                $declined[] = $middleware;
                if (!$callback) call_user_func_array([$call, 'error'], []);
            }
        }

        return $callback ? $callback($declined) : (count($declined) ? false : true);
    }
}
