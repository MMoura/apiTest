<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $clients = Client::when($q, fn($qB) => $qB->where('name','like',"%{$q}%")->orWhere('email','like',"%{$q}%"))
            ->paginate(15);
        return response()->json($clients);
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        return response()->json($client, 201);
    }

    public function show(Client $client)
    {
        return response()->json($client);
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(null, 204);
    }

    public function orders(Client $client)
    {
        return response()->json($client->orders()->with('products')->paginate(15));
    }
}
