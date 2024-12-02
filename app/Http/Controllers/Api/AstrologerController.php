<?php

namespace App\Http\Controllers\Api;

use App\Filament\Resources\AstrologerResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Astrologer\StoreAstrologerRequest;
use App\Http\Requests\Astrologer\UpdateAstrologerRequest;
use App\Models\Astrologer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AstrologerController extends Controller
{
    public function index()
    {
        return Astrologer::all();
    }

    public function store(StoreAstrologerRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $validatedData['profile_image'] = $request->file('profile_image')
                    ->store('astrologer_profiles', 'public');
            }

            $astrologer = Astrologer::create($validatedData);

            return response()->json([
                'message' => 'Astrologer created successfully',
                'data' => new AstrologerResource($astrologer)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating astrologer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
//        $validated = $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|email|unique:astrologers',
//            'experience' => 'required|integer',
//            'specialization' => 'nullable|string',
//        ]);
//
//        $astrologer = Astrologer::create($validated);
//
//        return response()->json($astrologer, 201);


    public function show($id)
    {
        $astrologer = Astrologer::find($id);

        if (!$astrologer) {
            return response()->json(['message' => 'Astrologer not found'], 404);
        }

        return response()->json($astrologer, 200);
    }

    public function update(Request $request, $id)
    {
        $astrologer = Astrologer::find($id);

        if (!$astrologer) {
            return response()->json(['message' => 'Astrologer not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:astrologers,email,' . $id,
            'experience' => 'nullable|integer',
            'specialization' => 'nullable|string',
        ]);

        $astrologer->update($validated);

        return response()->json($astrologer, 200);
    }

    public function destroy($id)
    {
        $astrologer = Astrologer::find($id);

        if (!$astrologer) {
            return response()->json(['message' => 'Astrologer not found'], 404);
        }

        $astrologer->delete();

        return response()->json(['message' => 'Astrologer deleted successfully'], 200);
    }

    // Additional methods
    public function updateAvailability(Request $request, Astrologer $astrologer)
    {
        $request->validate([
            'availability_status' => 'required|in:online,offline,busy'
        ]);

        $astrologer->update([
            'availability_status' => $request->input('availability_status')
        ]);

        return new AstrologerResource($astrologer);
    }
}
