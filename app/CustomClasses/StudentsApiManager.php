<?php

namespace App\CustomClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class StudentsApiManager
{
    public static function getApiStudentsList(): string
    {
        $response = self::apiCall('api/v1/students', 'GET', [], [], [], [], null);

        return json_decode($response->getStatusCode());
    }

    public static function getApiStudentsListByGroupName(string $groupName): string
    {
        $response = self::apiCall('api/v1/students?groupName=' . $groupName, 'GET', [], [], [], [], null);

        return json_decode($response->getStatusCode());
    }

    public static function createNewStudent(array $studentData): string
    {
        $params['body'] = $studentData;
        $request        = Request::create(
            "api/v1/students",
            "POST",
            $params
        );
        $response       = Route::dispatch($request);

        return json_decode($response->getStatusCode());
    }

    public static function deleteStudentById(int $studentId): string
    {
        $request = Request::create(
            "api/v1/students/{studentId}",
            "POST",
        );
        $request->request->add(['studentId' => $studentId]);
        $response = Route::dispatch($request);

        return json_decode($response->getStatusCode());
    }


    private static function apiCall(
        string $url,
        string $method = 'GET',
        array $parameters = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content
    ): \Symfony\Component\HttpFoundation\Response {
        $request = Request::create(
            $url,
            $method,
            $parameters,
            $cookies,
            $files,
            $server,
            $content
        );

        return Route::dispatch($request);
    }
}