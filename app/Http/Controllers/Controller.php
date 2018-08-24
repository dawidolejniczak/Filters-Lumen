<?php

namespace App\Http\Controllers;

use App\Exceptions\MissingFieldException;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param \Exception $exception
     * @return JsonResponse
     */
    protected function respondWithException(\Exception $exception): JsonResponse
    {
        return response()->json([
            'status' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ], $exception->getCode());
    }

    /**
     * @param Validator $validator
     * @throws MissingFieldException
     * @throws ValidationException
     */
    protected function checkValidation(Validator $validator)
    {
        if ($validator->fails()) {
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
                $message = "Missing required fields: $fields";

                throw new MissingFieldException($message);
            }

            throw new ValidationException(implode(', ', $messages));
        }
    }
}
