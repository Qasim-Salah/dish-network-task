<?php


namespace App\Http\Controllers\API\V1;


use Illuminate\Support\Arr;
use phpDocumentor\Reflection\DocBlock\Tags\Link;

/**
 * ResponseBuilder Controller for Return custom message
 */

class ResponseBuilder
{

    /**
     * Return Message Success In Api.
     *
     * @param array $data
     * @param string $message
     * @param int $status
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data, $message = 'OK', $status = 200, $code = 0)
    {
        return response()->json([
            'success' => true,
            'status' => $status,
            'code' => $code,
            'locale' => app()->getLocale(),
            'message' => $message,
            'data' => $data
        ], $status, []);
    }

    /**
     * Return Message Success With Pagination In Api.
     *
     * @param array $data
     * @param Link $links
     * @param string $meta
     * @param string $message
     * @param int $status
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function successWithPagination($data, $links, $meta, $message = 'OK', $status = 200, $code = 0)
    {
        return response()->json([
            'success' => true,
            'status' => $status,
            'code' => $code,
            'locale' => app()->getLocale(),
            'message' => $message,
            'data' => $data,
            'links' => $links,
            'meta' => $meta,
        ], $status, []);
    }

    /**
     * Return Message error With  In Api.
     *
     * @param array $data
     * @param Link $links
     * @param string $meta
     * @param string $message
     * @param int $status
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message, $status = 422, $code = null)
    {
        return response()->json([
            'success' => false,
            'status' => $status,
            'code' => $code,
            'locale' => app()->getLocale(),
            'message' => $message,
            'data' => null
        ], $status, []);
    }


}
