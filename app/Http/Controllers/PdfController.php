<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    // পাবলিক ডাউনলোড পেজ
    public function download($serial_number)
    {
        $pdf = Pdf::where('serial_number', $serial_number)
                   ->where('is_active', true)
                   ->firstOrFail();

        // এখানে download count increment করবো না, শুধু view দেখাবো
        return view('pdfs.download', compact('pdf'));
    }

    // ডাইরেক্ট ডাউনলোড
    public function directDownload($serial_number)
    {
        $pdf = Pdf::where('serial_number', $serial_number)
                   ->where('is_active', true)
                   ->firstOrFail();

        if (!$pdf->pdf_file) {
            abort(404, 'ফাইল খুঁজে পাওয়া যায়নি');
        }

        $pdf->increment('download_count');

        // Check if it's an R2 URL (external URL)
        if (str_starts_with($pdf->pdf_file, 'http://') || str_starts_with($pdf->pdf_file, 'https://')) {
            // For R2 files, redirect to the URL
            return redirect($pdf->pdf_file);
        }

        // Fallback for old local files
        if (!file_exists(public_path($pdf->pdf_file))) {
            abort(404, 'ফাইল খুঁজে পাওয়া যায়নি');
        }

        return response()->download(
            public_path($pdf->pdf_file),
            $pdf->title . '.pdf'
        );
    }

    // অ্যাডমিন সেকশন
    public function index()
    {
        $pdfs = Pdf::latest()->get();
        return view('admin.pdfs.index', compact('pdfs'));
    }

    public function create()
    {
        return view('admin.pdfs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'required|unique:pdfs',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'required|file|mimes:pdf|max:20000', // Max 20MB
        ]);

        $pdf = new Pdf();
        $pdf->serial_number = $request->serial_number;
        $pdf->title = $request->title ?? 'PDF Document';
        $pdf->description = $request->description;
        $pdf->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = 'BookPDF/' . time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // Upload to Cloudflare R2
            Storage::disk('r2')->put($filename, file_get_contents($file), 'public');
            $pdf->pdf_file = Storage::disk('r2')->url($filename);
        }

        $pdf->save();

        return redirect()->route('admin.pdfs.index')
            ->with('success', 'PDF সফলভাবে আপলোড করা হয়েছে!');
    }

    public function edit(Pdf $pdf)
    {
        return view('admin.pdfs.edit', compact('pdf'));
    }

    public function update(Request $request, Pdf $pdf)
    {
        $validated = $request->validate([
            'serial_number' => 'required|unique:pdfs,serial_number,'.$pdf->id,
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:20000',
        ]);

        $pdf->serial_number = $request->serial_number;
        $pdf->title = $request->title ?? 'PDF Document';
        $pdf->description = $request->description;
        $pdf->is_active = $request->has('is_active');

        if ($request->hasFile('pdf_file')) {
            // Delete old file from R2 if exists
            if ($pdf->pdf_file) {
                $this->deleteFromR2($pdf->pdf_file);
            }

            $file = $request->file('pdf_file');
            $filename = 'BookPDF/' . time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // Upload to Cloudflare R2
            Storage::disk('r2')->put($filename, file_get_contents($file), 'public');
            $pdf->pdf_file = Storage::disk('r2')->url($filename);
        }

        $pdf->save();

        return redirect()->route('admin.pdfs.index')
            ->with('success', 'PDF সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy(Pdf $pdf)
    {
        // Delete file from R2 if exists
        if ($pdf->pdf_file) {
            $this->deleteFromR2($pdf->pdf_file);
        }

        $pdf->delete();

        return redirect()->route('admin.pdfs.index')
            ->with('success', 'PDF সফলভাবে ডিলিট করা হয়েছে!');
    }

    /**
     * Delete file from R2 storage
     */
    private function deleteFromR2($url)
    {
        // Extract the path from the URL
        $r2Url = config('filesystems.disks.r2.url');
        if ($r2Url && str_starts_with($url, $r2Url)) {
            $path = str_replace($r2Url . '/', '', $url);
            Storage::disk('r2')->delete($path);
        }
    }
}
