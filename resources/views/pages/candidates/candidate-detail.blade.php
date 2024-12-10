@extends('layouts.app')

@section('content')
    <!-- Modal QuickChat Candidate-->
    <div class="modal fade" id="modal-quickchat-candidate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.Leave your message') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input placeholder="Enter a message !" id="message" class="form-control" type="text"
                        name="message">
                    <input type="text" name="user_id" id="user_id" hidden value="{{ $candidate['id'] }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ trans('lang.close') }}</button>
                    <button type="button" onclick="sendMessage()" class="btn btn-primary">{{ trans('lang.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Send Interview Invitation Letter-->
    <div class="modal fade" id="modal-invite-interview" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Interview Invitation Letter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($candidate['flag'])
                        <p>
                            <i style="color: red" class="fas fa-exclamation-triangle"></i>
                            This user is being flagged!
                        </p>
                    @endif
                    <div class="form-group">
                        <label for="">Title: </label>
                        <input value="Thư Mời Tham Gia Phỏng Vấn !" placeholder="Enter a title for gmail !" id="title"
                            class="form-control" type="text" name="message">
                    </div>
                    <div class="form-group">
                        <label for="">Position: </label>
                        <input value="Intern Laravel" placeholder="Ex: Intern Laravel !" id="position" class="form-control"
                            type="text" name="message">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Time: </label>
                                <input type="datetime-local" placeholder="Enter a the time !" id="time"
                                    class="form-control" name="message">
                            </div>

                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Location: </label>
                                <input value="Hai Bà Trưng, Hà Nội" placeholder="Enter a location !" id="location"
                                    class="form-control" type="text" name="message">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Email: </label>
                                <input value="abc@gmail.com" placeholder="Enter a location !" id="email"
                                    class="form-control" type="text" name="message">
                            </div>

                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Phone: </label>
                                <input value="0772857483" placeholder="Enter a location !" id="phone"
                                    class="form-control" type="text" name="message">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Content (optional): </label>
                        <textarea placeholder="Enter a content for gmail !" id="content-gmail" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="sendInviteInterview()" class="btn btn-primary">
                        Send Mail
                        <img id="loading" class="d-none" width="20" src="/images/loading.svg">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Report Career-->
    <div class="modal fade" id="modal-report-candidate" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('lang.Report Violations') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">{{ trans('lang.Content Report') }}</div>
                    <input hidden id="candidate-id" value="" />
                    <textarea id="report-content" placeholder="{{ trans('lang.Content') }}" class="form-control" cols="30"
                        rows="20"></textarea>
                    <label for="fileInput" class="form-label">Upload Image:</label>
                    <input class="form-control" type="file" id="fileInput" multiple>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ trans('lang.close') }}</button>
                    <button type="button" onclick="reportCandidate()" id="btn-send-report"
                        class="btn btn-primary">{{ trans('lang.report') }}</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Candidate Detail V2 START -->
    <div class="section-full p-b90 bg-white">
        <div class="twm-candi-self-wrap-2 overlay-wraper"
            style="background-image:url(/images/candidates/candidate-bg2.jpg);">
            <div class="overlay-main site-bg-primary opacity-01"></div>
            <div class="container">
                <div class="twm-candi-self-info-2">
                    <div class="twm-candi-self-top">
                        <div class="twm-candi-fee">{{ $candidate['price_per_hours'] }} / Hours</div>
                        <div class="twm-media">
                            <img src="
                                   {{ str_contains($candidate['avatar'], 'http')
                                       ? $candidate['avatar']
                                       : asset('/images/avatar/' . $candidate['avatar']) }}"
                                alt="#">
                        </div>
                        <div class="twm-mid-content">

                            <h4 class="twm-job-title">{{ $candidate['fullname'] }}</h4>

                            <p>Senior UI / UX Designer and Developer at Google INC</p>
                            <p class="twm-candidate-address"><i
                                    class="feather-map-pin"></i>{{ $candidate['province']->name ?? '' }}</p>

                        </div>
                    </div>
                    <div class="twm-ep-detail-tags">
                        <button onclick="showModalReportCandidate({{ $candidate['id'] }})"
                            class="de-info twm-bg-purple"><i
                                class="fa fa-exclamation-triangle"></i>{{ trans('lang.report') }}</button>
                    </div>
                    <div class="twm-candi-self-bottom">
                        <button onclick="showModalQuickChat()"
                            class="site-button">{{ trans('lang.Contact Us') }}</button>
                        <button onclick="showModalInviteInterview()"
                            class="site-button twm-bg-green">{{ trans('lang.Hire Me') }}</button>

                        <a onclick="downloadCV({{ $candidate['id'] }})" href="#"
                            class="site-button secondry">{{ trans('lang.download') }} CV</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">


            <div class="section-content">

                <div class="row d-flex justify-content-center">

                    <div class="col-lg-9 col-md-12">
                        <!-- Candidate detail START -->
                        <div class="cabdidate-de-info">

                            <div class="twm-s-info-wrap mb-5">
                                <h4 class="section-head-small mb-4">{{ trans('lang.Profile Info') }}</h4>
                                <div class="twm-s-info-4">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span class="twm-title">Offered Salary</span>
                                                <div class="twm-s-info-discription">{{ $candidate['price_per_hours'] }} /
                                                    Day</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-clock"></i>
                                                <span class="twm-title">Experience</span>
                                                <div class="twm-s-info-discription">6 Year</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-venus-mars"></i>
                                                <span class="twm-title">Gender</span>
                                                <div class="twm-s-info-discription">{{ $candidate['gender'] }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-mobile-alt"></i>
                                                <span class="twm-title">Phone</span>
                                                <div class="twm-s-info-discription">{{ $candidate['phone'] }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-at"></i>
                                                <span class="twm-title">Email</span>
                                                <div class="twm-s-info-discription">{{ $candidate['email'] }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-book-reader"></i>
                                                <span class="twm-title">Work Type</span>
                                                <div class="twm-s-info-discription">{{ $candidate['type_work'] }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="twm-s-info-inner">

                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="twm-title">Address</span>
                                                <div class="twm-s-info-discription">{{ $candidate['address'] }}</div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <h4 class="twm-s-title m-t0">{{ trans('lang.About Me') }}</h4>

                            @if (isset($candidate['introduce']))
                                {!! $candidate['introduce'] !!}
                            @else
                                <x-empty text="No introduce for this candidate" />
                            @endif

                            <h4 class="twm-s-title">{{ trans('lang.skill') }}</h4>

                            @if (count($candidate['skills']) > 0)
                                <div class="tw-sidebar-tags-wrap">
                                    <div class="tagcloud">
                                        @foreach ($candidate['skills'] as $skill)
                                            <a href="javascript:void(0)">{{ $skill->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <x-empty text="No skills for this candidate" />
                            @endif

                            <h4 class="twm-s-title">{{ trans('lang.Work Experience') }}</h4>
                            @if (count($candidate['experiences']) > 0)
                                <div class="twm-timing-list-wrap">

                                    @foreach ($candidate['experiences'] as $experience)
                                        <div class="twm-timing-list">
                                            <div class="twm-time-list-date">{{ $experience->from_date }} to
                                                {{ $experience->to_date }}</div>
                                            <div class="twm-time-list-title">{{ $experience->title }}</div>
                                            <div class="twm-time-list-position">{{ $experience->position }}</div>
                                            <div class="twm-time-list-discription">
                                                <p>{{ $experience->description }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <x-empty text="No experiences for this candidate" />
                            @endif

                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>
    <!-- Candidate Detail V2 END -->
@endsection
@push('js')
    <script>
        function showModalReportCandidate(candidateId) {
            $("#modal-report-candidate").modal('toggle')
            $("#btn-send-report").prop("disabled", false)
            $("#candidate-id").val(candidateId)
        }


        function sendMessage() {
            let message = $("#message");
            let user_id = $("#user_id");

            $.ajax({
                type: "POST",
                url: "{{ route('send.chat.to.user') }}",
                data: {
                    "message": message.val(),
                    "user_id": user_id.val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(res) {
                    toastr.success('Message sent successfully!', 'Notification !')
                    message.val('')
                    $("#modal-quickchat-candidate").modal('toggle')
                }
            })

        }


        function reportCandidate() {
            // Khởi tạo đối tượng FormData
            var formData = new FormData();

            // Thêm các file vào FormData
            let filesArr = $('#fileInput')[0].files;
            for (let i = 0; i < filesArr.length; i++) {
                formData.append('files[]', filesArr[i]);
            }

            // Thêm các dữ liệu khác vào FormData
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('candidate_id', $("#candidate-id").val());
            formData.append('report_content', $("#report-content").val());

            // Gửi yêu cầu AJAX
            $.ajax({
                type: 'POST',
                url: '{{ route('candidate.report') }}',
                data: formData,
                processData: false, // Không xử lý dữ liệu (để cho phép gửi file)
                contentType: false, // Không thay đổi content type (FormData sẽ tự động làm điều này)
                success: function(res) {
                    toastr.success('Reported Successfully !', 'Notification !');
                    $("#btn-send-report").prop('disabled', true);
                    $("#modal-report-candidate").modal('toggle');

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !');
                    $("#btn-send-report").prop('disabled', true);
                }
            });
        }


        function sendInviteInterview() {
            let title = $("#title").val();
            let content = $("#content-gmail").val();
            let position = $("#position").val();
            let time = $("#time").val();
            let location = $("#location").val();
            let email = $("#email").val();
            let phone = $("#phone").val();
            $.ajax({
                type: "POST",
                url: "{{ route('company.send.invite.interview') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "candidate_id": "{{ $candidate['id'] }}",
                    "title": title,
                    position,
                    time,
                    content,
                    location,
                    email,
                    phone
                    // "content": content.text()
                },
                beforeSend: function() {
                    $("#loading").toggleClass('d-none');
                },
                success: function(res) {
                    toastr.success(res.msg, 'Notification !')
                    $("#loading").toggleClass('d-none');

                    setTimeout(() => {
                        window.location.reload()
                    }, 1200)
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Error !')
                    $("#loading").toggleClass('d-none');

                }
            })
        }

        function showModalQuickChat() {
            $("#modal-quickchat-candidate").modal('toggle')
        }

        function showModalInviteInterview() {
            $("#modal-invite-interview").modal('toggle')
        }


        $("#btnNoCV").click(function() {
            alert('{{ trans('lang.CV Not Found') }}')
        })

        function downloadCV(candidate_id) {
            $.ajax({
                type: "GET",
                url: "/candidates/download-cv/" + candidate_id,
                success: function(res) {
                    window.location.href = res.file_url

                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message)
                }
            })
        }
    </script>
@endpush
