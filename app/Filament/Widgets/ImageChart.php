<?php

namespace App\Filament\Widgets;

use App\Models\File;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class ImageChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Gambar yang Diupload';

    public function getDescription(): string|Htmlable|null
    {
        return "Total gambar yang telah diupload untuk setiap jenisnya";
    }

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false
            ]
        ]
    ];

    public function getImagesData()
    {
        $files = File::whereHas('media', function ($query) {
            $query->where('collection_name', 'file-image');
        })->with('media')->get();

        $fileCounts = [];

        foreach ($files as $file) {
            foreach ($file->media as $media) {
                $extension = pathinfo($media->file_name, PATHINFO_EXTENSION);

                if (!isset($fileCounts[$extension])) {
                    $fileCounts[$extension] = 0;
                }
                $fileCounts[$extension]++;
            }
        }

        return $fileCounts;
    }

    protected function getData(): array
    {
        $imageData = $this->getImagesData();

        return [
            'datasets' => [
                [
                    'label' => 'Gambar',
                    'data' => array_values($imageData),
                    'borderRadius' => 10,
                    'animation' => [
                        'duration' => 1000,
                        'easing' => 'easeOutQubic',
                        'loop' => false
                    ]
                ]
            ],
            'labels' => array_keys($imageData)
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
