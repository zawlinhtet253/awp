<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function clients() {
        $clients = Client::with('industryTypes')->get()->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->name,
                'industries' => $client->industryTypes->pluck('name')
            ];
        });

        return response()->json([
            'clients' => $clients
        ]);
    }
}
