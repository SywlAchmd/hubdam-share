<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\File;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BerkasController extends Controller
{
    /**
     * Display the list of files uploaded by the authenticated user.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $filter = $request->get('filter', 'all');
        $tab = $request->get('tab', 'all');

        $query = File::with(['user', 'media'])->has('media');

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->whereHas('media', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($filter !== 'all') {
            $query->whereHas('media', function ($q) use ($filter) {
                $q->where('collection_name', 'like', "%{$filter}%");
            });
        }

        if ($tab === 'mine') {
            $query->where('user_id', auth()->id());
        } elseif ($tab === 'staff') {
            $query->where('user_id', '!=', auth()->id());
        }

        $files = $query
        ->orderBy('created_at', 'desc')
        ->paginate(5)
        ->through(function ($file) {
            return [
                ...$file->toArray(),
                'user_id' => $file->user_id,
            ];
        });
    

        return Inertia::render('Berkas/Index', ['files' => $files]);
    }

    /**
     * Show the form to upload or manage files.
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Berkas/Manage');
    }

    /**
     * Handle the file upload and save associated data.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'files' => 'required|array',
            'files.*' => 'required|file|max:10240',
        ]);

        $file = File::create([
            'user_id' => $validated['user_id'],
        ]);

        foreach ($request->file('files') as $uploadedFile) {
            $extension = strtolower($uploadedFile->getClientOriginalExtension());

            $collectionName = match ($extension) {
                'xlsx', 'xls', 'csv' => 'file-excel',
                'doc', 'docx' => 'file-word',
                'ppt', 'pptx' => 'file-ppt',
                'jpeg', 'jpg', 'png' => 'file-image',
                'pdf' => 'file-pdf',
            };

            $file->addMedia($uploadedFile)
                ->toMediaCollection($collectionName);
        }

        return redirect()->route('berkas')->with('success', 'File uploaded successfully.');
    }

    /**
     * Delete a specific file and its associated media.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);

        if ($file->media->isNotEmpty()) {
            $file->media->each(function ($media) {
                $media->delete();
            });
        }

        $file->delete();

        return redirect()->route('berkas')->with('success', 'File deleted successfully.');
    }

    /**
     * Download a specific file from the server.
     * @param int $id
     * @return mixed
     */
    public function download($id)
    {
        $file = File::findOrFail($id);
        $collection = $file->media->first()->collection_name;

        return FileHelper::downloadFiles($file, $collection);
    }
}
