<?php


if (!function_exists("return_response")) {
    function returnResponse($datas, bool $success = true, int $status = 200, string $message = "", $meta=[])
    {
        return $success ?
            response()->json([
                "success" => $success,
                "status" => $status,
                "message" => $message,
                "data" => $datas,
                "meta" => $meta,
            ]) : response()->json([
                "success" => $success,
                "status" => $status,
                "message" => $message,
                "errors" => $datas
            ]);
    }
}