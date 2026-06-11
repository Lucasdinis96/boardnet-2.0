<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse(
    $data = null,
    string $message = 'Operação realizada com sucesso.',
    int $status = 200
) {

    $response = [
        'success' => true,
        'message' => $message,
    ];

    if (
        is_array($data)
        && isset($data['data'])
        && isset($data['meta'])
    ) {
        $response['data'] = $data['data'];
        $response['meta'] = $data['meta'];
    } else {
        $response['data'] = $data;
    }

    return response()->json($response, $status);
}

    protected function errorResponse(
        string $message,
        int $status = 400
    ) {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $status);
    }

    protected function paginatedResponse($resource, string $message = 'Dados carregados com sucesso.') {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $resource->items(),
            'meta' => [
                'current_page' => $resource->currentPage(),
                'last_page' => $resource->lastPage(),
                'per_page' => $resource->perPage(),
                'total' => $resource->total(),
            ]
        ]);
    }
}
