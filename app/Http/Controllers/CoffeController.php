<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coffe;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CoffeController extends Controller
{
    public function index()
    {
        $coffees = Coffe::all();  // Fetch all coffees

        // Prepare the data array
        $dataArray = [];
        foreach ($coffees as $coffee) {
            $dataArray[] = [
                'id' => $coffee->id,
                'name' => $coffee->name,
                'size' => $coffee->size,
                'price' => $coffee->price,
                'image' => $coffee->image,
                'createdAt' => $coffee->created_at->toIso8601String(),
                'updatedAt' => $coffee->updated_at->toIso8601String(),
            ];
        }

        // Prepare the response data
        $responseData = [
            'status' => true,
            'data' => $dataArray,
            'message' => 'Coffee has retrieved',
        ];

        // Return the JSON response
        return response()->json($responseData);
    }


    public function create()
    {
        return view('coffe.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

        $request->validate([
            'name' => 'required',
            'size' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload (optional)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('storage/app/public/images');  // Adjust path as needed
            $image->move($path, $filename);
        } else {
            $filename = null;  // Set filename to null if no image uploaded
        }

        // Create a new coffe instance with filename (if uploaded)
        $coffee = Coffe::create([
            'name' => $request->name,
            'size' => $request->size,
            'price' => $request->price,
            'image' => $filename,  // Save only the filename in the database
        ]);

        $responseData = [
            'status' => true,
            'data' => [
                'id' => $coffee->id,
                'name' => $coffee->name,
                'size' => $coffee->size,
                'price' => $coffee->price,
                'image' => $coffee->image,
                'createdAt' => $coffee->created_at->toIso8601String(),
                'updatedAt' => $coffee->updated_at->toIso8601String(),
            ],
            'message' => 'Coffee has created',
        ];
    
        // Return the JSON response
        return response()->json($responseData);
        
        // return redirect()->route('coffe.index')
        //     ->with('success', 'coffe berhasil ditambahkan.');
    }

    public function show(coffe $coffe)
    {
        return view('coffe.show', compact('coffe'));
    }

    public function edit(coffe $coffe)
    {
        return view('coffe.edit', compact('coffe'));
    }


    // public function update(Request $request, coffe $coffe)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'size' => 'required',
    //         'price' => 'required|numeric',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Allow image update (optional)
    //     ]);

    //     $coffe->update($request->all());  // Update the existing coffe instance

    //     return redirect()->route('coffe.index')
    //                 ->with('success', 'coffe berhasil diperbarui.');
    // }
    
    public function update(Request $req, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'size' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $ubah = Coffe::where('id', $id)->update([
            'name' => $req->input('name'),
            'size'=> $req->input('size'),
            'price' => $req->input('price'),
            'image' => $req->input('image'),
        ]);
        if ($ubah) {
            return response()->json(['status' => true, 'message' => 'berhasil mengedit coffe']);
        } else {
            return response()->json(['status' => false, 'message' => 'gagal mengedit coffe']);
        }
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }
        
        // Find the Coffe instance by its ID
        $coffe = Coffe::findOrFail($id);

        // Delete the Coffe instance
        $coffe->delete();

        // Prepare the response data
        $responseData = [
            'status' => true,
            'data' => $coffe, // Return the deleted coffe data if needed
            'message' => 'Coffee has been deleted',
        ];

        // Return the JSON response
        return response()->json($responseData);
    }

    public function getcoffe($id)
    {
        // Find the Coffe instance by its ID
        $coffe = Coffe::findOrFail($id);

        // Prepare the response data
        $responseData = [
            'status' => true,
            'data' => [
                'id' => $coffe->id,
                'name' => $coffe->name,
                'size' => $coffe->size,
                'price' => $coffe->price,
                'image' => $coffe->image,
                'createdAt' => $coffe->created_at->toIso8601String(),
                'updatedAt' => $coffe->updated_at->toIso8601String(),
            ],
            'message' => 'Coffee details retrieved successfully',
        ];

        // Return the JSON response
        return response()->json($responseData);
    }
}