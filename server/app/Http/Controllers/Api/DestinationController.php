<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Resources\PostResource;
use App\Models\Destination;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{

    public function index(Request $request)
    {
        $destination = Destination::with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()->get();

        return new ApiResource(true, 'List Data Destination', $destination);
    }

    public function show($id)
    {

        $destination = Destination::with('category')
            //count and average
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->find($id);

        if ($destination) {
            $reviews = $destination->reviews;
            //return success with Api Resource
            return new ApiResource(true, 'Detail Data Destinasi!', $destination);
        }

        return new ApiResource(true, 'Detail Data Destination Tidak Ditemukan!', null);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'wisata'     => 'required',
            'deskripsi'     => 'required',
            'price'     => 'required',
            'penginapan'     => 'required',
            'openTime'     => 'required',
            'closeTime'     => 'required',
            'access'     => 'required',
            'address'     => 'required',
            'kecamatan'     => 'required',
            'numberPhone'     => 'required',
            'img'     => 'required|image|mimes:jpeg,PNG,png,jpg,gif,svg|max:2048',
            'img_lokasi'     => 'required|image|mimes:jpeg,PNG,png,jpg,gif,svg|max:2048',
            'region_id'     => 'required',
            'business_id'     => 'required',
            'category_id'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imgPath = $request->file('img')->store('images', 'public');
        $imgLokasiPath = $request->file('img_lokasi')->store('images', 'public');

        // $userid = Auth::user()->id;
        $access = is_array($request->access) ? json_encode($request->access) : $request->access;

        $destination = Destination::create([
            'wisata'     => $request->wisata,
            'deskripsi'     => $request->deskripsi,
            'penginapan'     => $request->penginapan,
            'jarak'     => $request->jarak,
            'price'     => $request->price,
            'openTime'     => $request->openTime,
            'closeTime'     => $request->closeTime,
            'access'     => $access,
            'address'     => $request->address,
            'kecamatan'     => $request->address,
            'numberPhone'     => $request->numberPhone,
            'img'     => $imgPath,
            'img_lokasi'     => $imgLokasiPath,
            'status'     => 'Blm Validasi',
            'region_id'     => $request->region_id,
            'business_id'     => $request->business_id,
            'category_id'     => $request->category_id,
            // 'user_id'     => $userid,
        ]);

        if ($destination) {

            // return response 
            return new ApiResource(true, 'Data destination Berhasil Di tambhakan!', $destination);
        }

        return new ApiResource(false, 'Data destination Gagal Di tambhakan!', null);
    }

    public function update(Request $request, Destination $destination)
    {

        $validator = Validator::make($request->all(), [
            'wisata'     => 'required',
            'deskripsi'     => 'required',
            'penginapan'     => 'required',
            'price'     => 'required',
            'openTime'     => 'required',
            'closeTime'     => 'required',
            'access'     => 'required',
            'address'     => 'required',
            'numberPhone'     => 'required',
            'region_id'     => 'required',
            'business_id'     => 'required',
            'category_id'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $imgPath = $destination->img;
        $imgLokasiPath = $destination->img_lokasi;

        if ($request->hasFile('img')) {
            Storage::disk('public')->delete($destination->img);
            $imgPath = $request->file('img')->store('images', 'public');
            $destination->img = $imgPath;
        }

        if ($request->hasFile('img_lokasi')) {
            Storage::disk('public')->delete($destination->img_lokasi);
            $imgLokasiPath = $request->file('img_lokasi')->store('images', 'public');
            $destination->img_lokasi = $imgLokasiPath;
        }

        $destination->update([
            'wisata'     => $request->wisata,
            'deskripsi'     => $request->deskripsi,
            'price'     => $request->price,
            'penginapan'     => $request->penginapan,
            'jarak'     => $request->jarak,
            'openTime'     => $request->openTime,
            'closeTime'     => $request->closeTime,
            'access'     => $request->access,
            'address'     => $request->address,
            'kecamatan'     => $request->address,
            'numberPhone'     => $request->numberPhone,
            'img'     => $imgPath,
            'img_lokasi'     => $imgLokasiPath,
            'status'     => $request->status,
            'region_id'     => $request->region_id,
            'business_id'     => $request->business_id,
            'category_id'     => $request->category_id
        ]);

        if ($destination) {

            return new ApiResource(true, 'Data destination Berhasil Di Update!', $destination);
        }

        return new ApiResource(false, 'Data destination Gagal Di Update!', null);
    }

    public function updateStatus($destination)
    {
        try {
            $status = request('status');

            if (!in_array($status, ['Validasi', 'Blm Validasi'])) {
                throw new \Exception("Status not found", 400);
            }

            $product = Destination::find($destination);

            if (!$product) {
                throw new \Exception("404 Data Not Found", 404);
            }

            $product->status = $status;
            $product->save();

            return response()->json([
                'message' => "Product $product->name with id $product->id has been updated from $product->status to $status",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'name' => 'Error',
                    'message' => $e->getMessage(),
                ],
            ], $e->getCode());
        }
    }

    public function destroy(Destination $destination)
    {
        try {
            // Menghapus file gambar
            Storage::delete('public/' . $destination->img);
            Storage::delete('public/' . $destination->img_lokasi);

            // Menghapus entitas data (Destination)
            $destination->delete();

            return new ApiResource(true, 'Data destination Berhasil Di Hapus!', $destination);
        } catch (\Exception $e) {
            return new ApiResource(false, 'Data destination Gagal Di Hapus!', null);
        }
    }

    public function calculateSAW(Request $request)
    {
        try {
            // Ambil data kriteria dari request
            $selectedCriteria = explode(",", $request->input('criteria'));
            $selectedDestinations = explode(",", $request->input('destinations'));

            // Ambil data kriteria yang dipilih
            $criteria = Kriteria::whereIn('id', $selectedCriteria)->get();

            // Data kriteria bobot
            $weights = [];
            foreach ($criteria as $criterion) {
                $weights[$criterion->nama] = $criterion->bobot;
            }

            // Fetch data destinasi berdasarkan id yang dipilih
            $alternatives = Destination::whereIn('id', $selectedDestinations)
                ->select('id', 'wisata', 'price', 'access', 'penginapan', 'jarak')
                ->addSelect(DB::raw('(SELECT AVG(reviews.rating) FROM reviews WHERE destinations.id = reviews.destination_id) AS reviews_avg_rating'))
                ->get();

            // 1. Menentukan Matriks Keputusan (X)
            $decisionMatrix = [];
            foreach ($alternatives as $alternative) {
                $decisionMatrix[$alternative->id] = [
                    'wisata' => $alternative->wisata,
                    'Keunikan dan Daya Tarik' => $alternative->reviews_avg_rating,
                    'Harga Tiket Masuk' => $alternative->price,
                    'Aksesibilitas Wisata' => $alternative->access,
                    'Jumlah Penginapan' => $alternative->penginapan,
                    'Jumlah Wisata terdekat' => $alternative->jarak,
                ];
            }

            // 2. Menentukan Matriks Normalisasi (R)
            $normalizedMatrix = [];
            foreach ($decisionMatrix as $alternativeId => $criteriaValues) {
                $row = [];
                foreach ($criteriaValues as $criterion => $value) {
                    // Normalisasi masing-masing kriteria
                    $maxValue = floatval(max(array_column($decisionMatrix, $criterion)));
                    $minValue = floatval(min(array_column($decisionMatrix, $criterion)));
                    // Konversi nilai ke tipe data numerik
                    $value = floatval($value);

                    // Handle jika $maxValue sama dengan $minValue
                    if ($maxValue - $minValue == 0) {
                        // Tindakan penanganan di sini, misalnya, set nilai default atau keluar dari perulangan.
                        // Di sini saya set nilai default menjadi 1, namun Anda bisa menyesuaikan sesuai kebutuhan.
                        $row[$criterion] = 1; // Nilai default
                    } else {
                        $row[$criterion] = ($maxValue - $value) / ($maxValue - $minValue);
                    }
                }
                $normalizedMatrix[$alternativeId] = $row;
            }

            // 3. Perhitungan Nilai Preferensi (P)
            $preferences = [];
            foreach ($normalizedMatrix as $alternativeId => $normalizedValues) {
                $v = 0;
                foreach ($normalizedValues as $criterion => $value) {
                    $v += $value * ($weights[$criterion] ?? 1);
                }
                $preferences[$alternativeId] = $v;
            }

            // 4. Perankingan mengambil index Alternatif tertinggi
            arsort($preferences);

            $rankings = [];
            foreach ($preferences as $alternativeId => $preference) {
                $alternative = $alternatives->where('id', $alternativeId)->first();
                $rankings[] = [
                    'id' => $alternative->id,
                    'wisata' => $alternative->wisata,
                    'V' => $preference,
                ];
            }

            $conclusion = "Berdasarkan dari hasil perhitungan kriteria di atas, maka \"" . $rankings[0]['wisata'] . "\" adalah rekomendasi wisata yang paling sesuai untuk dikunjungi dari kriteria wisatawan.";

            return response()->json([
                'success' => true,
                'message' => 'Hasil Perhitungan SAW',
                'data' => [
                    'decision_matrix' => $decisionMatrix,
                    'normalized_matrix' => $normalizedMatrix,
                    'preferences' => $preferences,
                    'rankings' => $rankings,
                    'conclusion' => $conclusion,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating SAW results: ' . $e->getMessage(),
            ], 500);
        }
    }
}
