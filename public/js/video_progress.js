document.addEventListener("DOMContentLoaded", function () {

    const video = document.getElementById("video");

    if (!video) return;

    // Read data from HTML elements
    const userId   = video.dataset.userId;
    const courseId = video.dataset.courseId;
    //const videoId  = video.dataset.videoId;

    let lastSent = -1;
    let isSending = false;

    video.addEventListener("timeupdate", () => {
        if (!video.duration) return;
        const current = Math.floor(video.currentTime);
        if (current % 10 === 0 && current !== lastSent) {
            lastSent = current;
            sendProgress();
        }
    });

    video.addEventListener("pause", () => {
        if (!video.ended) sendProgress();
    });

    video.addEventListener("ended", () => {
        sendProgress();
    });

    window.addEventListener("beforeunload", () => {
    const watched     = Math.floor(video.currentTime);
    const duration    = Math.floor(video.duration);
    const percentage  = Math.floor((watched / duration) * 100);

    if (watched > 0) {
        navigator.sendBeacon('/tracking/app/api/save_watch_time.php',
            JSON.stringify({
                user_id:         userId,
                course_id:       courseId,
                video_id:        videoId,
                watched_seconds: watched,
                percentage:      percentage,
                status:          percentage >= 95 ? 'completed' : 'in progress'
            })
        );
    }
});
    function sendProgress() {
        const videoId  = video.dataset.videoId;
        if (isSending) return;
        isSending = true;

        const watched    = Math.floor(video.currentTime);
        const duration   = Math.floor(video.duration);
        const percentage = Math.floor((watched / duration) * 100);
        const status     = percentage >= 95 ? "completed" : "in progress";

        fetch('/tracking/app/api/save_watch_time.php', {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                user_id:         userId,
                course_id:       courseId,
                video_id:        videoId,
                watched_seconds: watched,
                percentage:      percentage,
                status:          status
            })
        })
        .catch(err => console.error("Error sending progress:", err))
        .finally(() => isSending = false);
    }
});