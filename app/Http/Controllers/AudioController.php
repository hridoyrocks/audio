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
        $validated = $request->validate([
            'serial_number' => 'required|unique:audios',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:50000',
        ]);
        
        $audio = new Audio();
        $audio->serial_number = $request->serial_number;
        $audio->title = $request->title;
        $audio->description = $request->description;
        $audio->is_active = $request->has('is_active') ? 1 : 0;
        
        if ($request->hasFile('audio_file')) {
            // Create audios directory if not exists
            if (!file_exists(public_path('audios'))) {
                mkdir(public_path('audios'), 0755, true);
            }
            
            // Save to public/audios folder
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('audios'), $filename);
            $audio->audio_file = 'audios/' . $filename;
        }
        
        $audio->save();
        
        return redirect()->route('admin.audios.index')
            ->with('success', 'অডিও সফলভাবে তৈরি করা হয়েছে!');
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
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:50000',
            'is_active' => 'boolean',
        ]);
        
        $audio->serial_number = $request->serial_number;
        $audio->title = $request->title;
        $audio->description = $request->description;
        $audio->is_active = $request->has('is_active');
        
        if ($request->hasFile('audio_file')) {
            // Delete old file if exists
            if ($audio->audio_file && file_exists(public_path($audio->audio_file))) {
                unlink(public_path($audio->audio_file));
            }
            
            // Create audios directory if not exists
            if (!file_exists(public_path('audios'))) {
                mkdir(public_path('audios'), 0755, true);
            }
            
            // Save new file
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('audios'), $filename);
            $audio->audio_file = 'audios/' . $filename;
        }
        
        $audio->save();
        
        return redirect()->route('admin.audios.index')
            ->with('success', 'অডিও সফলভাবে আপডেট করা হয়েছে!');
    }
    
    public function destroy(Audio $audio)
    {
        if ($audio->audio_file && file_exists(public_path($audio->audio_file))) {
            unlink(public_path($audio->audio_file));
        }
        $audio->delete();
        
        return redirect()->route('admin.audios.index')
            ->with('success', 'অডিও সফলভাবে ডিলিট করা হয়েছে!');
    }
}