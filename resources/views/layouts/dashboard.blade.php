<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard - Portal Blog')

@section('content')
<div class="dashboard-container" style="padding: 20px; font-family: Arial, sans-serif;">
    
    <!-- Title -->
    <h1 style="font-size: 24px; margin-bottom: 20px; color: #333; font-weight: normal;">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="stats-cards" style="display: flex; gap: 15px; margin-bottom: 30px;">
        <div class="stat-card" style="padding: 20px 30px; 
                                      background-color: #d0d0d0; 
                                      border-radius: 8px; 
                                      flex: 1;
                                      text-align: center;">
            <div style="font-size: 14px; color: #666; margin-bottom: 8px;">Jumlah Berita</div>
            <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $jumlahBerita ?? 156 }}</div>
        </div>
        
        <div class="stat-card" style="padding: 20px 30px; 
                                      background-color: #d0d0d0; 
                                      border-radius: 8px; 
                                      flex: 1;
                                      text-align: center;">
            <div style="font-size: 14px; color: #666; margin-bottom: 8px;">Statistik</div>
            <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $totalViews ?? '12.5k' }}</div>
        </div>
    </div>
    
    <!-- Diagram Viewers -->
    <div style="margin-bottom: 30px;">
        <h2 style="font-size: 16px; margin-bottom: 15px; color: #333; font-weight: normal;">Diagram Viewers</h2>
        <div class="diagram-box" style="width: 60%; 
                                        height: 130px; 
                                        background-color: #eddbdb; 
                                        border-radius: 12px;
                                        padding: 15px;
                                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <canvas id="viewersChart"></canvas>
        </div>
    </div>
    
<!-- Berita Section -->
<div class="berita-section" style="display: grid; grid-template-columns: 75% 23%; gap: 2%;">
    
    <!-- Berita Terbaru (75%) -->
    <div>
        <h2 style="font-size: 16px; margin-bottom: 15px; color: #333; font-weight: normal;">Berita Terbaru</h2>
        <div class="berita-box" style="width: 100%; 
                                       background-color: #fff; 
                                       border-radius: 12px;
                                       overflow: hidden;
                                       box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #495057; width: 5%;">No</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057; width: 12%;">Gambar</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057; width: 30%;">Judul</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #495057; width: 8%;">Foto Admin</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057; width: 15%;">Nama Admin</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #495057; width: 15%;">Status</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #495057; width: 15%;">Waktu</th>
                    </tr>
                </thead>
                <tbody id="beritaTerbaruList">
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px; text-align: center; color: #495057;">1</td>
                        <td style="padding: 12px;">
                            <img src="https://via.placeholder.com/80x60" alt="Berita 1" style="width: 80px; height: 60px; border-radius: 6px; object-fit: cover;">
                        </td>
                        <td style="padding: 12px; color: #212529; font-weight: 500;">Efek Krisis RAM, Toko di Jepang Sampai “Ngebet” Beli PC Lama Pelanggan</td>
                        <td style="padding: 12px; text-align: center;">
                            <img src="https://via.placeholder.com/40" alt="Admin" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td style="padding: 12px; color: #495057;">Admin Satu</td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="background-color: #28a745; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">Published</span>
                        </td>
                        <td style="padding: 12px; text-align: center; color: #6c757d; font-size: 13px;">2 jam yang lalu</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px; text-align: center; color: #495057;">2</td>
                        <td style="padding: 12px;">
                            <img src="https://via.placeholder.com/80x60" alt="Berita 2" style="width: 80px; height: 60px; border-radius: 6px; object-fit: cover;">
                        </td>
                        <td style="padding: 12px; color: #212529; font-weight: 500;">Judul Berita 2</td>
                        <td style="padding: 12px; text-align: center;">
                            <img src="https://via.placeholder.com/40" alt="Admin" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td style="padding: 12px; color: #495057;">Admin Dua</td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="background-color: #ffc107; color: #212529; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">Draft</span>
                        </td>
                        <td style="padding: 12px; text-align: center; color: #6c757d; font-size: 13px;">5 jam yang lalu</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px; text-align: center; color: #495057;">3</td>
                        <td style="padding: 12px;">
                            <img src="https://via.placeholder.com/80x60" alt="Berita 3" style="width: 80px; height: 60px; border-radius: 6px; object-fit: cover;">
                        </td>
                        <td style="padding: 12px; color: #212529; font-weight: 500;">Judul Berita 3</td>
                        <td style="padding: 12px; text-align: center;">
                            <img src="https://via.placeholder.com/40" alt="Admin" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        </td>
                        <td style="padding: 12px; color: #495057;">Admin Tiga</td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="background-color: #28a745; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">Published</span>
                        </td>
                        <td style="padding: 12px; text-align: center; color: #6c757d; font-size: 13px;">1 hari yang lalu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Berita Terpopuler (23%) -->
    <div>
        <h2 style="font-size: 16px; margin-bottom: 15px; color: #333; font-weight: normal;">Berita Terpopuler</h2>
        <div class="berita-box" style="width: 100%; 
                                       background-color: #fff; 
                                       border-radius: 12px;
                                       padding: 15px;
                                       box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div id="beritaTerpopulerList">
                <!-- Item 1 -->
                <div style="padding: 12px; border-bottom: 1px solid #dee2e6; margin-bottom: 10px;">
                    <span style="background-color: #e74c3c; color: white; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; display: inline-block; margin-bottom: 6px;">POLITIK</span>
                    <div style="color: #212529; font-weight: 600; font-size: 13px; line-height: 1.4; margin-bottom: 8px;">Bahlil Siap Perangi Mafia Migas, Minta Dukungan Ulama</div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #495057; font-size: 11px; font-weight: 500;">👁 15.3k</span>
                        <span style="color: #6c757d; font-size: 11px;">3 hari lalu</span>
                    </div>
                </div>
                
                <!-- Item 2 -->
                <div style="padding: 12px; border-bottom: 1px solid #dee2e6; margin-bottom: 10px;">
                    <span style="background-color: #3498db; color: white; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; display: inline-block; margin-bottom: 6px;">TEKNOLOGI</span>
                    <div style="color: #212529; font-weight: 600; font-size: 13px; line-height: 1.4; margin-bottom: 8px;">Berita Viral 2</div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #495057; font-size: 11px; font-weight: 500;">👁 12.8k</span>
                        <span style="color: #6c757d; font-size: 11px;">1 minggu lalu</span>
                    </div>
                </div>
                
                <!-- Item 3 -->
                <div style="padding: 12px;">
                    <span style="background-color: #27ae60; color: white; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; display: inline-block; margin-bottom: 6px;">OLAHRAGA</span>
                    <div style="color: #212529; font-weight: 600; font-size: 13px; line-height: 1.4; margin-bottom: 8px;">Berita Viral 3</div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #495057; font-size: 11px; font-weight: 500;">👁 10.5k</span>
                        <span style="color: #6c757d; font-size: 11px;">2 hari lalu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
    /* Removed tab button styles */
</style>

<script>
    // Data untuk chart
    const viewersData = {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
            label: 'Jumlah Viewers',
            data: [1200, 1900, 1500, 2100, 1800, 2400, 2800],
            backgroundColor: 'rgba(212, 68, 68, 0.2)',
            borderColor: 'rgba(212, 68, 68, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    };

    // Konfigurasi chart
    const config = {
        type: 'line',
        data: viewersData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 11
                        },
                        maxRotation: 0,
                        minRotation: 0
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            layout: {
                padding: {
                    left: 5,
                    right: 5,
                    top: 5,
                    bottom: 5
                }
            }
        }
    };

    // Render chart
    let viewersChart;
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('viewersChart').getContext('2d');
        viewersChart = new Chart(ctx, config);
    });
</script>
@endsection