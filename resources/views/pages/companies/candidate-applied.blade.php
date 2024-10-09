@php use App\Enums\StatusCV; @endphp
@extends('layouts.company')

@section('content')
    <!-- Modal Report Career-->
    <div class="modal fade" id="modal-report-candidate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Báo cáo vi phạm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">Nếu bạn cho rằng đây là ứng viên giả mạo/span vi phạm tiêu chuẩn vui lòng báo cáo về cho chúng tôi !</div>
                    <input hidden id="candidate-id" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="reportCandidate()" id="btn-send-report" class="btn btn-primary">Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Candidate Applied -->
    <div class="modal fade" id="modal-candidate-applied" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header " style="align-items: baseline">
                    <h5 class="modal-title"  id="exampleModalLabel">Info Candidate |</h5>
                    <p style="margin-left: 4px"><span style="color: green; font-weight: 600">0</span> báo cáo vi phạm</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                                <img id="avatar" src="http://127.0.0.1:8001/images/avatar/company/1727932345.jpg" alt="">
                        </div>
                        <div class="col-6">
                                <label class="form-label" for="email">Full Name</label>
                                <input readonly class="form-control" type="text" id="fullname" value="Nguyern Van A">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="email">Email</label>
                            <input readonly class="form-control" type="text" id="email" value="Nguyern Van A">
                        </div>
                        <div class="col">
                            <label class="form-label" for="phone">Phone</label>
                            <input readonly class="form-control" type="text" id="phone" value="Nguyern Van A">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="birthday">Birthday</label>
                            <input readonly class="form-control" type="date" id="birthday">
                        </div>
                        <div class="col">
                            <label class="form-label" for="price_per_hours">Price Per Hours</label>
                            <input readonly class="form-control" type="text" id="price_per_hours" value="Nguyern Van A">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="price_per_hours">Introduce</label>
                            <textarea id="introduce" readonly class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Book Appointment -->
    <div class="modal fade" id="modal-book-appointment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Make an appointment with the candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Giao diện đặt lịch hẹn -->
                    <div class="container mt-5">
                        <form id="appointment-form">
                            <div class="form-group">
                                <div class="alert alert-info" id="text-fullname"></div>
                                <input hidden type="text" id="user_id" name="user_id" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="appointment-date">Ngày</label>
                                <input type="date" class="form-control" id="appointment-date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="appointment-time">Thời gian</label>
                                <input type="time" class="form-control" id="appointment-time" name="time" required>
                            </div>
                            <div class="form-group">
                                <label for="note">Ghi chú</label>
                                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                            </div>
                            <input hidden type="text" id="career-id" name="career_id" value="">
                            <button type="submit" class="btn btn-primary">Đặt lịch hẹn</button>
                        </form>
                        <div id="success-message" class="alert alert-success mt-3" style="display: none;">
                            Lịch hẹn đã được tạo thành công!
                        </div>
                        <!-- Thông báo lỗi nếu lịch hẹn đã tồn tại -->
                        <div id="error-message" class="alert alert-danger mt-3" style="display: none;">
                            <!-- Thông báo lỗi sẽ được hiển thị ở đây -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>Candidates</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a href="#">Dasboard</a><span>Candidates</span></div>
            </div>

            <div class="twm-pro-view-chart-wrap">

                <div class="col-lg-12 col-md-12 mb-4">
                    <div class="panel panel-default site-bg-white m-t30">
                        <div class="panel-heading wt-panel-heading p-a20">
                            <h4 class="panel-tittle m-a0"><i class="far fa-list-alt"></i>All Candidates</h4>
                        </div>
                        <div class="panel-body wt-panel-body">
                            <div class="twm-D_table p-a20 table-responsive">
                                <!-- Filter Dropdown Section -->
                                <div class="filter-section mb-3">
                                    <label for="statusFilter">Filter by Status:</label>
                                    <select id="statusFilter" class="form-select" style="width: 200px; display: inline-block; margin-left: 10px;">
                                        <option value="">All</option>
                                        @foreach($statusCV as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <table id="candidate_data_table" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="checkAll(this)"></th>
                                        <th>Name</th>
                                        <th>Applied for</th>
                                        <th>CV</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="test-candidate-table">
                                    <!--1-->
                                    @foreach($career['candidates'] as $candidate)
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td>
                                                <div class="twm-DT-candidates-list">
                                                    <div class="twm-media">
                                                        <div class="twm-media-pic">
                                                            <img
                                                                src="{{asset('/images/avatar/'. $candidate['info']->avatar)}}"
                                                                alt="#">
                                                        </div>
                                                    </div>
                                                    <div class="twm-mid-content">
                                                        <a href="#" class="twm-job-title">
                                                            <h4>{{$candidate['info']->fullname}}</h4>
                                                            <p class="twm-candidate-address">
                                                                <i class="feather-map-pin"></i>{{$candidate['info']->email}}
                                                            </p>
                                                        </a>

                                                    </div>

                                                </div>
                                            </td>
                                            <td>{{$career['title']}}</td>
                                            <td>
                                                <a style="color: blue" download href="{{asset('/storage/uploads/'. $candidate['cv'])}}">{{$candidate['cv']}}</a>
                                            </td>
                                            <td>{{$candidate['applied_day']}}</td>
                                            <td>
                                                <div class="twm-jobs-category">
                                                    <select onchange="updateUserCareer({{$candidate['user_career_id']}}, this)" name="status" class="form-select" id="status">
                                                        @foreach($statusCV as $key => $value)
                                                            <option {{$key == StatusCV::getKeyFromDesc($candidate['status']) ? 'selected' : ''}} value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="twm-table-controls">
                                                    <ul class="twm-DT-controls-icon list-unstyled">
                                                        <li>
                                                            <button onclick="showModalCandidateApplied({{$candidate['info']}})" title="View profile" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top">
                                                                <span class="fa fa-eye"></span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button title="Send message" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top">
                                                                <span class="far fa-envelope-open"></span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button onclick="showModalReportCandidate({{$candidate['info']->id}})" title="Report" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top">
                                                                <span class="far fa-trash-alt"></span>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button onclick="showModalBookAppointment({{$career['id']}}, {{$candidate['info']}})">
                                                                <i class="fas fa-calendar-day"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Applied for</th>
                                        <th>CV</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>
@endsection

@push('js')
    <script>
        function updateUserCareer(id, ele) {
            $.ajax({
                type: 'POST',
                url: '{{route('job.update.user.career')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': id,
                    'status': ele.value
                },
                success: function (res) {
                    toastr.success(res.msg, 'Notification !')
                },
                error: function(xhr) {
                    console.log(xhr)
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }

        function showModalReportCandidate(candidateId) {
            $("#modal-report-candidate").modal('toggle')
            $("#btn-send-report").prop("disabled", false)
            $("#candidate-id").val(candidateId)
        }

        function showModalCandidateApplied(data) {
            $("#avatar").attr("src", '{{asset('/images/avatar/:avatar')}}'.replace(':avatar', data.avatar))
            $("#fullname").val(data.fullname)
            $("#phone").val(data.phone)
            $("#birthday").val(data.birthday)
            $("#price_per_hours").val(data.price_per_hours)
            $("#introduce").text(data.introduce)
            $("#modal-candidate-applied").modal('toggle')
        }

        function reportCandidate() {
            $.ajax({
                type: 'POST',
                url: '{{route('candidate.report')}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'candidate_id': $("#candidate-id").val()
                },
                success: function (res) {
                    toastr.success('Reported Successfully !', 'Notification !')
                    $("#btn-send-report").prop('disabled', true)

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                    $("#btn-send-report").prop('disabled', true)
                }

            })
        }

        $('#appointment-form').submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: '/appointments',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào header
                },
                data: $(this).serialize(),
                success: function(response) {
                    $('#success-message').show().text(response.success);
                    $('#error-message').hide(); // Ẩn thông báo lỗi nếu có
                    $('#appointment-form')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 409) {
                        $('#error-message').show().text(xhr.responseJSON.error);
                        $('#success-message').hide(); // Ẩn thông báo thành công nếu có
                    } else {
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại!');
                    }
                }
            });
        });


        function showModalBookAppointment(careerId, infoCandidate) {
            $("#modal-book-appointment").modal('toggle')
            console.log(infoCandidate)
            $("#career-id").val(careerId)
            $("#user_id").val(infoCandidate.id)
            $("#text-fullname").text('Ứng viên: ' + infoCandidate.fullname)
        }
    </script>
@endpush
