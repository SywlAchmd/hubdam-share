<?php

namespace App\Listeners;

use App\Helpers\FileHelper;
use App\Models\File;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class SendFileUploadedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if ($media->model_type !== File::class) {
            return;
        }

        $file = $media->model;
        $uploader = $file->user->name;

        $admins = User::whereIn('role', [0, 1])->get();

        $collection = $media->collection_name;
        
        $type = FileHelper::resolveFileTypeLabelFromCollection($collection);
        $resource = FileHelper::resolveResourceFromCollection($collection);

        Notification::make()
            ->title('Unggahan Berkas Baru')
            ->icon('heroicon-o-document-text')
            ->body("{$uploader} mengunggah berkas {$type} dengan nama \"{$media->name}\".")
            ->actions([
                Action::make('Lihat Berkas')
                    ->url(
                        $resource
                            ? $resource::getUrl('index') . '?tableSearch=' . urlencode($media->name)
                            : url('/admin')
                    )
                    ->markAsRead(),
                Action::make('Tandai belum dibaca')
                    ->color("gray")
                    ->markAsUnread(),
            ])
            ->sendToDatabase($admins);
    } 
}
