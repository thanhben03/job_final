
<!-- Modal Add Language -->
<div class="modal fade" id="modal-add-language" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Language</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input id="language-input" type="text" placeholder="Tiếng Hàn v.v" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addLanguage()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Certificate -->
<div class="modal fade" id="modal-add-certificate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="name-certificate-input" placeholder="Name" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="number" id="year-certificate-input" min="1900" max="2025" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addCertificate()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Add Skill -->
<div class="modal fade" id="modal-add-skill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Skill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="skill-input" placeholder="NodeJS, PHP... v.v" class="form-control">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addSkill()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Skill -->
<div class="modal fade" id="modal-add-soft-skill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Soft Skill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="soft-skill-input" placeholder="Kỹ năng abc ...." class="form-control">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addSoftSkill()">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-show-export-pdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-body">
                <p>CV của bạn đã được lưu thành công, bạn có thể sử dụng CV để ứng tuyển job ngay.</p>
            </div>
            <div class="modal-footer custom-footer">
                <a href="#" class="btn btn-success custom-btn" data-bs-dismiss="modal" aria-label="Close">Tiếp tục</a>
                <a href="#" download class="btn btn-primary custom-btn" style="background-color: #007bff !important; border-color: #007bff !important" title="Tải xuống hồ sơ" id="download-resume-btn" data-dismiss="modal" aria-label="Close">Tải xuống</a>
                <a href="/candidate/pre-profile?tab=manage-resume" class="btn btn-info custom-btn">Quản lý hồ sơ</a>
            </div>
        </div>
    </div>
</div>
