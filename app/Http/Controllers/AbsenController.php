<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Absen;
use Illuminate\Support\Str;

class AbsenController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function history()
    {
        $absens = Absen::latest()->get();

        return view('absensi', compact('absens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'face_signature' => 'nullable|string|max:64',
        ]);

        $image = $request->image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $decodedImage = base64_decode($image, true);

        if ($decodedImage === false) {
            return response()->json(['message' => 'Format gambar tidak valid.'], 422);
        }

        $faceSignature = trim((string) $request->face_signature);

        if ($faceSignature !== '') {
            $existingAbsen = Absen::findMatchingFace($faceSignature);

            if ($existingAbsen && $existingAbsen->created_at?->isSameDay(now())) {
                return response()->json([
                    'message' => 'Wajah Anda sudah terdeteksi untuk absensi hari ini.',
                    'duplicate' => true,
                ], 409);
            }
        }

        $imageName = Str::random(10) . '.png';

        $year = now()->format('Y');
        $month = now()->format('m');
        $day = now()->format('d');
        $folder = "absen/{$year}/{$month}/{$day}";

        Storage::disk('public')->put($folder . '/' . $imageName, $decodedImage);

        $absen = Absen::create([
            'image' => $folder . '/' . $imageName,
            'face_signature' => $faceSignature,
        ]);

        return response()->json([
            'message' => 'Absen berhasil disimpan!',
            'id' => $absen->id,
            'image' => $imageName,
            'face_signature' => $absen->face_signature,
        ]);
    }
}