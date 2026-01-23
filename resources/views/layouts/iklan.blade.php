@extends('layouts.app')

@section('title', 'Iklan - Portal Blog')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Iklan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans">

<div class="p-6">
  <h1 class="text-2xl font-bold text-slate-700 mb-6">Kelola Iklan</h1>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

    <!-- FORM TAMBAH IKLAN -->
    <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
      <h2 class="text-lg font-semibold text-indigo-600 mb-6">Tambah Iklan</h2>

      <form class="flex flex-col flex-1 space-y-6">
        <input type="text" placeholder="Judul" class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-400" />

        <select class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-400">
          <option>Tipe Iklan</option>
          <option>1:1 Slide</option>
          <option>3:1 Kanan</option>
          <option>3:1 Kiri</option>
          <option>3:1 Tengah</option>
          <option>1:3 Atas</option>
          <option>1:3 Tengah</option>
        </select>

        <input type="text" placeholder="Link" class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-400" />

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar</label>
            <div class="flex items-center gap-3">
                <input 
                    type="file" 
                    id="inputGambar" 
                    accept="image/*"
                    class="hidden"
                    onchange="previewGambar(event)"
                >
                <label for="inputGambar" class="flex-1 px-4 py-2.5 border-2 border-gray-200 rounded-lg text-sm text-gray-500 cursor-pointer hover:border-indigo-500 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-image"></i>
                    <span id="namaFile">Pilih gambar</span>
                </label>
            </div>
            <div id="previewContainer" class="hidden mt-3">
                <img id="previewImage" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
            </div>
        </div>

        <!-- TOMBOL UPLOAD DI BAWAH -->
         
        <div class="flex-1"></div>

        <button 
            onclick="tambahJurnal()" 
            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-2.5 rounded-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-200 shadow-md hover:shadow-lg text-sm mt-4"
        >
            <i class="fas fa-upload mr-2"></i>Upload
        </button>
      </form>
    </div>

    <!-- TABEL IKLAN -->
    <div class="bg-white rounded-2xl shadow p-6 lg:col-span-2 flex flex-col">
      <h2 class="text-lg font-semibold text-indigo-600 mb-4">Tabel Iklan</h2>

      <div class="overflow-y-auto max-h-[420px] border rounded-lg">
        <table class="min-w-full text-sm">
          <thead class="bg-indigo-600 text-white sticky top-0">
            <tr>
              <th class="px-3 py-2">No</th>
              <th class="px-3 py-2">Judul</th>
              <th class="px-3 py-2">Tipe</th>
              <th class="px-3 py-2">Link</th>
              <th class="px-3 py-2">Gambar</th>
              <th class="px-3 py-2">Edit</th>
              <th class="px-3 py-2">Hapus</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            <script>
              const data = [
                'Pemerintah Resmi Naikkan UMK 2026',
                'Harga BBM Terbaru Berlaku Nasional',
                'Timnas Indonesia Lolos Piala Asia',
                'Teknologi AI Lokal Tembus Pasar Global',
                'Cuaca Ekstrem Diprediksi Hingga Februari',
                'Startup Edukasi Raup Pendanaan Besar',
                'Jadwal Libur Nasional Resmi Diumumkan',
                'Transportasi Publik Tambah Armada Baru',
                'UMKM Digital Naik Signifikan Tahun Ini',
                'Tren Keamanan Siber di Indonesia 2026',
                'Ekonomi Digital Indonesia Tumbuh Pesat',
                'Inovasi Smart City di Kota Besar',
                'Kebijakan Pajak Baru Berlaku 2026',
                'Energi Terbarukan Jadi Fokus Nasional',
                'Perkembangan E-Commerce Asia Tenggara',
                'AI Digunakan di Sektor Pendidikan',
                'Kesehatan Digital Makin Diminati',
                'Keamanan Data Jadi Prioritas Startup',
                'Transformasi Digital UMKM Nasional',
                'Industri Kreatif Tembus Pasar Global'
              ];

              document.write(data.map((j, i) => `
                <tr class="hover:bg-slate-50 align-top">
                  <td class="px-3 py-3 text-center">${i+1}</td>
                  <td class="px-3 py-3">${j}</td>
                  <td class="px-3 py-3">3:1 Tengah</td>
                  <td class="px-3 py-3 text-indigo-600">https://berita.com/${i+1}</td>
                  <td class="px-3 py-3">
                    <img src="https://picsum.photos/seed/${i+1}/120/80" class="rounded-lg object-cover" />
                  </td>
                  <td class="px-3 py-3 text-center">
                    <button onclick="openModal('${j}')" class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded">Edit</button>
                  </td>
                  <td class="px-3 py-3 text-center">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                  </td>
                </tr>
              `).join(''));
            </script>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDIT -->
<div id="modal" class="fixed inset-0 hidden bg-black/50 flex items-center justify-center">
  <div class="bg-white rounded-2xl p-6 w-full max-w-lg">
    <h3 class="text-lg font-semibold text-indigo-600 mb-4">Edit iklan</h3>

    <form class="space-y-4">
      <input id="modalJudul" type="text" class="w-full border rounded-lg px-3 py-2" />

      <select class="w-full border rounded-lg px-3 py-2">
        <option>1:1 Slide</option>
        <option>3:1 Kanan</option>
        <option>3:1 Kiri</option>
        <option>3:1 Tengah</option>
        <option>1:3 Atas</option>
        <option>1:3 Tengah</option>
      </select>

      <input type="text" placeholder="Link" class="w-full border rounded-lg px-3 py-2" />

      <input type="file" class="w-full text-sm" />

      <div class="pt-10 flex justify-end gap-2">
        <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg border">Batal</button>
        <button type="button" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function openModal(judul) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modalJudul').value = judul;
  }
  function closeModal() {
    document.getElementById('modal').classList.add('hidden');
  }
</script>

</body>
</html>

@endsection
