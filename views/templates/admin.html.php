<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Admin Panel</h4>
        <span class="text-muted">Hello, <?= htmlspecialchars($name) ?></span>
    </div>

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#upload">Upload Video</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#videos">Videos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#progress">Student Progress</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#stats">Statistics</a>
        </li>
    </ul>

    <div class="tab-content">

        <!-- Upload Video Tab -->
        <div class="tab-pane fade show active" id="upload">
            <div class="card shadow-sm" style="max-width: 600px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Upload New Video</h5>
                    <div id="uploadMessage" class="mb-3"></div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" id="title" class="form-control" maxlength="50" placeholder="Video title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="description" class="form-control" rows="3" placeholder="Video description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duration (seconds)</label>
                        <input type="number" id="duration" class="form-control" min="1" placeholder="e.g. 120">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Video file (mp4, webm, ogg — max 500MB)</label>
                        <input type="file" id="video-file" class="form-control" accept="video/mp4,video/webm,video/ogg">
                    </div>
                    <div class="progress mb-3 d-none" id="progressContainer">
                        <div id="progressFill" class="progress-bar" style="width: 0%">0%</div>
                    </div>
                    <button class="btn btn-primary w-100" id="uploadBtn" onclick="uploadVideo()">
                        Upload Video
                    </button>
                </div>
            </div>
        </div>

        <!-- Videos Tab -->
        <div class="tab-pane fade" id="videos">
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="videosTable"></tbody>
                </table>
            </div>
        </div>

        <!-- Student Progress Tab -->
        <div class="tab-pane fade" id="progress">
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>User ID</th>
                            <th>Course ID</th>
                            <th>Video</th>
                            <th>Percentage</th>
                            <th>Status</th>
                            <th>Started</th>
                            <th>Completed</th>
                            <th>Last Activity</th>
                        </tr>
                    </thead>
                    <tbody id="progressTable"></tbody>
                </table>
            </div>
        </div>

        <!-- Statistics Tab -->
        <div class="tab-pane fade" id="stats">
            <div class="row g-4" id="statsCards"></div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/tracking/public/js/upload.js"></script>
<script src="/tracking/public/js/toggle.js"></script>
<script src="/tracking/public/js/video_admin.js"></script>
<script>
    // Pass PHP data to JS
    const ADMIN_DATA = <?= json_encode(['videos' => $videos, 'progress' => $progress, 'stats' => $stats]) ?>;
</script>

</body>
</html>