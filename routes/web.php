<?php

use App\Models\MhsPkl;
use App\Models\BimbinganPkl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\MhsPklController;
use App\Http\Controllers\VerPklController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\NilaiPklController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\TempatPKLController;
use App\Http\Controllers\UsulanPklController;
use App\Http\Controllers\BimbinganPklController;
use App\Http\Controllers\JadwalSidangController;
use App\Http\Controllers\JabatanPimpinanController;
use App\Http\Controllers\NilaiPembimbingController;
use App\Http\Controllers\KonfirmasiUsulanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/grafik', [BackendController::class, 'index'])->name('backend.index');


Route::get('/backend', function () {
    return view('admin.layout.main');
})->middleware('auth');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('profile.image.update');
Route::delete('/profile/image/delete', [ProfileController::class, 'destroyImage'])->name('profile.image.delete');



Route::get('/login', [LoginController::class, 'create'])->name('login.create');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::get('/mahasiswa/{id_mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
Route::put('/mahasiswa/{id_mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
Route::delete('/mahasiswa/{id_mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
Route::get('/mahasiswa/{id_mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
Route::get('/mahasiswa/export/excel', [MahasiswaController::class, 'export'])->name('mahasiswa.export.excel');
Route::post('/mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');




Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
Route::post('/dosen', [DosenController::class, 'store'])->name('dosen.store');
Route::get('/dosen/{id_dosen}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
Route::put('/dosen/{id_dosen}', [DosenController::class, 'update'])->name('dosen.update');
Route::delete('/dosen/{id_dosen}', [DosenController::class, 'destroy'])->name('dosen.destroy');
Route::get('/dosen/{id_dosen}', [DosenController::class, 'show'])->name('dosen.show');
Route::get('/dosen/export/excel', [DosenController::class, 'export'])->name('dosen.export');
Route::post('/dosen/import', [DosenController::class, 'import'])->name('dosen.import');



Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi.index');
Route::get('/prodi/create', [ProdiController::class, 'create'])->name('prodi.create');
Route::post('/prodi', [ProdiController::class, 'store'])->name('prodi.store');
Route::get('/prodi/{id_prodi}/edit', [ProdiController::class, 'edit'])->name('prodi.edit');
Route::put('/prodi/{id_prodi}', [ProdiController::class, 'update'])->name('prodi.update');
Route::delete('/prodi/{id_prodi}', [ProdiController::class, 'destroy'])->name('prodi.destroy');
Route::get('/prodi/export/excel', [ProdiController::class, 'export'])->name('prodi.export');


Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
Route::get('/jurusan/{id_jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
Route::put('/jurusan/{id_jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
Route::delete('/jurusan/{id_jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');


Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
Route::get('/ruangan/{id_ruangan}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
Route::put('/ruangan/{id_ruangan}', [RuanganController::class, 'update'])->name('ruangan.update');
Route::delete('/ruangan/{id_ruangan}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');



Route::get('/sesi', [SesiController::class, 'index'])->name('sesi.index');
Route::get('/sesi/create', [SesiController::class, 'create'])->name('sesi.create');
Route::post('/sesi', [SesiController::class, 'store'])->name('sesi.store');
Route::get('/sesi/{id_sesi}/edit', [SesiController::class, 'edit'])->name('sesi.edit');
Route::put('/sesi/{id_sesi}', [SesiController::class, 'update'])->name('sesi.update');
Route::delete('/sesi/{id_sesi}', [SesiController::class, 'destroy'])->name('sesi.destroy');



Route::get('/jabatan_pimpinan', [JabatanPimpinanController::class, 'index'])->name('jabatan_pimpinan.index');
Route::get('/jabatan_pimpinan/create', [JabatanPimpinanController::class, 'create'])->name('jabatan_pimpinan.create');
Route::post('/jabatan_pimpinan', [JabatanPimpinanController::class, 'store'])->name('jabatan_pimpinan.store');
Route::get('/jabatan_pimpinan/{id_jabatan_pimpinan}/edit', [JabatanPimpinanController::class, 'edit'])->name('jabatan_pimpinan.edit');
Route::put('/jabatan_pimpinan/{id_jabatan_pimpinan}', [JabatanPimpinanController::class, 'update'])->name('jabatan_pimpinan.update');
Route::delete('/jabatan_pimpinan/{id_jabatan_pimpinan}', [JabatanPimpinanController::class, 'destroy'])->name('jabatan_pimpinan.destroy');



Route::get('/pimpinan', [PimpinanController::class, 'index'])->name('pimpinan.index');
Route::get('/pimpinan/create', [PimpinanController::class, 'create'])->name('pimpinan.create');
Route::post('/pimpinan', [PimpinanController::class, 'store'])->name('pimpinan.store');
Route::get('/pimpinan/{id_pimpinan}/edit', [PimpinanController::class, 'edit'])->name('pimpinan.edit');
Route::put('/pimpinan/{id_pimpinan}', [PimpinanController::class, 'update'])->name('pimpinan.update');
Route::delete('/pimpinan/{id_pimpinan}', [PimpinanController::class, 'destroy'])->name('pimpinan.destroy');
Route::get('/pimpinan/{id_pimpinan}', [PimpinanController::class, 'show'])->name('pimpinan.show');
Route::get('/pimpinan/export/excel', [PimpinanController::class, 'export'])->name('pimpinan.export');

Route::get('/tempat_pkl', [TempatPKLController::class, 'index'])->name('tempat_pkl.index');
Route::get('/tempat_pkl/create', [TempatPKLController::class, 'create'])->name('tempat_pkl.create');
Route::post('/tempat_pkl', [TempatPKLController::class, 'store'])->name('tempat_pkl.store');
Route::get('/tempat_pkl/{id}/edit', [TempatPKLController::class, 'edit'])->name('tempat_pkl.edit');
Route::put('/tempat_pkl/{id}', [TempatPKLController::class, 'update'])->name('tempat_pkl.update');
Route::delete('/tempat_pkl/{id}', [TempatPKLController::class, 'destroy'])->name('tempat_pkl.destroy');

Route::get('usulan_pkl', [UsulanPklController::class, 'index'])->name('usulan_pkl.index');
Route::get('usulan_pkl/create', [UsulanPklController::class, 'create'])->name('usulan_pkl.create');
Route::post('usulan_pkl', [UsulanPklController::class, 'store'])->name('usulan_pkl.store');
Route::get('usulan_pkl/{id}/edit', [UsulanPklController::class, 'edit'])->name('usulan_pkl.edit');
Route::put('usulan_pkl/{id}', [UsulanPklController::class, 'update'])->name('usulan_pkl.update');
Route::delete('/usulan_pkl/{id}', [UsulanPKLController::class, 'destroy'])->name('usulan_pkl.destroy');
// Route::put('/usulan_pkl/{usulan_pkl}/assign_dosen', [UsulanPklController::class, 'assignDosen'])->name('usulan_pkl.assign_dosen');
Route::post('/usulan-pkl/{id}/konfirmasi', [UsulanPklController::class, 'konfirmasi'])->name('usulan_pkl.konfirmasi');
Route::post('/usulan-pkl/{usulan_pkl}/assign-dosen', [UsulanPklController::class, 'assignDosen'])->name('usulan_pkl.assignDosen');



Route::get('/mhs_pkl/edit', [MhsPklController::class, 'edit'])->name('mhs_pkl.edit');
Route::put('mhs_pkl/{id}', [MhsPklController::class, 'update'])->name('mhs_pkl.update');
Route::get('/daftar_pkl', [MhsPklController::class, 'daftarPkl'])->name('daftar_pkl');


Route::get('/ver_pkl', [VerPklController::class, 'index'])->name('ver_pkl.index');
Route::get('/ver_pkl/create', [VerPklController::class, 'create'])->name('ver_pkl.create');
Route::post('/ver_pkl', [VerPklController::class, 'store'])->name('ver_pkl.store');
Route::get('/ver_pkl/{id_ver_pkl}/edit', [VerPklController::class, 'edit'])->name('ver_pkl.edit');
Route::put('/ver_pkl/{id_ver_pkl}', [VerPklController::class, 'update'])->name('ver_pkl.update');
Route::delete('/ver_pkl/{id_ver_pkl}', [VerPklController::class, 'destroy'])->name('ver_pkl.destroy');
Route::post('ver_pkl/{id}/confirm', [VerPklController::class, 'confirm'])->name('ver_pkl.confirm');




Route::get('/konfirmasi_pkl', [KonfirmasiUsulanController::class, 'index'])->name('konfirmasi_pkl.index');
Route::post('/usulan-pkl/{usulan_pkl}/pilih-dosen', [KonfirmasiUsulanController::class, 'pilihDosen'])->name('konfirmasi_usulan_pkl.pilih_dosen');
Route::get('/konfirmasi_usulan_pkl', [KonfirmasiUsulanController::class, 'index'])->name('konfirmasi_usulan_pkl.index');


Route::get('/bimbingan_pkl', [BimbinganPklController::class, 'index'])->name('bimbingan_pkl.index');
Route::get('/bimbingan_pkl/create', [BimbinganPklController::class, 'create'])->name('bimbingan_pkl.create');
Route::post('/bimbingan_pkl', [BimbinganPklController::class, 'store'])->name('bimbingan_pkl.store');
Route::get('/bimbingan_pkl/{id}/edit', [BimbinganPklController::class, 'edit'])->name('bimbingan_pkl.edit');
Route::put('/bimbingan_pkl/{id}', [BimbinganPklController::class, 'update'])->name('bimbingan_pkl.update');
Route::delete('/bimbingan_pkl/{id}', [BimbinganPklController::class, 'destroy'])->name('bimbingan_pkl.destroy');
Route::get('/bimbingan-pkl/dosen', [BimbinganPklController::class, 'indexDosen'])->name('bimbingan_pkl.dosen');
Route::get('/bimbingan-pkl/{id}/nilai', [BimbinganPklController::class, 'nilai'])->name('bimbingan_pkl.nilai');
Route::put('/bimbingan-pkl/konfirmasi/{id}', [BimbinganPklController::class, 'konfirmasi'])->name('bimbingan_pkl.konfirmasi');
// Route::get('/bimbingan-pkl/konfirmasi/{id}', [BimbinganPklController::class, 'konfirmasi'])->name('bimbingan_pkl.konfirmasi');
Route::get('/bimbingan_pkl/logbook/{id}', [BimbinganPKLController::class, 'logbook'])->name('bimbingan_pkl.logbook');
Route::get('/bimbingan_pkl/logbook', [BimbinganPklController::class, 'logbook'])->name('bimbingan.logbook');

Route::post('nilai_bimbingan_pkl/{id}/update_nilai', [NilaiPembimbingController::class, 'updateNilai'])->name('bimbingan_pkl.update_nilai');

Route::get('/nilai_pembimbing/{id}/edit', [NilaiPembimbingController::class, 'edit'])->name('nilai_pembimbing.edit');
Route::put('/nilai_pembimbing/{id}/update', [NilaiPembimbingController::class, 'update'])->name('nilai_pembimbing.update');


// Route::post('/nilai-bimbingan', [NilaiPembimbingController::class, 'store'])->name('nilai_bimbingan.store');
Route::post('/jadwal_sidang', [JadwalSidangController::class, 'store'])->name('jadwal_sidang.store');
Route::patch('/jadwal_sidang/{id}/konfirmasi', [JadwalSidangController::class, 'konfirmasi'])->name('jadwal_sidang.konfirmasi');

Route::get('/mhs-pkl/{id}/pdf', [MhsPklController::class, 'generatePdf'])->name('mhs_pkl.pdf');


Route::get('/nilai_pkl/{id}', [NilaiPklController::class, 'edit'])->name('admin.mhs_pkl.nilai_pkl');
Route::post('/nilai_pkl/{id}', [NilaiPklController::class, 'update'])->name('admin.mhs_pkl.nilai_pkl.update');
Route::get('nilai_pkl', [NilaiPklController::class, 'index'])->name('admin.mhs_pkl.index');

