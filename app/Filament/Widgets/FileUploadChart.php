<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class FileUploadChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah File Berdasarkan Bulan';

    public function getDescription(): string|Htmlable|null
    {
        return "Menampilkan semua file yang diupload setiap bulannya";
    }

    protected function getFileDataByType(string $type): array
    {
        $fileData = DB::table('media')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('collection_name', $type)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('count', 'month');

        $monthlyData = array_fill(1, 12, 0);

        foreach ($fileData as $month => $count) {
            $monthlyData[$month] = $count;
        }

        return array_values($monthlyData);
    }

    // protected function getFilters(): ?array
    // {
    //     return DB::table('media')
    //         ->selectRaw('YEAR(created_at) as year')
    //         ->distinct()
    //         ->pluck('year')
    //         ->mapWithKeys(fn($year) => [$year => $year])
    //         ->toArray();
    // }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'PDF',
                    'data' => $this->getFileDataByType('file-pdf'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'borderColor' => '#10B981A5',
                    'animation' => [
                        'duration' => 300,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
                [
                    'label' => 'Word',
                    'data' => $this->getFileDataByType('file-word'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#7D7C7C',
                    'borderColor' => '#7D7C7CAA',
                    'animation' => [
                        'duration' => 300,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
                [
                    'label' => 'Excel',
                    'data' => $this->getFileDataByType('file-excel'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#6499E9',
                    'borderColor' => '#6499E9AA',
                    'animation' => [
                        'duration' => 300,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
                [
                    'label' => 'PPT',
                    'data' => $this->getFileDataByType('file-ppt'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#9400FF',
                    'borderColor' => '#9400FFAA',
                    'animation' => [
                        'duration' => 300,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
                [
                    'label' => 'Image',
                    'data' => $this->getFileDataByType('file-image'),
                    'pointStyle' => 'circle',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointBackgroundColor' => '#FFD700',
                    'borderColor' => '#FFD700A5',
                    'animation' => [
                        'duration' => 300,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ],
            ],
            'labels' => [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}