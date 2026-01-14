<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fef0f0;
            border: 1px solid #e5d4d4;
            border-radius: 8px;
            padding: 24px;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
            font-weight: 600;
        }

        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #d3d3d3;
            border-radius: 8px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .card.left {
            flex: 0 0 40%;
            min-height: 140px;
        }

        .card.right {
            flex: 1;
            min-height: 140px;
        }

        .card-title {
            font-size: 14px;
            color: #333;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .card-body {
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
        }

        .simpan-btn {
            background-color: white;
            border: 1px solid #bbb;
            padding: 7px 22px;
            border-radius: 5px;
            font-size: 13px;
            cursor: pointer;
            color: #333;
            font-weight: 500;
            transition: all 0.2s;
        }

        .simpan-btn:hover {
            background-color: #f8f8f8;
            border-color: #999;
        }

        .simpan-btn:active {
            transform: scale(0.98);
        }

        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }

            .card.left,
            .card.right {
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Kategori</h1>
        
        <!-- Baris Pertama: Tambah Kategori & Tabel Kategori -->
        <div class="row">
            <div class="card left">
                <div class="card-title">Tambah Kategori</div>
                <div class="card-body">
                    <button class="simpan-btn" onclick="simpanData('Kategori')">Simpan</button>
                </div>
            </div>

            <div class="card right">
                <div class="card-title">Tabel Kategori</div>
                <div class="card-body"></div>
            </div>
        </div>

        <!-- Baris Kedua: Tambah Tag & Tabel Tag -->
        <div class="row">
            <div class="card left">
                <div class="card-title">Tambah Tag</div>
                <div class="card-body">
                    <button class="simpan-btn" onclick="simpanData('Tag')">Simpan</button>
                </div>
            </div>

            <div class="card right">
                <div class="card-title">Tabel Tag</div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>

    <script>
        function simpanData(type) {
            alert(`Data ${type} berhasil disimpan!`);
            console.log(`Menyimpan ${type}...`);
            // Tambahkan logika penyimpanan data Anda di sini
        }
    </script>
</body>
</html>