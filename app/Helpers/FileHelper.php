<?php

namespace App\Helpers;

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

      return response()->download(
        $file->getPath(),
        $file->name . '.' . explode('.', $file->file_name)[1]
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
}
