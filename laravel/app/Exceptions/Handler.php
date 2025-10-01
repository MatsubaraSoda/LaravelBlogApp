<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // 如果是后台路由的HTTP异常，使用admin错误页面
        if ($request->is('admin/*') && $exception instanceof HttpException) {
            $status = $exception->getStatusCode();
            
            if (view()->exists("admin.errors.{$status}")) {
                return response()->view("admin.errors.{$status}", [
                    'exception' => $exception
                ], $status);
            }
        }

        return parent::render($request, $exception);
    }
}
