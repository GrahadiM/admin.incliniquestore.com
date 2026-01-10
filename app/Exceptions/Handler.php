<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Daftar exception yang tidak dilaporkan.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Daftar input yang tidak pernah ditampilkan kembali pada validasi error.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Laporkan atau kirim exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render exception menjadi response HTTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Tangani semua HttpException (403, 404, 500, dll)
        if ($exception instanceof HttpExceptionInterface) {
            $status = $exception->getStatusCode();
            $message = $exception->getMessage() ?: Response::$statusTexts[$status] ?? 'Terjadi kesalahan pada server.';

            // Jika ada view spesifik errors/{status}.blade.php
            if (view()->exists("errors.{$status}")) {
                return response()->view("errors.{$status}", [
                    'exception' => $exception,
                    'status' => $status,
                    'message' => $message,
                ], $status);
            }

            // Fallback ke errors.default.blade.php
            if (view()->exists('errors.default')) {
                return response()->view('errors.default', [
                    'exception' => $exception,
                    'status' => $status,
                    'message' => $message,
                ], $status);
            }

            // Jika tidak ada view sama sekali, gunakan response standar Laravel
            return parent::render($request, $exception);
        }

        // Tangani semua exception lain
        return parent::render($request, $exception);
    }
}
