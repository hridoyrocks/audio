<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নতুন অডিও যোগ করুন</title>
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
                    <a href="{{ route('admin.audios.index') }}">অডিও লিস্ট</a>
                    <a href="{{ route('admin.audios.create') }}">নতুন অডিও</a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="content">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h2>নতুন অডিও যোগ করুন</h2>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.audios.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="serial_number" class="form-label">সিরিয়াল নম্বর *</label>
                                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" name="serial_number" value="{{ old('serial_number') }}" required>
                                        @error('serial_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">উদাহরণ: audio1, audio2, page5-audio, chapter1</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="title" class="form-label">শিরোনাম</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">বিবরণ</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="audio_file" class="form-label">অডিও ফাইল</label>
                                        <input type="file" class="form-control @error('audio_file') is-invalid @enderror" id="audio_file" name="audio_file">
                                        <small class="form-text text-muted">সমর্থিত ফাইল ফরম্যাট: MP3, WAV, OGG. সর্বোচ্চ সাইজ: 20MB</small>
                                        @error('audio_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">সক্রিয়?</label>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>