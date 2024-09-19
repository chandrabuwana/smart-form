<?php

namespace App\Http\Middleware;

use Closure;
use DomainException;
use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use TypeError;
use UnexpectedValueException;

class JwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log::info("coba");
        $isSuccess = false;
        $message = "";
        $errorMessage = "";
        $data = null;
        $httpStatus = 400;

        try {
            $keys = config('app.jwt_secret', '');
            // $authHeader = $header = $request->header('Authorization');
            $bearerToken = $request->bearerToken();
            // Log::info($bearerToken . " | ".$keys);
            if($bearerToken == null) {
                throw new InvalidArgumentException();
            }

            $decoded = JWT::decode($request->bearerToken(), new Key($keys, 'HS256'));
            // Log::info($decoded->nik);
            $isSuccess = true;
        } catch (InvalidArgumentException $e) {
            // provided key/key-array is empty or malformed.
            $errorMessage = ['Unauthorized request'];
            $httpStatus = 401;

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        } catch (DomainException $e) {
            // provided algorithm is unsupported OR
            // provided key is invalid OR
            // unknown error thrown in openSSL or libsodium OR
            // libsodium is required but not available.
            $errorMessage = ['Unauthorized request'];
            $httpStatus = 401;

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        } catch (SignatureInvalidException $e) {
            // provided JWT signature verification failed.
            $errorMessage = ['Unauthorized request'];
            $httpStatus = 401;

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        } catch (BeforeValidException $e) {
            // provided JWT is trying to be used before "nbf" claim OR
            // provided JWT is trying to be used before "iat" claim.
            $errorMessage = ['Unauthorized request'];
            $httpStatus = 401;

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        } catch (ExpiredException $e) {
            $errorMessage = ['Expired session'];
            $httpStatus = 401;

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        } catch (UnexpectedValueException $e) {
            $errorMessage = ['Unauthorized request'];
            $httpStatus = 401;


        } catch (TypeError $e) {
            $errorMessage = ['Terjadi kesalahan, coba beberapa saat lagi'];
            $httpStatus = 500;

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        } catch (Exception $ex) {
            $errorMessage = ['Terjadi kesalahan, coba beberapa saat lagi'];
            $httpStatus = 500;

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        if(!$isSuccess) {
            return response()->json([
                'isSuccess' => $isSuccess,
                'message' => $message,
                'errorMessage' => $errorMessage,
                'data' => $data
            ], $httpStatus);
        };

        $request->attributes->add([
            'nik_from_token' => $decoded->nik ?? null,
            'email_from_token' => $decoded->email ?? null
        ]);


        return $next($request);
    }
}
