<?php

namespace App\Http\Controllers;

use App\Enums\Filters;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');

        $belowAge = (int) Arr::get($filter, 'belowAge');
        $religion = Arr::get($filter, 'religion');

        if ($belowAge && $religion)
        {
            $result = User::query()
                ->where('age', '<', $belowAge)
                ->where('religion', $religion)
                ->get();
        }
        else if ($belowAge)
        {
            $query = User::query();
            $filter = Filters::from('belowAge')->create($belowAge);
            $filter->handle($query);
            $result = $query->get();
        } else if ($religion)
        {
            $query = User::query();
            $filter = Filters::from('religion')->create($religion);
            $filter->handle($query);
            $result = $query->get();
        }
        else {
            $result = User::all();
        }


        return new JsonResponse([
            'data' => $result
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
