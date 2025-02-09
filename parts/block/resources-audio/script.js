document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelectorAll('#player').length > 0) {
        const player = document.getElementById('player');
        const playButton = document.getElementById('play_audio');
        const audiocls = document.getElementById('audio-cls');
        const downloadButton = document.getElementById('download_audio');
        const timeDisplay = document.getElementById('time_display');
        const endtimeDisplay = document.getElementById('endtime_display');
        let isPlaying = false;

        playButton.addEventListener('click', function() {
            if (isPlaying) {
                player.pause();
                playButton.classList.remove("push-btn");
                audiocls.style.visibility = "visible";
            } else {
                player.play();
                playButton.classList.add("push-btn");
                audiocls.style.visibility = "visible";
            }
            isPlaying = !isPlaying;
        });

        downloadButton.addEventListener('click', function() {
            const audioUrl = player.querySelector('source').src;
            const a = document.createElement('a');
            a.href = audioUrl;
            a.target = '_blank';
            a.click();
        });

        player.addEventListener('timeupdate', function() {
            const currentTime = player.currentTime;
            const duration = player.duration;
            const formattedTime = formatTime(currentTime);
            const formattedDuration = formatTime(duration);
            timeDisplay.textContent = formattedTime;
            endtimeDisplay.textContent = formattedDuration;
        });

        function formatTime(time) {
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            const formattedMinutes = String(minutes).padStart(2, '0');
            const formattedSeconds = String(seconds).padStart(2, '0');
            return formattedMinutes + ':' + formattedSeconds;
        }

        // Add event listener for play-timecode link
        document.querySelectorAll('.play-timecode').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                audiocls.style.visibility = "visible";
                const timecode = parseFloat(event.target.getAttribute('data-timecode'));
                player.currentTime = timecode;
                player.play();
                isPlaying = true;
                playButton.classList.add("push-btn");
            });
        });
    }

    // Resource Audio - Scroll enable
    if ( document.querySelectorAll('#resourceAudio').length>0 ){
        const resourceAudio = document.getElementById('resourceAudio');
        resourceAudio.addEventListener('click', function (event) {
            if (event.target.tagName === 'A' && event.target.getAttribute('href').startsWith('#')) {
                event.preventDefault();

                const targetId = event.target.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    if (window.innerWidth >= 768) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 280,
                            behavior: 'smooth'
                        });
                    } else {
                        window.scrollTo({
                            top: targetElement.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }
            }
        });
    }

    // Function to detect the browser and add a class accordingly
    function addBrowserSpecificClass() {
        var element = document.getElementById('audio-cls');

        // Get the user agent string
        var userAgent = navigator.userAgent;

        // Check for browsers and add specific class
        if (userAgent.indexOf('Firefox') > -1) {
            element.classList.add('firefox-class');
        } else if (userAgent.indexOf('Chrome') > -1 && userAgent.indexOf('Edg') === -1 && userAgent.indexOf('OPR') === -1) {
            element.classList.add('chrome-class');
        } else if (userAgent.indexOf('Edg') > -1) {
            element.classList.add('edge-class');
        } else if (userAgent.indexOf('Safari') > -1 && userAgent.indexOf('Chrome') === -1) {
            element.classList.add('safari-class');
        } else {
            element.classList.add('default-class');
        }
    }

    // Call the function
    addBrowserSpecificClass();
});
