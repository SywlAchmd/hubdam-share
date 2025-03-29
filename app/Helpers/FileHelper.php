<?php

namespace App\Helpers;

use App\Filament\Admin\Resources\File\ExcelResource;
use App\Filament\Admin\Resources\File\ImageResource;
use App\Filament\Admin\Resources\File\PDFResource;
use App\Filament\Admin\Resources\File\PowerPointResource;
use App\Filament\Admin\Resources\File\WordResource;
use ZipArchive;

class FileHelper
{
  /**
   * Format file size to a human-readable format (KB, MB, GB).
   * 
   * @param int $bytes File size in bytes.
   * @return string Formatted file size.
   */
  public static function formatFileSize($bytes)
  {
    if ($bytes >= 1073741824) {
      $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
      $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
      $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
      $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
      $bytes = $bytes . ' byte';
    } else {
      $bytes = '0 bytes';
    }

    return $bytes;
  }

  /**
   * Download files or create a ZIP file for multiple files and download.
   * @param mixed $record Record containing the media files.
   * @param string $collection Name of the media collection.
   * @return \Illuminate\Http\Response Download response for the file(s).
   */
  public static function downloadFiles($record, $collection)
  {
    $files = $record->getMedia($collection);

    if ($files->count() == 1) {
      $file = $files->first();

      $filePath = $file->getPath();
      $fileExtension = (explode('.', $file->file_name)[1]);
      $fileName = "{$file->name}.{$fileExtension}";

      return response()->download(
        $filePath,
        $fileName
      );
    }

    $zip = new ZipArchive();

    $zipFileName = 'files-' . (explode('-', $collection)[1]) . now()->format('Y-m-d_H-i-s') . '.zip';
    $zipPath = storage_path('app/public/' . $zipFileName);

    if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
      foreach ($files as $file) {
        $filePath = $file->getPath();
        $fileExtension = (explode('.', $file->file_name)[1]);
        $fileName = "{$file->name}.{$fileExtension}";

        $zip->addFile($filePath, $fileName);
      }

      $zip->close();
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
  }

  /**
   * Get staff options for the Select component.
   * @return array
   */
  public static function getStaffOptions(): array
  {
    return [
      'pers' => 'Staf Tuud/Pers',
      'sikomlek' => 'Staf Sikomlek',
      'pernika' => 'Staf Pernika',
      'konbekharstal' => 'Staf Konbekharstal',
      'benghubdam' => 'Staf Benghubdam',
      'gudmathub' => 'Staf Gudmathub',
      'urlog' => 'Staf Urlog',
      'urlat' => 'Staf Urlat',
      'urpam' => 'Staf Urpam',
      'renproggar' => 'Staf Renproggar',
      'denhubdam' => 'Staf Denhubdam'
    ];
  }

  public static function resolveResourceFromCollection(string $collection): ?string
  {
    return match ($collection) {
      'file-pdf' => PDFResource::class,
      'file-word' => WordResource::class,
      'file-excel' => ExcelResource::class,
      'file-ppt' => PowerPointResource::class,
      'file-image' => ImageResource::class,
      default => null,
    };
  }
}
