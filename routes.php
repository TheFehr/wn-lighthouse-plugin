<?php
Route::group(config('thefehr.lighthouse::route', []), function (): void {
    $routeUri = config('thefehr.lighthouse::route.uri', '/graphql');
    $routeName = config('thefehr.lighthouse::route.name', 'graphql');
    $controller = \Nuwave\Lighthouse\Support\Http\Controllers\GraphQLController::class;

    Route::post($routeUri, [
        'as' => $routeName,
        'uses' => $controller
    ]);

    Route::get($routeUri, [
        'as' => $routeName,
        'uses' => $controller
    ]);
});

Route::get('graphql/schema.graphql', function () {
    return TheFehr\Lighthouse\Models\Settings::get('base_schema');
});
