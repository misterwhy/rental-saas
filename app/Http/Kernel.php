protected $routeMiddleware = [
    // ... existing middleware
    'landlord' => \App\Http\Middleware\EnsureUserIsLandlord::class,
];