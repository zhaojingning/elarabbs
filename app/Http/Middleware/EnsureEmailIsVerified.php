<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->user(), $request->user()->hasVerifiedEmail(), $request->is('email/*', 'logout'));
        // 三个判断
        // 如果用户已经登录
        // 并且还未认证 Email
        // 并且访问的不是Email 验证相关URL 或者推出的URL
        if($request->user() && !$request->user()->hasVerifiedEmail() && ! $request->is('email/*', 'logout')) {

            // 根据客户端返回对应的内容
            return $request->expectsJson() ? abort(403, 'Your email address is not verified.') :redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
