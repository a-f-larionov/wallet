<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Базовый контроллер, предоставляет:
 * - методы для формирования ответов клиенту.
 * Class BaseController
 * @package App\Controllers
 */
class BaseController
{
    /**
     * Формирует успешный ответ.
     * Rод ответа: 200 - OK
     * @param array $arrayData string содержимое(бади) ответа
     * @return Response
     */
    public function responseWithSuccess(array $arrayData): Response
    {
        return $this->responseJSON($arrayData, Response::HTTP_OK);
    }

    /**
     * Формирует ответ об ошибке.
     * Код ошибки: 400 - Bad Request
     * @param string $message
     * @return Response
     */
    public function responseWithErrorMessage(string $message = ""): Response
    {
        $content = ['error' => $message];
        return $this->responseJSON($content, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Формирует JSON ответ.
     * @param mixed $data
     * @param int $status
     * @return Response
     */
    public function responseJSON(array $data, $status = Response::HTTP_OK): Response
    {
        return new JsonResponse($data, $status);
    }
}