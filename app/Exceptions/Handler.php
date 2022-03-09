<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use jeremykenedy\LaravelRoles\App\Exceptions\LevelDeniedException;
use jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException;
use jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(static function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|Response|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|RedirectResponse
    {
        $userLevelCheck = $e instanceof RoleDeniedException ||
            $e instanceof PermissionDeniedException ||
            $e instanceof LevelDeniedException;

        if ($userLevelCheck) {
            $error_msg = 'Você não tem permissão para acessar esta área';
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'error' => 403,
                        'message' => $error_msg
                    ],
                    403
                );
            }

            flash('<i class="fa fa-ban"></i> ' . $error_msg, 'warning');

            return back();
        }

        return parent::render($request, $e);
    }
}
