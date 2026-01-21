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
            <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $jumlahBerita ?? 120 }}</div>
        </div>
        
        <div class="stat-card" style="padding: 20px 30px; 
                                      background-color: #d0d0d0; 
                                      border-radius: 8px; 
                                      flex: 1;
                                      text-align: center;">
            <div style="font-size: 14px; color: #666; margin-bottom: 8px;">Statistik</div>
            <div style="font-size: 32px; font-weight: bold; color: #333;">{{ $totalViews ?? '15' }}</div>
        </div>
    </div>
    
    <!-- Diagram Viewers -->
    <div style="margin-bottom: 30px;">
        <h2 style="font-size: 16px; margin-bottom: 15px; color: #333; font-weight: normal;">Diagram Viewers</h2>
        <div class="diagram-box" style="width: 60%; 
                                        height: 130px; 
                                        background-color: #f5f5f5; 
                                        border-radius: 12px;
                                        padding: 15px;
                                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <canvas id="viewersChart"></canvas>
        </div>
    </div>
    
    <!-- Berita Section -->
    <div class="berita-section" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <!-- Berita Terbaru -->
        <div>
            <h2 style="font-size: 16px; margin-bottom: 15px; color: #333; font-weight: normal;">Berita Terbaru</h2>
            <div class="berita-box" style="width: 100%; 
                                           min-height: 180px; 
                                           background-color: #f5f5f5; 
                                           border-radius: 12px;
                                           padding: 20px;
                                           box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <ul id="beritaTerbaruList" style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid #ddd;">
                        <strong>Judul Berita 1</strong><br>
                        <small style="color: #666;">2 jam yang lalu • 1k views</small>
                    </li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #ddd;">
                        <strong>Judul Berita 2</strong><br>
                        <small style="color: #666;">5 jam yang lalu • 590 views</small>
                    </li>
                    <li style="padding: 10px 0;">
                        <strong>Judul Berita 3</strong><br>
                        <small style="color: #666;">1 hari yang lalu • 950 views</small>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Berita Terpopuler -->
        <div>
            <h2 style="font-size: 16px; margin-bottom: 15px; color: #333; font-weight: normal;">Berita Terpopuler</h2>
            <div class="berita-box" style="width: 100%; 
                                           min-height: 180px; 
                                           background-color: #f5f5f5; 
                                           border-radius: 12px;
                                           padding: 20px;
                                           box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <ul id="beritaTerpopulerList" style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 10px 0; border-bottom: 1px solid #ddd;">
                        <strong>Polda Metro SP3 Eggi Sudjana dan Damai Lubis Tersangka Kasus Ijazah Jokowi</strong><br>
                        <small style="color: #666;">berita • 3 hari yang lalu • 15.3k views</small>
                    </li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #ddd;">
                        <strong>Berita Viral 2</strong><br>
                        <small style="color: #666;">1 minggu yang lalu • 12.8k views</small>
                    </li>
                    <li style="padding: 10px 0;">
                        <strong>Berita Viral 3</strong><br>
                        <small style="color: #666;">2 hari yang lalu • 10.5k views</small>
                    </li>
                    <li style="padding: 10px 0;">
                        <strong>Berita Viral 4</strong><br>
                        <small style="color: #666;">2 hari yang lalu • 10.5k views</small>
                    </li>
                    <li style="padding: 10px 0;">
                        <strong>Berita Viral 5</strong><br>
                        <small style="color: #666;">2 hari yang lalu • 10.5k views</small>
                    </li>
                    <li style="padding: 10px 0;">
                        <strong>Berita Viral 6</strong><br>
                        <small style="color: #666;">2 hari yang lalu • 10.5k views</small>
                    </li>
                    <li style="padding: 10px 0;">
                        <strong>Berita Viral 7</strong><br>
                        <small style="color: #666;">2 hari yang lalu • 10.5k views</small>
                    </li>
                    <li style="padding: 10px 0;">
                        <strong>Berita Viral 8</strong><br>
                        <small style="color: #666;">2 hari yang lalu • 10.5k views</small>
                    </li>
                </ul>
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