document.addEventListener("DOMContentLoaded", function () {

    renderVideos(ADMIN_DATA.videos);
    renderProgress(ADMIN_DATA.progress);
    renderStats(ADMIN_DATA.stats);

    function renderVideos(videos) {
        const tbody = document.getElementById('videosTable');

        if (videos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No videos found</td></tr>';
            return;
        }

        tbody.innerHTML = videos.map(v => `
            <tr id="row-${v.id}">
                <td>${v.id}</td>
                <td>${escapeHtml(v.title)}</td>
                <td>${escapeHtml(v.description)}</td>
                <td>${formatDuration(v.duration_seconds)}</td>
                <td>
                    <span class="badge ${v.is_active ? 'bg-success' : 'bg-secondary'}" id="badge-${v.id}">
                        ${v.is_active ? 'Active' : 'Inactive'}
                    </span>
                </td>
                <td>${v.created_at}</td>
                <td>
                    <button class="btn btn-sm ${v.is_active ? 'btn-warning' : 'btn-success'}"
                        id="btn-${v.id}"
                        onclick="toggleVideo(${v.id}, ${v.is_active})">
                        ${v.is_active ? 'Deactivate' : 'Activate'}
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function renderProgress(progress) {
        const tbody = document.getElementById('progressTable');

        if (progress.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center">No progress data found</td></tr>';
            return;
        }

        tbody.innerHTML = progress.map(row => `
            <tr>
                <td>${row.user_id}</td>
                <td>${row.course_id}</td>
                <td>${escapeHtml(row.video_title)}</td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar ${row.percentage >= 95 ? 'bg-success' : 'bg-primary'}"
                            style="width: ${row.percentage}%">
                            ${row.percentage}%
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge ${
                        row.status === 'completed'   ? 'bg-success' :
                        row.status === 'in progress' ? 'bg-primary'  : 'bg-secondary'}">
                        ${row.status}
                    </span>
                </td>
                <td>${row.started_at   ?? '-'}</td>
                <td>${row.completed_at ?? '-'}</td>
                <td>${row.last_activity}</td>
            </tr>
        `).join('');
    }

    function renderStats(stats) {
        const container = document.getElementById('statsCards');

        container.innerHTML = `
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Students</h6>
                        <h2 class="text-primary">${stats.total_students}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Completed</h6>
                        <h2 class="text-success">${stats.completed}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">In Progress</h6>
                        <h2 class="text-warning">${stats.in_progress}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Avg. Percentage</h6>
                        <h2 class="text-info">${stats.avg_percentage}%</h2>
                    </div>
                </div>
            </div>
        `;
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