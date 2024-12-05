<div class="modal fade" id="banReasonModal" tabindex="-1" aria-labelledby="banReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="banReasonModalLabel">Nhập lý do khóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea id="banReasonInput" class="form-control" placeholder="Lý do..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveBanReason">Lưu</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('showBanReasonModal', function (event) {
        const recordId = event.detail.recordId;

        // Hiển thị modal
        const modal = new bootstrap.Modal(document.getElementById('banReasonModal'));
        modal.show();

        // Xử lý khi lưu lý do
        document.getElementById('saveBanReason').onclick = function () {
            const reason = document.getElementById('banReasonInput').value;

            // Gửi dữ liệu qua AJAX
            fetch('/api/save-ban-reason', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ recordId: recordId, reason: reason })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Lý do khóa đã được lưu!');
                        modal.hide();
                    } else {
                        alert('Có lỗi xảy ra.');
                    }
                });
        };
    });
</script>
