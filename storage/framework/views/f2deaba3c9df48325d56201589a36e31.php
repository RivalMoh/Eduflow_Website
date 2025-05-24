<div class="w-full bg-white rounded-xl shadow-lg p-6 space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h3 class="text-xl font-bold text-gray-800">Pomodoro Timer</h3>
        <p class="text-sm text-gray-500">Stay focused, be productive</p>
    </div>
    
    <!-- Timer Display -->
    <div class="relative w-48 h-48 mx-auto rounded-full bg-gradient-to-br from-purple-50 to-indigo-50 ring-4 ring-purple-100 flex items-center justify-center">
        <!-- Progress Ring -->
        <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="45" fill="none" stroke="#e9d5ff" stroke-width="8" />
            <circle id="progress-ring" cx="50" cy="50" r="45" fill="none" stroke="#8b5cf6" stroke-width="8" 
                  stroke-dasharray="283" stroke-dashoffset="0" stroke-linecap="round" />
        </svg>
        
        <!-- Timer -->
        <div class="relative z-10 text-center">
            <div id="timer" class="text-4xl font-mono font-bold text-gray-800">25:00</div>
            <div id="timer-status" class="text-sm font-medium text-purple-600 mt-1">Focus Time</div>
        </div>
    </div>

    <!-- Session Info -->
    <div class="text-center">
        <div class="inline-flex items-center space-x-1 bg-gray-100 rounded-full px-3 py-1">
            <span class="text-xs font-medium text-gray-600">Session:</span>
            <span id="session-count" class="text-sm font-semibold text-purple-600">1/4</span>
        </div>
    </div>

    <!-- Controls -->
    <div class="flex flex-col space-y-3">
        <button onclick="toggleTimer()" id="start-stop" 
                style="background-color: #7C3AED;"
                class="w-full py-3 px-6 text-white rounded-lg font-bold text-base">
            <div class="flex items-center justify-center space-x-2">
                <svg id="play-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                </svg>
                <svg id="pause-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span id="action-text">Start</span>
            </div>
        </button>
        
        <div class="grid grid-cols-2 gap-3">
            <button onclick="resetTimer()"
                    class="py-2 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg 
                    transition-all duration-200 active:scale-95 text-sm font-medium flex items-center justify-center space-x-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                </svg>
                <span>Reset</span>
            </button>
            <button onclick="skipSession()"
                    class="py-2 px-3 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg 
                    transition-all duration-200 active:scale-95 text-sm font-medium flex items-center justify-center space-x-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                <span>Skip</span>
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<script>
    let timerInterval;
    let totalSeconds = 25 * 60; // 25 minutes
    let isRunning = false;
    let isBreak = false;
    let sessionCount = 1;
    const totalSessions = 4;
    
    const timerDisplay = document.getElementById('timer');
    const timerStatus = document.getElementById('timer-status');
    const sessionCountEl = document.getElementById('session-count');
    const startStopBtn = document.getElementById('start-stop');
    const playIcon = document.getElementById('play-icon');
    const pauseIcon = document.getElementById('pause-icon');
    const actionText = document.getElementById('action-text');
    const progressRing = document.getElementById('progress-ring');
    
    // Initialize
    updateDisplay();
    
    function toggleTimer() {
        if (isRunning) {
            pauseTimer();
        } else {
            startTimer();
        }
    }
    
    function startTimer() {
        if (!isRunning) {
            isRunning = true;
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
            actionText.textContent = 'Pause';
            
            timerInterval = setInterval(() => {
                if (totalSeconds > 0) {
                    totalSeconds--;
                    updateDisplay();
                } else {
                    handleTimerComplete();
                }
            }, 1000);
        }
    }
    
    function pauseTimer() {
        clearInterval(timerInterval);
        isRunning = false;
        playIcon.classList.remove('hidden');
        pauseIcon.classList.add('hidden');
        actionText.textContent = 'Resume';
    }
    
    function resetTimer() {
        clearInterval(timerInterval);
        isRunning = false;
        isBreak = false;
        totalSeconds = 25 * 60;
        sessionCount = 1;
        updateDisplay();
        playIcon.classList.remove('hidden');
        pauseIcon.classList.add('hidden');
        actionText.textContent = 'Start';
        document.getElementById('progress-ring').style.strokeDashoffset = '0';
    }
    
    function skipSession() {
        clearInterval(timerInterval);
        isRunning = false;
        handleTimerComplete();
    }
    
    function handleTimerComplete() {
        clearInterval(timerInterval);
        
        if (isBreak) {
            // Break finished, start next session
            isBreak = false;
            totalSeconds = 25 * 60;
            timerStatus.textContent = 'Focus Time';
            timerStatus.classList.remove('text-amber-500');
            timerStatus.classList.add('text-purple-600');
            document.querySelector('.from-purple-500').classList.remove('from-amber-400');
            document.querySelector('.from-purple-500').classList.add('from-purple-500');
            document.querySelector('.to-indigo-500').classList.remove('to-amber-300');
            document.querySelector('.to-indigo-500').classList.add('to-indigo-500');
        } else {
            // Session finished, take a break
            isBreak = true;
            totalSeconds = 5 * 60; // 5-minute break (you can adjust this)
            timerStatus.textContent = 'Break Time!';
            timerStatus.classList.remove('text-purple-600');
            timerStatus.classList.add('text-amber-500');
            document.querySelector('.from-purple-500').classList.remove('from-purple-500');
            document.querySelector('.from-purple-500').classList.add('from-amber-400');
            document.querySelector('.to-indigo-500').classList.remove('to-indigo-500');
            document.querySelector('.to-indigo-500').classList.add('to-amber-300');
            
            // Only increment session count after a focus session
            if (sessionCount < totalSessions) {
                sessionCount++;
                sessionCountEl.textContent = `${sessionCount}/${totalSessions}`;
            } else if (sessionCount === totalSessions) {
                // All sessions complete
                sessionCountEl.textContent = 'Complete!';
                sessionCountEl.classList.add('text-green-500');
            }
        }
        
        // Play sound (you can uncomment this if you add a sound file)
        // new Audio('/path/to/sound.mp3').play();
        
        // Flash animation
        const timerCircle = document.querySelector('.rounded-full');
        timerCircle.classList.add('pulse-animation');
        setTimeout(() => {
            timerCircle.classList.remove('pulse-animation');
        }, 2000);
        
        updateDisplay();
    }
    
    function updateDisplay() {
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Update progress ring
        const totalTime = isBreak ? (5 * 60) : (25 * 60);
        const progress = 1 - (totalSeconds / totalTime);
        const offset = 283 - (progress * 283);
        progressRing.style.strokeDashoffset = offset;
    }
</script>
<?php /**PATH C:\xampp\htdocs\eduflow\resources\views/tasks/partials/pomodoro.blade.php ENDPATH**/ ?>