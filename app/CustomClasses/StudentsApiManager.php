<?php

namespace App\CustomClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class StudentsApiManager
{
    public static function getApiStudentsList(): string
    {
        $response = self::apiCall('api/v1/students');

        return json_decode($response->getStatusCode());
    }

    public static function getApiStudentsListByGroupName(string $groupName): string
    {
        $response = self::apiCall('api/v1/students?groupName=' . $groupName);

        return json_decode($response->getStatusCode());
    }

    public static function createNewStudent(array $studentData): string
    {
        $response = self::apiCall('api/v1/students', 'POST', $studentData);

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
    ): \Symfony\Component\HttpFoundation\Response {
        $request = Request::create(
            $url,
            $method,
            $parameters,
        );


        return Route::dispatch($request);
    }
}