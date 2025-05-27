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
        
        // Generate proper audio URL
        if ($audio->audio_file) {
            // Remove 'public/' from the path
            $cleanPath = str_replace('public/', '', $audio->audio_file);
            $audio->audio_url = asset('storage/' . $cleanPath);
            
            // Check if file exists
            $audio->file_exists = Storage::exists($audio->audio_file);
        }
        
        return view('audios.show', compact('audio'));
    }
    
    // অ্যাডমিন সেকশন
    public function index()
    {
        $audios = Audio::all();
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
}