let countEducationItem = 0;

function addEducation() {
    let educationWrap = document.querySelector('#education-wrap')
    let html = `
        <div class="education-timeline mt-3" id="edication-item-${countEducationItem}">
        <div class="timeline-item item cv-child-elem education-item mb-2">
            <div class="timeline-line"></div>
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="row">
                    <div class="col-sm-8 col-md-8 spec-heading text-bold">
                        <div class="cv-editable-elem text-bold spec-heading required medium-editor-element" data-placeholder="Tên trường" info-group="education" info-name="school_name" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="2" medium-editor-index="779e7749-83fb-84a4-5489-9c8d57087da9">Đại học ...                    </div>
                        <div class="mb-0 text-bold-50 spec-heading cv-editable-elem required medium-editor-element" data-placeholder="Chuyên ngành" info-name="specialization" info-group="education" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="2" medium-editor-index="35246df8-d959-31f7-f26b-5e72b22d5ec4">Quản trị kinh doanh                    </div>
                    </div>
                    <div class="col-sm-4 col-md-4 pr-2 text-right">
                        <p class="cv-editable-elem d-inline required medium-editor-element" data-placeholder="Năm bắt đầu" info-group="education" info-name="date_start" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="2" medium-editor-index="0d12590e-8514-0ed8-edb1-ed2e2cb6531d">10/2024</p>
                        -
                        <p class="cv-editable-elem d-inline required medium-editor-element" data-placeholder="Năm kết thúc" info-group="education" info-name="date_end" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="2" medium-editor-index="f7b782a4-d632-d5f6-6811-4421edfb945c">10/2024</p>
                    </div>
                </div>
                <div class="item-content cv-editable-elem mb-3 medium-editor-element" data-placeholder="Mô tả học vấn" info-name="hightlight" info-group="education" contenteditable="true" spellcheck="true" data-medium-editor-element="true" role="textbox" aria-multiline="true" data-medium-editor-editor-index="2" medium-editor-index="0e07f98b-eede-c042-2111-4d9606d20169" data-medium-focused="true">
                    Tốt nghiệp loại Giỏi
                </div>
            </div>
            <div class="timeline-dot-2"></div>
        </div><!--//item-->
    </div>
    `

    countEducationItem++;
    educationWrap.insertAdjacentHTML('beforeend', html);

}


let countExperience = 0;
function addExperience() {
    let experienceWrap = document.querySelector('#experience-wrap')
    let html = `
        <div id="job-history-container" id="job-history-${countExperience++}" >
            <div class="job-history-timeline mt-3" >
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
            </div>

        </div>

    `
    countEducationItem++;
    experienceWrap.insertAdjacentHTML('beforeend', html);
}

function showModalAddLanguage() {
    $("#modal-add-language").modal('toggle');
}

function showModalAddCertificate() {
    $("#modal-add-certificate").modal('toggle');
}

function showModalAddSkill() {
    $("#modal-add-skill").modal('toggle');
}

function showModalAddSoftSkilll() {
    $("#modal-add-soft-skill").modal('toggle');
}

function addLanguage() {
    let languageInput = document.querySelector('#language-input');
    if (languageInput.value === '') {

        return;
    }
    document.querySelector('#languageWrap')
            .insertAdjacentHTML('beforeend',
        `<span class="block-language-item">${languageInput.value}</span>`)
    languageInput.value = ''
}


function addCertificate() {
    let nameCertificateInput = document.querySelector('#name-certificate-input');
    let yearCertificateInput = document.querySelector('#year-certificate-input');

    document.querySelector('#certificate-wrap').insertAdjacentHTML('beforeend', `
        <div class="certificate-style">
            <div
            class="resume-degree spec-heading d-inline cv-editable-elem required col-sm-8 col-md-8 medium-editor-element"
            data-placeholder="Tên chứng chỉ"
            contenteditable="true" spellcheck="true"
            data-medium-editor-element="true" role="textbox"
            aria-multiline="true" data-medium-editor-editor-index="4" >${nameCertificateInput.value}        </div>
            <p
            class="cv-editable-elem d-inline required col-sm-4 col-md-4 text-right pr-2 medium-editor-element"
            data-placeholder="Năm"
            contenteditable="true"
            spellcheck="true"
            data-medium-editor-element="true" role="textbox"
            aria-multiline="true" data-medium-editor-editor-index="4"
            medium-editor-index="b96210e3-1850-2879-3e9f-790bb3d66c70">${yearCertificateInput.value}</p>
        </div>
    `)

    nameCertificateInput.value = '';
    yearCertificateInput.value = '';
}


function addSkill() {
    let skillInput = document.querySelector('#skill-input')
    document.querySelector('#skill-wrap').insertAdjacentHTML('beforeend', `
         <span class="block-language-item">${skillInput.value}</span>
    `)

    skillInput.value = ''
}

function addSoftSkill() {
    let softSkillInput = document.querySelector('#soft-skill-input')
    document.querySelector('#soft-skill-wrap').insertAdjacentHTML('beforeend', `
         <li>${softSkillInput.value}</li>
    `)

    softSkillInput.value = ''
}

