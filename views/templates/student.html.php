<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Videos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">My Videos</h4>
        <span class="text-muted">Hello, <?= htmlspecialchars($name) ?></span>
    </div>

    <div class="row g-4" id="videoList"></div>

</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <video id="video" class="w-100" controls
                    data-user-id="<?= htmlspecialchars($user_id) ?>"
                    data-course-id="<?= htmlspecialchars($course_id) ?>">
                    <source id="videoSource" src="" type="video/mp4">
                    Your browser does not support the video element.
                </video>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/tracking/public/js/video_progress.js"></script>
<script src="/tracking/public/js/student.js"></script>
<script>
    const STUDENT_DATA = <?= json_encode(['videos' => $videos]) ?>;
</script>

</body>
</html>