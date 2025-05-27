<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $audio->title ?? 'অডিও প্লেয়ার' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary-color: #8249b5;
            --primary-dark: #6a2c94;
            --primary-light: #9c6ed3;
            --text-color: #363636;
            --text-secondary: #747474;
            --bg-color: #f8f9fa;
            --bg-gradient: linear-gradient(135deg, #8249b5, #e74694);
            --container-bg: rgba(255, 255, 255, 0.9);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-strong: 0 15px 35px rgba(0, 0, 0, 0.2);
            --border-radius: 20px;
            --player-height: 170px;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', 'Bangla', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            0; 0;">
            text-align: center;
            padding: 40px 20px;
        }
        
        .no-audio-icon {
            font-size: 5rem;
            color: rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .no-audio-message {
            font-size: 1.2rem;
            color: var(--text-secondary);
        }
        
        /* Footer */
        footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Loading Animation */
        .loader {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
        }
        
        .loader-bar {
            display: inline-block;
            width: 4px;
            height: 18px;
            border-radius: 4px;
            margin: 0 2px;
            background-color: var(--primary-color);
            animation: loading 1s ease-in-out infinite;
        }
        
        .loader-bar:nth-child(1) { animation-delay: 0s; }
        .loader-bar:nth-child(2) { animation-delay: 0.1s; }
        .loader-bar:nth-child(3) { animation-delay: 0.2s; }
        .loader-bar:nth-child(4) { animation-delay: 0.3s; }
        .loader-bar:nth-child(5) { animation-delay: 0.4s; }
        
        @keyframes loading {
            0%, 100% { transform: scaleY(0.5); }
            50% { transform: scaleY(1.5); }
        }
        
        /* Mobile Optimizations */
        @media (max-width: 576px) {
            .album-art {
                width: 150px;
                height: 150px;
                margin-bottom: 20px;
            }
            
            .audio-title {
                font-size: 1.4rem;
            }
            
            .audio-description {
                font-size: 0.9rem;
            }
            
            .control-btn {
                margin: 0 10px;
            }
            
            .control-btn.btn-play-pause {
                width: 50px;
                height: 50px;
                margin: 0 15px;
            }
        }
    </style>
</head>
<body>
    <div class="player-container" id="player-container">
        <div class="blur-bg"></div>
        
        @if($audio->audio_file)
            <!-- Album Art -->
            <div class="album-art">
                <img src="https://yt3.googleusercontent.com/_yDR5IDXVdx8Sax1-vxnK5_9L2ix-LCWxpvE_eBOH1qzkXi2YFyQPb7kJQ2q85XhUqHVH5Tzyw=s900-c-k-c0x00ffffff-no-rj" alt="{{ $audio->title }}" id="album-img">
                <div class="album-disk">
                    <div class="pulsating-circle"></div>
                </div>
            </div>
            
            <!-- Audio Info -->
            <div class="audio-info">
                <h1 class="audio-title">{{ $audio->title ?? 'অডিও প্লেয়ার' }}</h1>
                @if($audio->description)
                    <p class="audio-description">{{ $audio->description }}</p>
                @endif
            </div>
            
            <!-- Audio Player with Fixed URL -->
            @php
                // Priority 1: Use audio_url from controller if available
                if (isset($audio->audio_url)) {
                    $audioUrl = $audio->audio_url;
                } else {
                    // Priority 2: Generate URL with hardcoded domain
                    $cleanPath = str_replace('public/', '', $audio->audio_file);
                    $audioUrl = 'https://book.banglayielts.com/storage/' . $cleanPath;
                }
                
                // Extract just the filename for logging
                $fileName = basename($audio->audio_file);
            @endphp
            
            <audio id="audio" style="display:none;">
                <source src="{{ $audioUrl }}" type="audio/mpeg">
                <source src="{{ $audioUrl }}" type="audio/ogg">
                <source src="{{ $audioUrl }}" type="audio/wav">
                আপনার ব্রাউজার অডিও প্লেয়ার সাপোর্ট করে না।
            </audio>
            
            <!-- Debug Info (Remove in production) -->
            <script>
                console.log('Audio Debug:', {
                    finalUrl: '{{ $audioUrl }}',
                    fileName: '{{ $fileName }}',
                    dbPath: '{{ $audio->audio_file }}',
                    fileExists: {{ isset($audio->file_exists) ? ($audio->file_exists ? 'true' : 'false') : 'null' }}
                });
            </script>
            
            <!-- Audio Visualizer -->
            <div class="visualizer" id="visualizer">
                <div class="visualizer-bar" style="height: 10px;"></div>
                <div class="visualizer-bar" style="height: 20px;"></div>
                <div class="visualizer-bar" style="height: 15px;"></div>
                <div class="visualizer-bar" style="height: 25px;"></div>
                <div class="visualizer-bar" style="height: 18px;"></div>
                <div class="visualizer-bar" style="height: 22px;"></div>
                <div class="visualizer-bar" style="height: 12px;"></div>
                <div class="visualizer-bar" style="height: 28px;"></div>
                <div class="visualizer-bar" style="height: 16px;"></div>
                <div class="visualizer-bar" style="height: 30px;"></div>
                <div class="visualizer-bar" style="height: 22px;"></div>
                <div class="visualizer-bar" style="height: 14px;"></div>
                <div class="visualizer-bar" style="height: 26px;"></div>
                <div class="visualizer-bar" style="height: 18px;"></div>
                <div class="visualizer-bar" style="height: 10px;"></div>
                <div class="visualizer-bar" style="height: 20px;"></div>
                <div class="visualizer-bar" style="height: 12px;"></div>
                <div class="visualizer-bar" style="height: 24px;"></div>
                <div class="visualizer-bar" style="height: 16px;"></div>
                <div class="visualizer-bar" style="height: 30px;"></div>
            </div>
            
            <!-- Progress Bar -->
            <div class="progress-container">
                <div class="progress-bar-container" id="progress-container">
                    <div class="progress-bar" id="progress-bar"></div>
                </div>
                <div class="time-display">
                    <span id="current-time">0:00</span>
                    <span id="duration">0:00</span>
                </div>
            </div>
            
            <!-- Controls -->
            <div class="player-controls">
                <button class="control-btn" id="btn-repeat" title="পুনরাবৃত্তি">
                    <i class="fas fa-redo"></i>
                </button>
                <button class="control-btn" id="btn-prev" title="১০ সেকেন্ড পিছে">
                    <i class="fas fa-backward"></i>
                </button>
                <button class="control-btn btn-play-pause" id="btn-play-pause" title="প্লে/পজ">
                    <i class="fas fa-play"></i>
                </button>
                <button class="control-btn" id="btn-next" title="১০ সেকেন্ড সামনে">
                    <i class="fas fa-forward"></i>
                </button>
                <button class="control-btn" id="btn-speed" title="গতি">
                    <i class="fas fa-tachometer-alt"></i>
                </button>
            </div>
            
            <!-- Volume Control -->
            <div class="volume-container">
                <div class="volume-icon" id="volume-icon">
                    <i class="fas fa-volume-up"></i>
                </div>
                <input type="range" class="volume-slider" id="volume-slider" min="0" max="1" step="0.01" value="1">
            </div>
        @else
            <!-- No Audio Available -->
            <div class="no-audio-container">
                <div class="no-audio-icon">
                    <i class="fas fa-music"></i>
                </div>
                <p class="no-audio-message">এই অডিওটি এখনো আপলোড করা হয়নি।</p>
                <div class="loader mt-4">
                    <div class="loader-bar"></div>
                    <div class="loader-bar"></div>
                    <div class="loader-bar"></div>
                    <div class="loader-bar"></div>
                    <div class="loader-bar"></div>
                </div>
                <p class="mt-3">অনুগ্রহ করে পরে আবার চেষ্টা করুন।</p>
            </div>
        @endif
    </div>
    
    <footer>
        <p>Made with ❤️ Rocks</p>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($audio->audio_file)
                const playerContainer = document.getElementById('player-container');
                const audio = document.getElementById('audio');
                const progressContainer = document.getElementById('progress-container');
                const progressBar = document.getElementById('progress-bar');
                const currentTimeEl = document.getElementById('current-time');
                const durationEl = document.getElementById('duration');
                const btnPlayPause = document.getElementById('btn-play-pause');
                const btnPrev = document.getElementById('btn-prev');
                const btnNext = document.getElementById('btn-next');
                const btnRepeat = document.getElementById('btn-repeat');
                const btnSpeed = document.getElementById('btn-speed');
                const volumeSlider = document.getElementById('volume-slider');
                const volumeIcon = document.getElementById('volume-icon');
                const visualizer = document.getElementById('visualizer');
                const visualizerBars = document.querySelectorAll('.visualizer-bar');
                
                // State variables
                let isPlaying = false;
                let isRepeat = false;
                let speedLevel = 1;
                let speedLevels = [0.5, 0.75, 1, 1.25, 1.5, 2];
                let speedIndex = 2; // Default 1x speed
                
                // Play/Pause function
                function togglePlayPause() {
                    if (audio.paused) {
                        audio.play().then(() => {
                            btnPlayPause.innerHTML = '<i class="fas fa-pause"></i>';
                            playerContainer.classList.add('is-playing');
                            startVisualization();
                            isPlaying = true;
                        }).catch(e => {
                            console.error('Play failed:', e);
                            alert('অডিও প্লে করতে সমস্যা হচ্ছে। পেজ রিফ্রেশ করে আবার চেষ্টা করুন।');
                        });
                    } else {
                        audio.pause();
                        btnPlayPause.innerHTML = '<i class="fas fa-play"></i>';
                        playerContainer.classList.remove('is-playing');
                        stopVisualization();
                        isPlaying = false;
                    }
                }
                
                // Update progress function
                function updateProgress() {
                    if (audio.duration) {
                        const percent = (audio.currentTime / audio.duration) * 100;
                        progressBar.style.width = `${percent}%`;
                        currentTimeEl.textContent = formatTime(audio.currentTime);
                    }
                }
                
                // Format time function (convert seconds to MM:SS)
                function formatTime(seconds) {
                    const min = Math.floor(seconds / 60);
                    const sec = Math.floor(seconds % 60);
                    return `${min}:${sec < 10 ? '0' : ''}${sec}`;
                }
                
                // Set progress function (when clicking on progress bar)
                function setProgress(e) {
                    const width = this.clientWidth;
                    const clickX = e.offsetX;
                    audio.currentTime = (clickX / width) * audio.duration;
                }
                
                // Skip backward function
                function skipBackward() {
                    audio.currentTime = Math.max(0, audio.currentTime - 10);
                }
                
                // Skip forward function
                function skipForward() {
                    audio.currentTime = Math.min(audio.duration, audio.currentTime + 10);
                }
                
                // Toggle repeat function
                function toggleRepeat() {
                    isRepeat = !isRepeat;
                    audio.loop = isRepeat;
                    btnRepeat.classList.toggle('active');
                    
                    if (isRepeat) {
                        btnRepeat.style.color = 'var(--primary-color)';
                    } else {
                        btnRepeat.style.color = '';
                    }
                }
                
                // Change playback speed function
                function changeSpeed() {
                    speedIndex = (speedIndex + 1) % speedLevels.length;
                    audio.playbackRate = speedLevels[speedIndex];
                    btnSpeed.innerHTML = `<span>${speedLevels[speedIndex]}x</span>`;
                    
                    // Highlight when not at normal speed
                    if (speedLevels[speedIndex] !== 1) {
                        btnSpeed.style.color = 'var(--primary-color)';
                    } else {
                        btnSpeed.style.color = '';
                        btnSpeed.innerHTML = '<i class="fas fa-tachometer-alt"></i>';
                    }
                }
                
                // Change volume function
                function changeVolume() {
                    audio.volume = volumeSlider.value;
                    updateVolumeIcon();
                }
                
                // Update volume icon function
                function updateVolumeIcon() {
                    if (audio.volume >= 0.6) {
                        volumeIcon.innerHTML = '<i class="fas fa-volume-up"></i>';
                    } else if (audio.volume >= 0.1) {
                        volumeIcon.innerHTML = '<i class="fas fa-volume-down"></i>';
                    } else {
                        volumeIcon.innerHTML = '<i class="fas fa-volume-mute"></i>';
                    }
                }
                
                // Toggle mute function
                function toggleMute() {
                    if (audio.volume > 0) {
                        audio.volume = 0;
                        volumeSlider.value = 0;
                        volumeIcon.innerHTML = '<i class="fas fa-volume-mute"></i>';
                    } else {
                        audio.volume = 0.7;
                        volumeSlider.value = 0.7;
                        updateVolumeIcon();
                    }
                }
                
                // Visualizer animation
                function startVisualization() {
                    animateVisualizer();
                }
                
                function stopVisualization() {
                    visualizerBars.forEach(bar => {
                        bar.style.height = '10px';
                    });
                }
                
                function animateVisualizer() {
                    if (isPlaying) {
                        visualizerBars.forEach(bar => {
                            const height = Math.floor(Math.random() * 30) + 5;
                            bar.style.height = `${height}px`;
                            
                            // Add random transition duration for more natural effect
                            const transitionDuration = Math.random() * 0.4 + 0.2; // 0.2s to 0.6s
                            bar.style.transition = `height ${transitionDuration}s ease`;
                        });
                        
                        setTimeout(animateVisualizer, 150);
                    }
                }
                
                // Event listeners
                btnPlayPause.addEventListener('click', togglePlayPause);
                audio.addEventListener('timeupdate', updateProgress);
                audio.addEventListener('loadedmetadata', function() {
                    durationEl.textContent = formatTime(audio.duration);
                });
                
                audio.addEventListener('error', function(e) {
                    console.error('Audio error:', e);
                    console.error('Audio src:', audio.src);
                    console.error('Error code:', e.target.error.code);
                    console.error('Error message:', e.target.error.message);
                });
                
                audio.addEventListener('ended', function() {
                    if (!isRepeat) {
                        btnPlayPause.innerHTML = '<i class="fas fa-play"></i>';
                        playerContainer.classList.remove('is-playing');
                        isPlaying = false;
                        stopVisualization();
                    }
                });
                
                progressContainer.addEventListener('click', setProgress);
                btnPrev.addEventListener('click', skipBackward);
                btnNext.addEventListener('click', skipForward);
                btnRepeat.addEventListener('click', toggleRepeat);
                btnSpeed.addEventListener('click', changeSpeed);
                volumeSlider.addEventListener('input', changeVolume);
                volumeIcon.addEventListener('click', toggleMute);
                
                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    if (e.code === 'Space') {
                        e.preventDefault();
                        togglePlayPause();
                    } else if (e.code === 'ArrowLeft') {
                        skipBackward();
                    } else if (e.code === 'ArrowRight') {
                        skipForward();
                    } else if (e.code === 'ArrowUp') {
                        e.preventDefault();
                        audio.volume = Math.min(1, audio.volume + 0.1);
                        volumeSlider.value = audio.volume;
                        updateVolumeIcon();
                    } else if (e.code === 'ArrowDown') {
                        e.preventDefault();
                        audio.volume = Math.max(0, audio.volume - 0.1);
                        volumeSlider.value = audio.volume;
                        updateVolumeIcon();
                    } else if (e.code === 'KeyM') {
                        toggleMute();
                    } else if (e.code === 'KeyR') {
                        toggleRepeat();
                    } else if (e.code === 'KeyS') {
                        changeSpeed();
                    }
                });
                
                // Create touch-friendly mobile experience
                if ('ontouchstart' in window) {
                    // Make buttons larger or adjust layout for touch
                    document.querySelectorAll('.control-btn').forEach(btn => {
                        btn.style.padding = '12px';
                    });
                }
                
                // Prevent page scrolling when adjusting volume slider on mobile
                volumeSlider.addEventListener('touchstart', function(e) {
                    e.stopPropagation();
                });
                
                // Try to preload the audio
                try {
                    audio.load();
                } catch (e) {
                    console.error("Could not preload audio:", e);
                }
            @endif
        });
    </script>
</body>
</html>