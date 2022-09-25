<?php

use Illuminate\Support\Facades\Route;


    function responseSuccess($data = [], $error_msg = null, $status_code = 200, $status = 'success')
    {
        return response()->json([
            "data" => $data,
            "error_msg" => $error_msg,
            "status" => $status,
            "status_code" => $status_code
        ], $status_code);
    }

    function responseFail( $error_msg = null, $status_code = 400,$status = 'fail')
    {
        return response()->json([
            "error_msg" => $error_msg,
            "status" => $status,
            "status_code" => $status_code
        ], $status_code);
    }

    function responseValidation($errors = null, $code = 403)
    {
        return response()->json([
            "status" => false,
            "errors" => $errors,
        ], 403);
    }


    function resultSuccess($data = [], $code = 200)
    {
        return $result = [
            'data' => $data,
            'code' => $code
        ];
    }

    function resultFail($code = 400, $errors = null)
    {
        return $result = [
            "errors" => $errors,
            "code"=>$code
        ];
    }

    function resultValidation($errors = null, $code = 403)
    {
        return $resutl = [
            "errors" => $errors,
            "code" => $code,
        ];
    }


