<?php

namespace App\Http\Controllers\admin;

use App\Models\Facility;
use App\Models\Field;
use App\Models\Photo;
// use App\Http\Controllers\Controller;
use App\Models\FieldPhoto;
use Illuminate\Http\Request;
use App\Models\FieldFacility;
use App\Models\FieldDescription;

use App\Models\FieldFasility_dumb;
// use App\Models\FieldDescription;
// use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class fieldConfiguration extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function fieldPhoto()
    {
        $images = Storage::disk('public')->files('field/images');
        $fieldPhotos = Photo::all();
        return view('admin.field.fieldPhotos', compact('fieldPhotos', 'images'));
    }

    public function fieldDescription()
    {
        $field = Field::first();
        $fieldDescription = $field->description;
        $selectedFacilities = $field->facility->pluck('name')->toArray();
        // dd($fieldFasility);
        // $selectedFacilities = json_decode($fieldFasility, true);

        return view('admin.field.description', compact('fieldDescription', 'selectedFacilities'));
    }

    public function fieldFasility()
    {
        return view('admin.field.fasility');
    }

    public function uploadSlider(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,svg|max:3048',
            'fileIndex' => 'required|integer|min:1|max:3', // Validate the file index
        ]);

        if ($request->file('file')->isValid()) {
            // Determine the file name based on the file index
            $fileIndex = $request->input('fileIndex');
            $fileName = "album_{$fileIndex}." . $request->file('file')->getClientOriginalExtension();

            // Store the file and replace if it already exists
            $filePath = $request->file('file')->storeAs('images/slider', $fileName, 'public');

            return response()->json([
                'success' => true,
                'path' => asset('storage/' . $filePath),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File upload failed!',
        ], 400);
    }

    public function uploadBanner(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,svg|max:3048',
            'fileIndex' => 'required|integer|min:1|max:3', // Validate the file index
        ]);

        if ($request->file('file')->isValid()) {
            // Determine the file name based on the file index
            $fileIndex = $request->input('fileIndex');
            $fileName = "banner_{$fileIndex}." . $request->file('file')->getClientOriginalExtension();

            // Store the file and replace if it already exists
            $filePath = $request->file('file')->storeAs('images/banner', $fileName, 'public');

            return response()->json([
                'success' => true,
                'path' => asset('storage/' . $filePath),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File upload failed!',
        ], 400);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

            // Cek apakah file sudah ada di database
            $existingPhoto = Photo::where('photo', $fileName)->first();
            if (!$existingPhoto) {
                // Simpan file ke folder storage/app/public/field/images
                $path = $file->storeAs('field/images', $fileName, 'public');

                Photo::create([
                    'photo' => $fileName,
                    'id_field' => 1,
                    'title' => 'Gambar lapangan',
                ]);
            } else {
                $path = 'field/images/' . $fileName;
            }

            // Kembalikan path file yang disimpan
            return response()->json(['success' => $fileName, 'path' => $path]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function deleteImage($id)
    {
        $photo = Photo::find($id);

        if ($photo) {
            $filePath = 'field/images/' . $photo->photo;

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);

                // Hapus entri dari database
                $photo->delete();

                return response()->json(['success' => true, 'message' => 'File deleted successfully']);
            }

            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        return response()->json(['success' => false, 'message' => 'Photo not found'], 404);
    }

    // public function deleteImage($id)
    // {
    //     $photo = Photo::find($id);

    //     if ($photo) {
    //         $filePath = 'field/images/' . $photo->photo;

    //         if (Storage::disk('public')->exists($filePath)) {
    //             Storage::disk('public')->delete($filePath);

    //             // Delete the record from the database
    //             $photo->delete();

    //             return response()->json(['success' => true, 'message' => 'File deleted successfully']);
    //         }

    //         return response()->json(['success' => false, 'message' => 'File not found'], 404);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Photo not found'], 404);
    // }



    public function updateDescription(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:2999',
        ]);
        // Assuming you have a single description to update
        $field = Field::first();
        if (!$field) {
            $field = new Field();
        }

        $field->description = $request->input('description');
        $field->save();

        return redirect()->back()->with('success', 'Description updated successfully!');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Description updated successfully!',
        // ]);
    }

    public function updateFasility(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'facilities' => 'array',
            'facilities.*' => 'string'
        ]);

        // Log data yang diterima
        // Log::info('Facilities received:', $request->all());

        // Ambil data fasilitas yang dipilih
        $facilities = $request->input('facilities', []);

        $field = Field::first();
        $id_facilities = [];
        $data = Facility::whereIn('name', $facilities)->get();
        foreach ($data as $facility) {
            $id_facilities[] = $facility->id;
        }
        $field_facility = FieldFacility::whereIn('id_facility', $id_facilities)->pluck('id_facility')->toArray();
        FieldFacility::where('id_field', $field->id)->whereNotIn('id_facility', $id_facilities)->delete();
        foreach ($id_facilities as $id_facility) {
            if (!in_array($id_facility, $field_facility)) {
                FieldFacility::create([
                    'id_field' => $field->id,
                    'id_facility' => $id_facility,
                ]);
            }
        }
        // $field_facility = FieldFacility::create([
        //     'id_field' => $field->id,
        //     'facility' => json_encode($facilities),
        // ]);

        // $field_facility = FieldFacility::where('id_field', $field->id)->get();
        // $field->facility = json_encode($facilities);

        // Misalnya, Anda ingin menyimpan fasilitas ke dalam model FieldFasility_dumb
        // $field = FieldFasility_dumb::first(); // Sesuaikan dengan logika Anda
        // if (!$field) {
        //     $field = new FieldFasility_dumb();
        // }
        // $field->facilities = json_encode($facilities); // Simpan sebagai JSON
        // $field->save();

        return response()->json(['message' => 'Facilities updated successfully']);
    }
}
