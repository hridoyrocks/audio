<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নতুন PDF যোগ করুন</title>
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
        <h3>ROCKS AUDIO</h3>
        <div>
            <span class="me-3">Admin</span>
            <a href="/login" class="btn btn-outline-light btn-sm">লগআউট</a>
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
                    <div class="container-fluid">
                        <h2 class="mb-4">নতুন PDF যোগ করুন</h2>
                        
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.pdfs.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label for="serial_number" class="form-label">সিরিয়াল নম্বর *</label>
                                        <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                               id="serial_number" name="serial_number" value="{{ old('serial_number') }}" required>
                                        @error('serial_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="title" class="form-label">টাইটেল</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title') }}">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">বর্ণনা</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="pdf_file" class="form-label">PDF ফাইল * (সর্বোচ্চ 20MB)</label>
                                        <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                                               id="pdf_file" name="pdf_file" accept=".pdf" required>
                                        @error('pdf_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">সক্রিয়</label>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.pdfs.index') }}" class="btn btn-secondary">বাতিল</a>
                                        <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
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
</body>
</html>
