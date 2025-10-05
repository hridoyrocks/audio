<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pdf->title ?? 'PDF ডাউনলোড' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .main-container {
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        
        .pdf-icon {
            width: 80px;
            height: 80px;
            background: #DC2626;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        
        .pdf-icon i {
            font-size: 40px;
            color: white;
        }
        
        .pdf-title {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 12px;
        }
        
        .pdf-description {
            color: #6B7280;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 32px;
        }
        
        .buttons-group {
            display: flex;
            gap: 12px;
        }
        
        .btn-custom {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-preview {
            background: #F3F4F6;
            color: #374151;
        }
        
        .btn-preview:hover {
            background: #E5E7EB;
        }
        
        .btn-download {
            background: #059669;
            color: white;
        }
        
        .btn-download:hover {
            background: #047857;
            color: white;
        }
        
        .download-count {
            margin-top: 24px;
            font-size: 14px;
            color: #9CA3AF;
        }
        
        .download-count strong {
            color: #6B7280;
        }
        
        /* Preview Modal */
        .preview-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            padding: 20px;
        }
        
        .preview-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .preview-title {
            color: white;
            font-size: 18px;
            font-weight: 500;
        }
        
        .close-btn {
            background: white;
            color: #374151;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }
        
        .close-btn:hover {
            background: #F3F4F6;
        }
        
        .preview-frame {
            flex: 1;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .preview-frame iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        /* No PDF Available */
        .no-pdf {
            padding: 60px 20px;
        }
        
        .no-pdf-icon {
            font-size: 60px;
            color: #E5E7EB;
            margin-bottom: 20px;
        }
        
        .no-pdf-message {
            color: #6B7280;
            font-size: 18px;
            margin-bottom: 8px;
        }
        
        .no-pdf-sub {
            color: #9CA3AF;
            font-size: 14px;
        }
        
        @media (max-width: 480px) {
            .main-container {
                padding: 30px 20px;
            }
            
            .buttons-group {
                flex-direction: column;
            }
            
            .pdf-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        @if($pdf->pdf_file && $pdf->is_active)
            <div class="pdf-icon">
                <i class="fas fa-file-pdf"></i>
            </div>
            
            <h1 class="pdf-title">{{ $pdf->title }}</h1>
            
            @if($pdf->description)
                <p class="pdf-description">{{ $pdf->description }}</p>
            @endif
            
            <div class="buttons-group">
                <button onclick="openPreview()" class="btn-custom btn-preview">
                    <i class="fas fa-eye"></i>
                    প্রিভিউ
                </button>
                
                <a href="{{ route('pdf.direct-download', $pdf->serial_number) }}" class="btn-custom btn-download">
                    <i class="fas fa-download"></i>
                    ডাউনলোড
                </a>
            </div>
            
            <div class="download-count">
                ডাউনলোড হয়েছে <strong>{{ $pdf->download_count }}</strong> বার
            </div>
            
        @else
            <div class="no-pdf">
                <div class="no-pdf-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <p class="no-pdf-message">PDF উপলব্ধ নেই</p>
                <p class="no-pdf-sub">পরে আবার চেষ্টা করুন</p>
            </div>
        @endif
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="preview-modal">
        <div class="preview-content">
            <div class="preview-header">
                <h5 class="preview-title">{{ $pdf->title ?? 'PDF প্রিভিউ' }}</h5>
                <button onclick="closePreview()" class="close-btn">
                    <i class="fas fa-times"></i> বন্ধ করুন
                </button>
            </div>
            <div class="preview-frame">
                @if($pdf->pdf_file)
                    <iframe src="{{ asset($pdf->pdf_file) }}"></iframe>
                @endif
            </div>
        </div>
    </div>

    <script>
        function openPreview() {
            document.getElementById('previewModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreview();
            }
        });
    </script>
</body>
</html>
