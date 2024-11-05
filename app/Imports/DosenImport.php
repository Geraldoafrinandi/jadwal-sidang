<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Jurusan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $errors = [];
            $successCount = 0;

            foreach ($rows as $row) {
                Log::info('Processing row: ', $row->toArray());

                if ($row->filter()->isEmpty()) {
                    Log::warning('Skipping empty row');
                    continue;
                }

                $nama_dosen = $row['nama_dosen'] ?? null;
                $email = $row['email'] ?? null;
                $password = $row['password'] ?? null;

                if ($nama_dosen === null || $email === null || $password === null) {
                    Log::warning('Missing nama, email, or password for row: ', $row->toArray());
                    continue;
                }

                // Periksa apakah NIDN sudah ada
                $existingDosen = Dosen::where('nidn', $row['nidn'])->first();
                if ($existingDosen) {
                    $errors[] = "NIDN " . $row['nidn'] . " sudah ada untuk dosen " . $existingDosen->nama_dosen;
                    Log::warning('Duplicate found for NIDN: ' . $row['nidn']);
                    continue;
                }

                // Ambil data jurusan dan prodi
                $data_jurusan = Jurusan::where('nama_jurusan', $row['jurusan'])->first();
                $data_prodi = Prodi::where('prodi', $row['prodi'])->first();

                // Periksa dan buat pengguna
                $data_user = User::where('email', $email)->first();
                if (!$data_user) {
                    // Buat pengguna baru
                    $data_user = User::create([
                        'name' => $nama_dosen,
                        'email' => $email,
                        'password' => Hash::make($password), // Password di-hash
                    ]);
                    Log::info('Created new user with email: ' . $email);
                }

                // Tentukan nilai gender dan status
                $genderValue = ($row['gender'] === 'Laki-laki') ? '1' : '0';
                $statusValue = $row['status_dosen'] == 'Aktif' ? '1' : '0';

                // Simpan data dosen
                Dosen::create([
                    'nama_dosen' => $nama_dosen,
                    'nidn' => $row['nidn'],
                    'jurusan_id' => $data_jurusan ? $data_jurusan->id_jurusan : null,
                    'prodi_id' => $data_prodi ? $data_prodi->id_prodi : null,
                    'gender' => $genderValue,
                    'status_dosen' => $statusValue,
                    'user_id' => $data_user->id, // Menyimpan user_id ke tabel dosen
                ]);

                Log::info('Inserted dosen with nama: ' . $nama_dosen);
                $successCount++;
            }

            // Jika ada error, lempar exception
            if (!empty($errors)) {
                throw ValidationException::withMessages(['duplicate_data' => $errors]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in collection method: ' . $e->getMessage());
            throw $e;
        }
    }
}
