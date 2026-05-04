<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\IndustryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function clients() {
        $clients = Client::with('industryTypes')->get()->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->name,
                'registration_number' => $client->registration_number,
                'address' => $client->address,  
                'phone' => $client->phone,
                'active' => $client->active,
                'industries' => $client->industryTypes->pluck('name')
            ];
        });

        return response()->json([
            'clients' => $clients
        ]);
    }
    public function client($id) {
        $client = Client::with('industryTypes')->findOrFail($id);
        return response()->json([
            'client' => $client
        ]);
    }
    public function create(Request $request) {
        
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'registration_number' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'industry_types' => 'nullable|array',
            'industry_types.*' => 'exists:industry_types,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $client = Client::create([
            'name' => $request->name,
            'registration_number' => $request->registration_number,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'active' => true,
            'industry_types' => $request->industry_types,
        ]);
        
        // Attach industry types if provided
        if ($request->has('industry_types') && !empty($request->industry_types)) {
            $client->industryTypes()->attach($request->industry_types);
        }
        
        // Load the industry types for the response
        $client->load('industryTypes');
        
        return response()->json([
            'message' => 'Client created successfully',
            'client' => $client
        ]);
    }
    public function update(Request $request, $id) {
        $client = Client::find($id);
        
        if (!$client) {
            return response()->json([
                'message' => 'Client not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'registration_number' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'active' => 'required|boolean',
            'industry_types' => 'nullable|array',
            'industry_types.*' => 'exists:industry_types,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $client->update($request->all());
        
        // Sync industry types if provided
        if ($request->has('industry_types') && !empty($request->industry_types)) {
            $client->industryTypes()->sync($request->industry_types);
        }
        
        // Load the industry types for the response
        $client->load('industryTypes');
        
        return response()->json([
            'message' => 'Client updated successfully',
            'client' => $client
        ]);
    }

    public function industryTypes() {
        $industryTypes = IndustryType::all();
        return response()->json([
            'industryTypes' => $industryTypes
        ]);
    }
}
