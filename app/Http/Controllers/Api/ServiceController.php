<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Session::with(['tutor', 'category'])
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'title' => $service->title,
                    'price' => $service->price,
                    'tutor' => $service->tutor ? $service->tutor->name : null,
                    'category' => $service->category ? $service->category->name : null,
                ];
            });
        return response()->json(['data' => $services]);
    }
} 