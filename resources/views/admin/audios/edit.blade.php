@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>অডিও এডিট করুন</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.audios.index') }}" class="btn btn-secondary">ফিরে যান</a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.audios.update', $audio) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="serial_number" class="form-label">সিরিয়াল নম্বর *</label>
                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" name="serial_number" value="{{ old('serial_number', $audio->serial_number) }}" required>
                        @error('serial_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">শিরোনাম</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $audio->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">বিবরণ</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $audio->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if($audio->audio_file)
                        <div class="mb-3">
                            <label class="form-label">বর্তমান অডিও</label>
                            <div>
                                <audio controls>
                                    <source src="{{ Storage::url($audio->audio_file) }}" type="audio/mpeg">
                                    আপনার ব্রাউজার অডিও প্লেয়ার সাপোর্ট করে না।
                                </audio>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="audio_file" class="form-label">নতুন অডিও ফাইল</label>
                        <input type="file" class="form-control @error('audio_file') is-invalid @enderror" id="audio_file" name="audio_file">
                        <small class="form-text text-muted">সমর্থিত ফাইল ফরম্যাট: MP3, WAV, OGG. সর্বোচ্চ সাইজ: 20MB</small>
                        @error('audio_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $audio->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">সক্রিয়?</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">হালনাগাদ করুন</button>
                </form>
            </div>
        </div>
    </div>
@endsection