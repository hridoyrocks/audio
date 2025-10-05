<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অডিও এডিট করুন</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: rgba(255,255,255,.75);
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .content {
            padding: 20px;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .audio-preview {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>অডিও QR সিস্টেম</h3>
        <div>
            <a href="{{ route('admin.audios.index') }}" class="btn btn-outline-light">ফিরে যান</a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0">
                <div class="sidebar">
                    <a href="{{ route('dashboard') }}">ড্যাশবোর্ড</a>
                    <hr style="border-color: rgba(255,255,255,.1); margin: 10px 0;">
                    <a href="{{ route('admin.audios.index') }}">অডিও লিস্ট</a>
                    <a href="{{ route('admin.audios.create') }}">নতুন অডিও</a>
                    <hr style="border-color: rgba(255,255,255,.1); margin: 10px 0;">
                    <a href="{{ route('admin.pdfs.index') }}">PDF লিস্ট</a>
                    <a href="{{ route('admin.pdfs.create') }}">নতুন PDF</a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="content">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h2>অডিও এডিট করুন</h2>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.audios.update', $audio) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-3">
                                        <label for="serial_number" class="form-label">সিরিয়াল নম্বর *</label>
                                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                               id="serial_number" name="serial_number" 
                                               value="{{ old('serial_number', $audio->serial_number) }}" required>
                                        @error('serial_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">উদাহরণ: audio1, audio2, page5-audio, chapter1</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="title" class="form-label">শিরোনাম</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" 
                                               value="{{ old('title', $audio->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">বিবরণ</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3">{{ old('description', $audio->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    @if($audio->audio_file)
                                        <div class="audio-preview">
                                            <label class="form-label">বর্তমান অডিও ফাইল:</label>
                                            <div>
                                                <audio controls class="w-100" style="max-width: 500px;">
                                                    <source src="{{ Storage::url($audio->audio_file) }}" type="audio/mpeg">
                                                    আপনার ব্রাউজার অডিও প্লেয়ার সাপোর্ট করে না।
                                                </audio>
                                            </div>
                                            <small class="text-muted d-block mt-2">
                                                <i class="bi bi-music-note"></i> বর্তমান ফাইল আপলোড করা আছে
                                            </small>
                                        </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <label for="audio_file" class="form-label">নতুন অডিও ফাইল আপলোড করুন</label>
                                        <input type="file" class="form-control @error('audio_file') is-invalid @enderror" 
                                               id="audio_file" name="audio_file" accept="audio/*">
                                        <small class="form-text text-muted">
                                            সমর্থিত ফাইল ফরম্যাট: MP3, WAV, OGG. সর্বোচ্চ সাইজ: 20MB
                                            @if($audio->audio_file)
                                                <br><span class="text-warning">নতুন ফাইল আপলোড করলে পুরাতন ফাইল মুছে যাবে।</span>
                                            @endif
                                        </small>
                                        @error('audio_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                               {{ old('is_active', $audio->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">সক্রিয়?</label>
                                        <small class="form-text text-muted d-block">
                                            সক্রিয় না থাকলে QR কোড স্ক্যান করলেও অডিও চলবে না
                                        </small>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <strong>QR লিংক:</strong> 
                                                <a href="{{ route('audio.show', $audio->serial_number) }}" target="_blank">
                                                    {{ route('audio.show', $audio->serial_number) }}
                                                </a>
                                                <br>
                                                <small>প্লে কাউন্ট: {{ $audio->play_count }} বার</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save"></i> আপডেট করুন
                                        </button>
                                        <a href="{{ route('admin.audios.index') }}" class="btn btn-secondary">
                                            বাতিল করুন
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File size validation
        document.getElementById('audio_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // Convert to MB
                if (fileSize > 20) {
                    alert('ফাইল সাইজ ২০ MB এর বেশি হতে পারবে না!');
                    e.target.value = '';
                }
            }
        });
    </script>
</body>
</html>