<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অডিও লিস্ট</title>
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
                    <a href="{{ route('admin.audios.index') }}">অডিও লিস্ট</a>
                    <a href="{{ route('admin.audios.create') }}">নতুন অডিও</a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h2>অডিও লিস্ট</h2>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('admin.audios.create') }}" class="btn btn-primary">নতুন অডিও যোগ করুন</a>
                            </div>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>সিরিয়াল নম্বর</th>
                                            <th>শিরোনাম</th>
                                            <th>স্ট্যাটাস</th>
                                            <th>প্লে কাউন্ট</th>
                                            <th>QR লিংক</th>
                                            <th>অ্যাকশন</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($audios) && count($audios) > 0)
                                            @foreach($audios as $audio)
                                                <tr>
                                                    <td>{{ $audio->serial_number }}</td>
                                                    <td>{{ $audio->title ?? 'শিরোনাম নেই' }}</td>
                                                    <td>
                                                        @if($audio->is_active && $audio->audio_file)
                                                            <span class="badge bg-success">সক্রিয়</span>
                                                        @else
                                                            <span class="badge bg-danger">নিষ্ক্রিয়</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $audio->play_count }}</td>
                                                    <td>
                                                        <a href="{{ route('audio.show', $audio->serial_number) }}" target="_blank" class="text-primary">
                                                            {{ route('audio.show', $audio->serial_number) }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.audios.edit', $audio) }}" class="btn btn-sm btn-info me-2">এডিট</a>
                                                        
                                                        <form action="{{ route('admin.audios.destroy', $audio) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">ডিলিট</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">কোন অডিও পাওয়া যায়নি</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
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