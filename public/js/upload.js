function uploadVideo() {
    const title       = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const duration    = document.getElementById('duration').value;
    const videoFile   = document.getElementById('video-file').files[0];
    const btn         = document.getElementById('uploadBtn');

    if (!title || !description || !duration || !videoFile) {
        showMessage('All fields are required', 'error');
        return;
    }

    const formData = new FormData();
    formData.append('title',            title);
    formData.append('description',      description);
    formData.append('duration_seconds', duration);
    formData.append('video',            videoFile);

    document.getElementById('progressContainer').classList.remove('d-none');
    btn.disabled = true;

    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', (e) => {
        if (e.lengthComputable) {
            const percent = Math.round((e.loaded / e.total) * 100);
            document.getElementById('progressFill').style.width = percent + '%';
            document.getElementById('progressFill').textContent  = percent + '%';
        }
    });

    xhr.addEventListener('load', () => {
        btn.disabled = false;
        const response = JSON.parse(xhr.responseText);
        if (response.status === 'success') {
            showMessage(`Video uploaded successfully. ID: ${response.video_id}`, 'success');
            clearForm();
        } else {
            showMessage(response.error, 'error');
        }
        document.getElementById('progressContainer').classList.add('d-none');
    });

    xhr.addEventListener('error', () => {
        btn.disabled = false;
        showMessage('Upload failed. Please try again.', 'error');
        document.getElementById('progressContainer').classList.add('d-none');
    });

    xhr.open('POST', '/tracking/app/api/upload_video.php');
    xhr.send(formData);
}

function showMessage(text, type) {
    const message       = document.getElementById('uploadMessage');
    message.textContent = text;
    message.className   = `alert alert-${type === 'success' ? 'success' : 'danger'}`;
}

function clearForm() {
    document.getElementById('title').value       = '';
    document.getElementById('description').value = '';
    document.getElementById('duration').value    = '';
    document.getElementById('video-file').value  = '';
}