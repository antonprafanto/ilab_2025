<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = PublicDocument::orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        return view('admin.public-documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.public-documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:204800', // Max 200MB
            'color' => 'required|string',
            'icon' => 'required|string',
        ]);

        $path = $request->file('file')->store('public/documents');

        PublicDocument::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path, // Storage path
            'color' => $request->color,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.public-documents.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublicDocument $publicDocument)
    {
        return view('admin.public-documents.edit', compact('publicDocument'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublicDocument $publicDocument)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:204800', // Max 200MB
            'color' => 'required|string',
            'icon' => 'required|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($publicDocument->file_path && Storage::exists($publicDocument->file_path)) {
                Storage::delete($publicDocument->file_path);
            }
            // Store new file
            $data['file_path'] = $request->file('file')->store('public/documents');
        }

        $publicDocument->update($data);

        return redirect()->route('admin.public-documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublicDocument $publicDocument)
    {
        // Delete file
        if ($publicDocument->file_path && Storage::exists($publicDocument->file_path)) {
            Storage::delete($publicDocument->file_path);
        }

        $publicDocument->delete();

        return redirect()->route('admin.public-documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
