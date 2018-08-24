<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @param $validator
     * @return JsonResponse
     */
    protected function respondWithErrorMessage($validator): JsonResponse
    {
        $required = $messages = [];
        $validatorMessages = $validator->errors()->toArray();
        foreach ($validatorMessages as $field => $message) {
            if (strpos($message[0], 'required')) {
                $required[] = $field;
            }

            foreach ($message as $error) {
                $messages[] = $error;
            }
        }

        if (count($required) > 0) {
            $fields = implode(', ', $required);
            $message = "Missing required fields $fields";

            return $this->_respondWithMissingField($message);
        }


        return $this->_respondWithValidationError(implode(', ', $messages));
    }


    /**
     * @param $message
     * @return JsonResponse
     */
    private function _respondWithMissingField($message): JsonResponse
    {
        return response()->json([
            'status' => 400,
            'message' => $message,
        ], 400);
    }

    /**
     * @param $message
     * @return JsonResponse
     */
    private function _respondWithValidationError($message): JsonResponse
    {
        return response()->json([
            'status' => 406,
            'message' => $message,
        ], 406);
    }
}
