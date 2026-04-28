<?php

namespace App\Http\Controllers;

use App\Models\Engagement;
use App\Models\EngagementStaff;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\Clock\now;

class EngagementController extends Controller
{
    public function engagements() {
        $engagements = Engagement::with('client' , 'engagementStaff.user')->get();        
        return response()->json([
            'message' => 'Engagements retrieved successfully',
            'engagements' => $engagements,
        ]);
    }
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'financial_year_end' => 'required|date_format:Y-m-d',
            'contact_name' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = $request->user();
        if($user->role != "partner") {
            return response()->json([
                'message' => 'Unauthorized',
                'user' => $user,
            ], 401);
        }
        $engagement = Engagement::create([
            'client_id' => $request->client_id,
            'financial_year_end' => $request->financial_year_end,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'created_by' => $user->id,
        ]);
        EngagementStaff::create([
            'engagement_id' => $engagement->id,
            'user_id' => $user->id,
            'role_on_engagement' => 'partner',
            'assigned_at' => now(),
            'assigned_by' => $user->id,
            
        ]);
        return response()->json([
            'message' => 'Engagement created successfully',
            'engagement' => $engagement,
        ]);
    }
}
