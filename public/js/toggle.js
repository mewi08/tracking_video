function toggleVideo(id, isActive) {
    fetch('/tracking/app/api/toggle_video.php', {
        method:  'POST',
        headers: { 'Content-Type': 'application/json' },
        body:    JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const badge = document.getElementById('badge-' + id);
            const btn   = document.getElementById('btn-' + id);
            if (isActive) {
                badge.className   = 'badge bg-secondary';
                badge.textContent = 'Inactive';
                btn.className     = 'btn btn-sm btn-success';
                btn.textContent   = 'Activate';
                btn.onclick       = () => toggleVideo(id, false);
            } else {
                badge.className   = 'badge bg-success';
                badge.textContent = 'Active';
                btn.className     = 'btn btn-sm btn-warning';
                btn.textContent   = 'Deactivate';
                btn.onclick       = () => toggleVideo(id, true);
            }
        }
    })
    .catch(err => console.error('Error toggling video:', err));
}