@extends('layouts.app')
@push('css')
    <!-- Styles -->
    <link rel="stylesheet" class="skin" type="text/css" href="{{{asset('/css/skins-type/skin-6.css')}}}">
    <link rel="stylesheet" href="{{asset('/css/devresume-1.css')}}">
    <link rel="stylesheet" href="{{asset('/css/job-go.css')}}">

    <style>
        .modal-footer.custom-footer {
            display: flex;
            justify-content: start;
        }
        .certificate-style {
            display: flex;
            width: 96%;
        }
        .resume-tagline-style {
            text-align: left;
        }
        .resume-name-style {
            font-size: 20px;
            text-align: left;
        }
        .input-info-basic {
            width: 87%;
        }
        .block-language-item {
            background: #000000;
            color: white;
            padding: 3px 3px;
            margin: 5px 4px;
            display: inline-block;
            border-radius: 5px;
        }
        .cv-block-content {
            text-align: left;
        }
        .cv-block-title {
            background: black;
            color: white;
            padding: 4px 16px;
            border-radius: 4px;
            margin-top: 10px;
            display: block;
        }
        .input-block-cv {
            width: 100%;
            border: none;
            margin-top: 7px;
        }
        .resume-wrapper {
            filter: none !important;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-bold-50 {
            font-weight: 500;
        }

        .cvo-left-col, .cvo-right-col {
            background-color: #fff !important;
        }

        .cvo-left-col .cvo-block-title {
            /*background: #333;*/
            border-radius: 0px 50px 50px 0px;
            padding: 10px;
            color: #fff;
            font-weight: bold;
        }

        .cvo-right-col .cvo-block-title {
            /*background: #333;*/
            border-radius: 50px 0px 0px 50px;
            padding: 10px !important;
            width: 100%;
            color: #FFF;
            font-weight: bold;
        }

        .cv-block {
            padding: 0 !important;
        }

        .medium-editor-placeholder:after {
            font-style: inherit;
        }

        .avatar-box {
            border: 5px solid #c7c5c5
        }

        .resume-tagline {
            font-style: italic;
        }

        .resume-tagline:after {
            content: "";
            width: 25%;
            display: block;
            border-bottom: none !important;
            padding-bottom: 10px;
        }

        .skill-dots {
            display: inline-block;
        }

        .skill-dot {
            width: 12px;
            height: 12px;
            margin-right: 5px;
            border-radius: 50%;
            background-color: #ccc;
            display: inline-block;
        }

        .skill-dot.filled {
            /*background-color: #272727;*/
        }

        .education-timeline {
            position: relative;
            padding-left: 30px;
            margin-left: 10px;
        }

        .job-history-timeline {
            position: relative;
            padding-left: 30px;
            margin-left: 10px;
        }

        .timeline-line {
            position: absolute;
            top: 0;
            bottom: 0;
            left: -31px;
            width: 2px;
            /*background-color: #333;*/
        }

        .timeline-item {
            position: relative;
            /*margin-bottom: 30px;*/
            /*padding-left: 20px;*/
        }

        .timeline-dot {
            position: absolute;
            top: -1px;
            left: -37px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            /*background-color: #333;*/
            z-index: 1;
        }

        .timeline-dot-2 {
            position: absolute;
            bottom: -1px;
            left: -37px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            /*background-color: #333;*/
            z-index: 1;
        }

        .timeline-content {
            /*padding: 15px;*/
        }

        @media print {
            @page {
                margin: 0px;
            }
            .container {
                max-width: 100% !important;
                margin: 0px !important;
                padding: 0px !important;
            }
            .resume-wrapper {
                /*margin-bottom: 60px !important;*/
            }
            .footer {
                margin: 0px;
                padding: 0px;
            }
            .shadow-lg {
                box-shadow: 0 0rem 0rem rgba(0,0,0,0.175) !important;
            }
        }

    </style>
@endpush
@section('content')
    <x-modal.modal-manage-profile />
    <!-- OUR BLOG START -->
    <div class="section-full p-t120  p-b90 site-bg-white" id="prepend-content-profile">


        <div class="container" id="content-profile">
                <div class="">
                    <div class="row">

                        <div class="col-md-4 text-center">
                            <div class="part-1">
                                <div style="display: block; border: none" class="dashboard-profile-photo">
                                    <img src="https://employer.jobsgo.vn/media/img/male.jpg" alt="">
                                    <div class="upload-btn-wrapper">
                                        <div id="upload-image-grid">
                                        </div>
                                        <div id="upload-avatar">
                                            <button class="site-button button-sm hide-btn-upload">Upload Photo</button>
                                            <input onchange="uploadAvatar(this)" type="file" class="hide-btn-upload" name="myfile" id="file-uploader" accept=".jpg, .jpeg, .png">
                                        </div>
                                    </div>
                                </div>
                                <p class="resume-name-style resume-name cv-editable-elem candidate-name active-color arial-text-font-weight mt-3 medium-editor-element" data-placeholder="Tên" info-group="candidate" info-name="name" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="1" >Bền Nguyễn</p>
                                <p class="resume-tagline-style resume-tagline cv-editable-elem candidate-name active-color arial-text-font-weight mt-3 medium-editor-element" data-placeholder="Tên" info-group="candidate" info-name="name" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" >Vị trí mong muốn</p>

                            </div>
                            <div class="info-profile">
                                <div class="cv-block-title">
                                    Thông tin cá nhân
                                </div>
                                <div class="cv-block-content">
                                    <div class="row social-container align-items-center mb-2 flex-nowrap" >
                                        <i class="w-auto fas fa-map-marker-alt"></i>
                                        <input class="input-info-basic cv-editable-elem active-color" placeholder="Tỉnh/thành phố" contenteditable="true" spellcheck="true" />
                                    </div>
                                    <div class="row social-container align-items-center mb-2 flex-nowrap" >
                                        <i class="w-auto fas fa-phone"></i>
                                        <input class="input-info-basic cv-editable-elem active-color" placeholder="Phone" contenteditable="true" spellcheck="true" />
                                    </div>
                                    <div class="row social-container align-items-center mb-2 flex-nowrap" >
                                        <i class="w-auto fas fa-calendar"></i>
                                        <input class="input-info-basic cv-editable-elem active-color" placeholder="Ngày sinh" contenteditable="true" spellcheck="true" />
                                    </div>
                                    <div class="row social-container align-items-center mb-2 flex-nowrap" >
                                        <i class="w-auto fas fa-mail-bulk"></i>
                                        <input class="input-info-basic cv-editable-elem active-color" placeholder="Email" contenteditable="true" spellcheck="true" />
                                    </div>

                                </div>
                            </div>

                            <div class="info-skill">
                                <div class="cv-block-title">
                                    Kỹ năng
                                </div>
                                <div class="cv-block-content" id="skill-wrap">
                                    <span class="block-language-item">NodeJS</span>
                                    <span class="block-language-item">PHP</span>
                                    <span class="block-language-item">JavaScript</span>
                                </div>
                                <div id="activity-container" onclick="showModalAddSkill()" >
                                    <div class="add-new-btn text-center" id="add-activity-template" data-toggle="tooltip" data-placement="top" title="" data-original-title="Thêm biểu mẫu" aria-describedby="tooltip575513" bis_skin_checked="1">
                                        Thêm mới
                                    </div>
                                </div>
                            </div>
                            <div class="info-soft-skill">
                                <div class="cv-block-title">
                                    Kỹ năng mềm
                                </div>
                                <div class="cv-block-content">
                                    <ol class="cv-list-soft-skill" style="margin-left: 16px" id="soft-skill-wrap">
                                        <li>Thuyết trình</li>
                                        <li>Làm việc nhóm</li>
                                        <li>Chịu được áp lực công việc</li>
                                    </ol>
                                </div>
                                <div id="activity-container" onclick="showModalAddSoftSkilll()">
                                    <div class="add-new-btn text-center" id="add-activity-template" data-toggle="tooltip" data-placement="top" title="" data-original-title="Thêm biểu mẫu" aria-describedby="tooltip575513" bis_skin_checked="1">
                                        Thêm mới
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <!-- Tóm tắt -->
                            <div class="objective-container">
                                <div class="cv-block-title">Tóm tắt</div>
                                <div class="cv-block-content" id="objective-wrap">
{{--                                    <input  class="input-block-cv" type="text" placeholder="Mục tiêu dài hạn, ngắn hạn v.v">--}}
                                    <div class="cvo-block-content cv-editable-elem mt-3 medium-editor-element" data-placeholder="Mục tiêu: ngắn hạn, dài hạn." info-group="candidate" info-name="short_bio_html" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="1" data-medium-focused="true">
                                        Mục tiêu ngắn hạn, mục tiêu dài hạn
                                    </div>
                                </div>
                            </div>

                            <!-- Học vấn -->
                            <div class="education">
                                <div class="cv-block-title">Học vấn</div>
                                <div class="cv-block-content" id="education-wrap">

                                </div>
                                <div id="activity-container" onclick="addEducation()">
                                    <div class="add-new-btn text-center" id="add-activity-template" data-toggle="tooltip" data-placement="top" title="" data-original-title="Thêm biểu mẫu" aria-describedby="tooltip575513">
                                        Thêm mới
                                    </div>
                                </div>
                            </div>

                            <!-- Kinh nghiệm làm việc -->
                            <div class="experience">
                                <span class="cv-block-title"><!-- <i class="fas fa-briefcase mx-2"></i> --> Kinh nghiệm làm việc</span>

                                <div class="cvo-block-content" id="experience-wrap" >
                                    <div id="job-history-container" ><div class="job-history-timeline mt-3" >
                                            <div class="timeline-item item mb-0 cv-child-elem history-item mb-3" >
                                                <div class="timeline-line" ></div>
                                                <div class="timeline-dot" ></div>
                                                <div class="timeline-content" >
                                                    <div class="row" >
                                                        <div class="col-sm-8 col-md-8" >
                                                            <div class="cv-editable-elem text-bold spec-heading required medium-editor-element" data-placeholder="Tên công ty" info-group="job_history" info-name="job_company" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="3" medium-editor-index="6d6a75a1-9bcb-7302-780a-015081ae9997" >Công ty CP ...                    </div>
                                                            <div class="item-title text-bold-50 spec-heading mb-md-0 cv-editable-elem required medium-editor-element" data-placeholder="Vị trí/công việc" info-name="job_title" info-group="job_history" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="3" medium-editor-index="c1ee558e-dcdc-5bbb-1d4b-72964a0df58a" >Chuyên viên Digital Sale                    </div>
                                                        </div>
                                                        <div class="col-sm-4 col-md-4 text-right pr-2" >
                                                            <p class="cv-editable-elem d-inline required medium-editor-element" data-placeholder="Năm bắt đầu" info-group="job_history" info-name="date_start" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="3" medium-editor-index="468827eb-da6a-0c1c-31f1-6139e9114167">10/2023</p>
                                                            -
                                                            <p class="cv-editable-elem d-inline required medium-editor-element" data-placeholder="Năm kết thúc" info-group="job_history" info-name="date_end" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="3" medium-editor-index="b1cc56f3-8275-c51a-2bb3-32f0198f9565">10/2024</p>
                                                        </div>
                                                    </div>
                                                    <div class="item-content cv-editable-elem required medium-editor-element" data-placeholder="Mô tả công việc" info-name="job_description_html" info-group="job_history" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="3" medium-editor-index="e4f64eb8-fef7-ba7d-a5c5-044fbda3a8ef" >
                                                        <ul>
                                                            <li>Nắm vững các thông tin về sản phẩm dịch vụ công ty cung cấp</li>
                                                            <li>Tìm kiếm khách hàng tiềm năng: Gặp gõ hoặc Gọi điện liên hệ giới thiệu cho khách hàng về sản phẩm dịch vụ, nắm bắt nhu cầu tư vấn, cho khách dùng thử sản phẩm, giúp khách tiếp cận được các sản phẩm đang cần mua</li>
                                                            <li>Báo giá và đàm phán giá cả, thương thảo hợp đồng mua bán, thoả thuận thời hạn thanh toán và giao hàng</li>
                                                            <li>Kiểm kê hàng hoá: Nộp hóa đơn bán hàng hằng ngày. Kiểm kê dụng cụ hỗ trợ kinh doanh</li>
                                                            <li>Gửi báo cáo kinh doanh cho cấp trên</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="timeline-dot-2" ></div>
                                            </div><!--//item-->
                                        </div></div>
                                </div>
                                <div id="activity-container" onclick="addExperience()">
                                    <div class="add-new-btn text-center" id="add-activity-template" data-toggle="tooltip" data-placement="top" title="" data-original-title="Thêm biểu mẫu" aria-describedby="tooltip575513">
                                        Thêm mới
                                    </div>
                                </div>
                            </div>

                            <!-- Ngôn ngữ -->
                            <div class="language">
                                <div class="cv-block-title">
                                    Ngôn ngữ
                                </div>
                                <div class="cv-block-content" id="language-wrap">
                                    <span class="block-language-item" >Tiếng anh</span>
                                    <span class="block-language-item" >Tiếng nhật</span>
                                    <span class="block-language-item" >Tiếng hàn</span>
                                </div>
                                <div id="activity-container" onclick="showModalAddLanguage()">
                                    <div class="add-new-btn text-center" id="add-activity-template" data-toggle="tooltip" data-placement="top" title="" data-original-title="Thêm biểu mẫu" aria-describedby="tooltip575513">
                                        Thêm mới
                                    </div>
                                </div>
                            </div>

                            <!-- Chứng chỉ -->
                            <div class="certificate">
                                <div class="cv-block-title">
                                    Chứng chỉ
                                </div>
                                <div class="cv-block-content" id="certificate-wrap">
                                    <div class="certificate-style">
                                        <div class="resume-degree spec-heading d-inline cv-editable-elem required col-sm-8 col-md-8 medium-editor-element" data-placeholder="Tên chứng chỉ" info-group="certificates" info-name="name" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="4" >Chứng chỉ IELTS 7.0</div>
                                        <p class="cv-editable-elem d-inline required col-sm-4 col-md-4 text-right pr-2 medium-editor-element" data-placeholder="Năm" info-group="certificates" info-name="year" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="4" medium-editor-index="b96210e3-1850-2879-3e9f-790bb3d66c70">2023</p>
                                    </div>
                                </div>
                                <div id="activity-container" onclick="showModalAddCertificate()">
                                    <div class="add-new-btn text-center" id="add-activity-template" data-toggle="tooltip" data-placement="top" title="" data-original-title="Thêm biểu mẫu" aria-describedby="tooltip575513">
                                        Thêm mới
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <button
                onclick="exportToPdf()"
                style="
            display: flex;
            margin: 19px auto;"
                id="downloadPDF" class="btn btn-primary">Lưu CV</button>

        </div>

    <!-- OUR BLOG END -->
@endsection
@push('js')

            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
            <script src="{{asset('/js/manage-profile.js')}}"></script>

    <script>
        function exportToPdf (){
            let htmlUploadBtn = `
    <button class="site-button button-sm hide-btn-upload">Upload Photo</button>
    <input onchange="uploadAvatar(this)" type="file" class="hide-btn-upload" name="myfile" id="file-uploader" accept=".jpg, .jpeg, .png">
    `
            let uploadBtn = $(".hide-btn-upload");
            let addNewBtn = $(".add-new-btn");
            let downloadBtn = $("#downloadPDF");
            let element = document.querySelector('#content-profile');
            let clone = element.cloneNode(true);
            uploadBtn.remove();
            addNewBtn.remove();
            downloadBtn.remove();



            // let element = document.querySelector('#content-profile') // Select the body or any part you want to export
            let options = {
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }

            }
            html2pdf()
                .set(options)
                .from(element)
                .output('blob')
                .then(function (pdfBlob) {
                    let formData = new FormData();
                    formData.append('file', pdfBlob, 'test.pdf');

                    $.ajax({
                        url: '{{route('api.file.upload')}}',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào header
                        },
                        data: formData,
                        success: function(response) {
                            $("#download-resume-btn").attr("href", response.file_path)
                            $("#modal-show-export-pdf").modal('toggle')

                        },
                        error: function(xhr, status, error) {
                            console.error('Lỗi: ' + error);
                        }
                    });
                })


            setTimeout(function () {
                $("#prepend-content-profile").empty()
                $("#prepend-content-profile").append(clone)

            }, 1500)

        }
    </script>
@endpush
