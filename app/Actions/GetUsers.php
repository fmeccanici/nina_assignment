<?php

namespace App\Actions;

use App\Enums\Filters;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUsers
{
    use AsAction;

    public function handle(Collection $filters)
    {
        return app(Pipeline::class)
            ->send(User::query())
            ->through($filters->toArray())
            ->thenReturn()
            ->get();
    }

    public function asController(Request $request)
    {
        $filters = $request->collect('filter')
            ->map(fn (int|string $value, string $filter) =>
            Filters::from($filter)->create($value)
            );

        $result = $this->handle($filters);

        return new JsonResponse([
            'data' => $result->toArray()
        ]);
    }
}
