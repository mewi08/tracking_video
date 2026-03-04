document.addEventListener("DOMContentLoaded", function () {

    renderVideos(STUDENT_DATA.videos);

    function renderVideos(videos) {
        const container = document.getElementById('videoList');

        if (videos.length === 0) {
            container.innerHTML = '<div class="col"><div class="alert alert-info">No videos available at the moment.</div></div>';
            return;
        }

        container.innerHTML = videos.map(v => `
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">${escapeHtml(v.title)}</h5>
                        <p class="card-text text-muted">${escapeHtml(v.description)}</p>
                        <p class="card-text">
                            <small class="text-muted">Duration: ${formatDuration(v.duration_seconds)}</small>
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-primary w-100"
                            onclick="playVideo(${v.id}, '${v.video_url}', '${escapeHtml(v.title)}')">
                            Watch Video
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function formatDuration(seconds) {
        return new Date(seconds * 1000).toISOString().substring(11, 19);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});

function playVideo(id, url, title) {
    const video  = document.getElementById('video');
    const source = document.getElementById('videoSource');
    const modal  = new bootstrap.Modal(document.getElementById('videoModal'));

    source.src            = url;
    video.dataset.videoId = id;
    document.getElementById('videoTitle').textContent = title;

    video.load();
    modal.show();
}
