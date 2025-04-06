<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Absen;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str; //tes buat commit

class AbsenController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $image = $request->image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(10) . '.png';

        // Buat struktur path: absen/2025/04/04/
        $year = now()->format('Y');
        $month = now()->format('m');
        $day = now()->format('d');
        $folder = "absen/{$year}/{$month}/{$day}";

        // Simpan file ke folder sesuai tanggal
        Storage::disk('public')->put($folder . '/' . $imageName, base64_decode($image));

        // Simpan path ke database
        Absen::create([
            'image' => $folder . '/' . $imageName,
        ]);

        return response()->json(['message' => 'Absen berhasil disimpan!', 'image' => $imageName]);
    }

    public function proxyToPython(Request $request)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['status' => 'error', 'message' => 'Gambar tidak ditemukan'], 400);
        }

        try {
            $response = Http::attach(
                'image',
                file_get_contents($request->file('image')->getRealPath()),
                $request->file('image')->getClientOriginalName()
            )->post('http://127.0.0.1:5000/recognize');

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghubungi API wajah lokal.',
                'detail' => $e->getMessage()
            ], 500);
        }
    }
}