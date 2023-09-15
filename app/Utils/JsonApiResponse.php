<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonApiResponse
{
    /**
     * Returns a Success response code with a message
     * 
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function ofMessage(string $message, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message
            ],
            $statusCode
        );
    }

    /**
     * Returns a Success response code with data and an optional message
     * 
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function ofData(mixed $data, ?string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data' => $data
            ],
            $statusCode
        );
    }

    /**
     * Returns a Bad Request response code with a message and optional list of errors
     * 
     * @param string $message
     * @param mixed $errors
     * @return JsonResponse
     */
    public static function ofClientError(string $message = "Client Error", mixed $errors = null): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message,
                'errors' => $errors
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * Returns an Unauthorized response code with a message
     * 
     * @param string $message
     * @return JsonResponse
     */
    public static function ofUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Returns a Forbidden response code with a message
     * 
     * @param string $message
     * @param mixed $errors
     * @return JsonResponse
     */
    public static function ofForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message
            ],
            Response::HTTP_FORBIDDEN
        );
    }

    /**
     * Returns a Not Found response code with a message
     * 
     * @param string $message
     * @return JsonResponse
     */
    public static function ofNotFound(string $message = "Not Found"): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Returns a Internal Server Error response code with a message
     * 
     * @param string $message
     * @return JsonResponse
     */
    public static function ofInternalError(string $message = "Server Error"): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    /**
     * Returns an Error response code with a message
     * 
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function ofError(string $message = 'Error', int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message
            ],
            $statusCode
        );
    }
}