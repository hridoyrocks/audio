<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    // পাবলিক পেজ দেখানোর জন্য
    public function show($serial_number)
    {
        $audio = Audio::where('serial_number', $serial_number)->firstOrFail();
        $audio->increment('play_count');
        
        // Generate proper audio URL with hardcoded domain
        if ($audio->audio_file) {
            // Remove 'public/' from the path
            $cleanPath = str_replace('public/', '', $audio->audio_file);
            
            // Force HTTPS and correct domain
            $audio->audio_url = 'https://book.banglayielts.com/storage/' . $cleanPath;
            
            // Alternative URL using asset helper (backup)
            $audio->audio_url_backup = asset('storage/' . $cleanPath);
            
            // Check if file exists
            $audio->file_exists = Storage::exists($audio->audio_file);
            
            // Debug info
            \Log::info('Audio URL Generated', [
                'serial' => $serial_number,
                'db_path' => $audio->audio_file,
                'clean_path' => $cleanPath,
                'audio_url' => $audio->audio_url,
                'file_exists' => $audio->file_exists
            ]);
        }
        
        return view('audios.show', compact('audio'));
    }
    
    // অ্যাডমিন সেকশন
    public function index()
    {
        $audios = Audio::all();
        
        // Generate URLs for admin view
        foreach ($audios as $audio) {
            if ($audio->audio_file) {
                $cleanPath = str_replace('public/', '', $audio->audio_file);
                $audio->preview_url = 'https://book.banglayielts.com/storage/' . $cleanPath;
            }
        }
        
        return view('admin.audios.index', compact('audios'));
    }
    
    public function create()
    {
        return view('admin.audios.create');
    }
    
    public function store(Request $request)
    {
        \Log::info('ফর্ম ডাটা:', $request->all());
        
        try {
            $validated = $request->validate([
                'serial_number' => 'required|unique:audios',
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:50000', // 50MB
            ]);
            
            $audio = new Audio();
            $audio->serial_number = $request->serial_number;
            $audio->title = $request->title;
            $audio->description = $request->description;
            $audio->is_active = $request->has('is_active') ? 1 : 0;
            
            if ($request->hasFile('audio_file') && $request->file('audio_file')->isValid()) {
                // Ensure directory exists
                Storage::makeDirectory('public/audios');
                
                // Use Laravel's storage system
                $path = $request->file('audio_file')->store('public/audios');
                $audio->audio_file = $path;
                
                \Log::info('ফাইল সংরক্ষণ করা হয়েছে: ' . $path);
            } else {
                \Log::warning('ফাইল আপলোড সমস্যা!', [
                    'has_file' => $request->hasFile('audio_file'),
                    'is_valid' => $request->hasFile('audio_file') ? $request->file('audio_file')->isValid() : false
                ]);
            }
            
            $audio->save();
            
            return redirect()->route('admin.audios.index')
                ->with('success', 'অডিও সফলভাবে তৈরি করা হয়েছে!');
        } catch (\Exception $e) {
            \Log::error('ফাইল আপলোড এরর: ' . $e->getMessage());
            return back()->withErrors(['error' => 'একটি সমস্যা হয়েছে: ' . $e->getMessage()]);
        }
    }
    
    public function edit(Audio $audio)
    {
        // Generate preview URL for edit page
        if ($audio->audio_file) {
            $cleanPath = str_replace('public/', '', $audio->audio_file);
            $audio->preview_url = 'https://book.banglayielts.com/storage/' . $cleanPath;
        }
        
        return view('admin.audios.edit', compact('audio'));
    }
    
    public function update(Request $request, Audio $audio)
    {
        $validated = $request->validate([
            'serial_number' => 'required|unique:audios,serial_number,'.$audio->id,
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:50000', // 50MB
            'is_active' => 'boolean',
        ]);
        
        $audio->serial_number = $request->serial_number;
        $audio->title = $request->title;
        $audio->description = $request->description;
        $audio->is_active = $request->has('is_active');
        
        if ($request->hasFile('audio_file')) {
            // পুরাতন ফাইল ডিলিট করুন
            if ($audio->audio_file) {
                Storage::delete($audio->audio_file);
            }
            
            // Ensure directory exists
            Storage::makeDirectory('public/audios');
            
            $path = $request->file('audio_file')->store('public/audios');
            $audio->audio_file = $path;
        }
        
        $audio->save();
        
        return redirect()->route('admin.audios.index')
            ->with('success', 'অডিও সফলভাবে আপডেট করা হয়েছে!');
    }
    
    public function destroy(Audio $audio)
    {
        if ($audio->audio_file) {
            Storage::delete($audio->audio_file);
        }
        $audio->delete();
        
        return redirect()->route('admin.audios.index')
            ->with('success', 'অডিও সফলভাবে ডিলিট করা হয়েছে!');
    }
    
    // Stream audio file (backup method)
    public function stream($filename)
    {
        $path = storage_path('app/public/audios/' . $filename);
        
        if (!file_exists($path)) {
            abort(404, 'Audio file not found');
        }
        
        $mime = mime_content_type($path);
        $size = filesize($path);
        
        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
    
    // Direct play method (alternative)
    public function play($serial_number)
    {
        $audio = Audio::where('serial_number', $serial_number)->firstOrFail();
        
        if (!$audio->audio_file) {
            abort(404, 'Audio file not found');
        }
        
        $path = storage_path('app/' . $audio->audio_file);
        
        if (!file_exists($path)) {
            abort(404, 'Audio file not found');
        }
        
        return response()->file($path);
    }
}