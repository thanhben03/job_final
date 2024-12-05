@php use Illuminate\Support\Facades\Session; $company = Session::get('company'); @endphp
@extends('layouts.company')

@section('content')
    <!-- Modal View Reason -->
    <div class="modal" id="modal-view-reason" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reason Decline Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="reason"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Match JOB -->
    <div class="modal fade" id="modal-math-candidate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Suitable Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ trans('lang.We suggest you some candidates suitable for your job') }}</p>
                    <ul class="list-group" id="suggest-candidate">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('lang.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <x-modal.modal-progress />

    <!-- Modal Show Appointment -->
    <div class="modal fade" id="modal-show-appointment" tabindex="-1" aria-labelledby="appointmentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentsModalLabel">{{ trans('lang.Appointment List') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="appointment-list" class="list-group">
                        <!-- Danh sách cuộc hẹn sẽ được chèn vào đây -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('lang.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Appointment-->
    <div class="modal fade" id="modal-edit-appoinment" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAppointmentModalLabel">{{ trans('lang.Changing Appointment Date and Time') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-appointment-form">
                        <div class="mb-3">
                            <label for="appointment-date" class="form-label">{{ trans('lang.Select New Date') }}</label>
                            <input type="date" class="form-control" id="appointment-date" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointment-time" class="form-label">{{ trans('lang.Select New Time') }}</label>
                            <input type="time" class="form-control" id="appointment-time" required>
                        </div>
                        <div class="mb-3">
                            <label for="appointment-time" class="form-label">{{ trans('lang.Reason') }}</label>
                            <textarea class="form-control" id="appointment-reason" ></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('lang.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cancle Appointment-->
    <div class="modal fade" id="modal-cancel-appoinment" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAppointmentModalLabel">{{ trans('lang.Cancle Appointment') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" hidden id="appointment-id-cancel">
                    <div class="mb-3">
                        <label for="appointment-time" class="form-label">{{ trans('lang.Reason') }}</label>
                        <textarea style="height: 125px" class="form-control" id="cancel-reason" ></textarea>
                    </div>
                    <button onclick="cancelAppointment()" type="button" class="btn btn-primary">{{ trans('lang.save') }}</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>{{ trans('lang.Manage Jobs') }}</h2>
                <div class="breadcrumbs"><a href="#">{{ trans('lang.header.home') }}</a><a href="#">{{ trans('lang.user.dashboard') }}</a><span>{{ trans('lang.Manage Jobs') }}</span></div>
            </div>

            <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0"><i class="fa fa-suitcase"></i> {{ trans('lang.Manage Jobs') }}</h4>
                </div>
                <div class="panel-body wt-panel-body p-a20 m-b30 ">
                    <div class="twm-D_table p-a20 table-responsive">
                        <table id="jobs_bookmark_table" class="table table-bordered twm-bookmark-list-wrap">
                            <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Job Types</th>
                                <th>Publish</th>
                                <th>Applications</th>
                                <th>Created & Expired</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!--1-->
                            @foreach($careers as $career)
                                <tr>
                                    <td>
                                        <div class="twm-bookmark-list">
                                            <div class="twm-media">
                                                <div class="twm-media-pic">
                                                    <img
                                                        src="
                                                        {{
                                                        str_contains(auth()->guard('company')->user()->company_avatar, 'http')
                                                        ? auth()->guard('company')->user()->company_avatar
                                                        : asset('/images/avatar/'.auth()->guard('company')->user()->company_avatar)
                                                        }}"
                                                        alt="#">
                                                </div>
                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="#" class="twm-job-title">
                                                    <a href="{{route('company.show.detail-job', $career['id'])}}">
                                                        <h4>{{$career['title']}}</h4>
                                                    </a>
                                                    <p class="twm-bookmark-address">
                                                        <i class="feather-map-pin"></i>{{$career['address']}}
                                                    </p>
                                                </a>

                                            </div>

                                        </div>
                                    </td>
                                    <td>{{$career['category']->name}}</td>
                                    <td>
                                        <div class="twm-jobs-category"><span class="twm-bg-green">Part Time</span></div>
                                    </td>
                                    <td>
                                        <div class="twm-jobs-category">
                                            @switch($career['published'])
                                                @case(0)
                                                    <span class="twm-bg-golden">
                                                        {{trans('lang.pending')}}
                                                    </span>
                                                @break
                                                @case(1)
                                                    <span class="twm-bg-green">
                                                        {{trans('lang.active')}}
                                                    </span>
                                                @break
                                                @case(2)
                                                    <span class="twm-bg-red">
                                                        {{trans('lang.Decline')}}
                                                    </span>
                                                    <p onclick="viewReason({{$career['id']}})" style="text-decoration: underline; font-size: 13px">>>Xem lí do<<</p>
                                                    @break
                                            @endswitch

                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{route('company.show.detail-job', $career['id'])}}"
                                           class="site-text-primary">{{$career['cv_applied'] == null ? 0 : count($career['cv_applied'])}}
                                            Applied |
                                        </a>
                                        <a onclick="showModalListAppoints({{json_encode($career['appointments'], 1)}})" class="site-text-primary" href="#">
                                            {{$career['appointments'] == null ? 0 : count($career['appointments'])}}
                                            Appointment
                                        </a>
                                    </td>
                                    <td>
                                        <div>{{$career['created_at']}} &</div>
                                        <div>{{$career['expiration_day']}}</div>
                                    </td>

                                    <td>
                                        <div class="twm-table-controls">
                                            <ul class="twm-DT-controls-icon list-unstyled">
                                                @if($career['published'] != 2)
                                                    <li>
                                                        <button onclick="matchWithCandidate({{$career['id']}}, 'match_cv')" title="View profile" data-bs-toggle="tooltip"
                                                                data-bs-placement="top">
                                                            <span class="fa fa-eye"></span>
                                                        </button>
                                                    </li>
                                                @endif
                                                @if($career['published'] != 2)
                                                    <li>
                                                        <a href="{{route('company.show.edit-job', $career['id'])}}">
                                                            <button title="Edit" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top">
                                                                <span class="far fa-edit"></span>
                                                            </button>
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <button onclick="deleteJob({{$career['id']}})" title="Delete" data-bs-toggle="tooltip"
                                                            data-bs-placement="top">
                                                        <span class="far fa-trash-alt"></span>
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
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Job Types</th>
                                <th>Applications</th>
                                <th>Created & Expired</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('js')
    <script>
        function matchWithCandidate(jobId, type) {
            $("#modal-progress").modal('toggle')
            let $bar = $(".bar");
            var progress = setInterval(function() {

                // perform processing logic (ajax) here
                $bar.width($bar.width()+100);

                $bar.text($bar.width()/5 + "%");
            }, 700);
            $.ajax({
                type: 'POST',
                url: '{{ route('match.with.candidate') }}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'career_id': jobId,
                    'type': type
                },
                success: function (res) {
                    let result = Object.values(res.candidates)
                    let html = ''
                    result.forEach(ele => {
                        let stringMatch = Object.values(ele.matches).map(ele => `<p class="mb-0">${ele}</p>`)
                        html += `
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1"><a href="/candidates/detail/${ele.candidate.id}">${ele.candidate.fullname}</a></h5>
                                    <p class="mb-0"><strong>{{trans('lang.gender')}}:</strong> ${ele.candidate.gender}</p>
                                    <p class="mb-0"><strong>{{trans('lang.Price Per Hours')}}:</strong> ${ele.candidate.price_per_hours}</p>

                                </div>
                                <div>
                                    <a href="/candidates/detail/${ele.candidate.id}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted">{{trans('lang.Join Day')}}: ${ele.candidate.created_at}</small>
                                <small class="">Email: <strong style="color: green">${ele.candidate.email}</strong></small>
                            </div>
                            <div class="wrap-match">
                                ${stringMatch.toString().replace(',','')}
                            </div>
                        </li>
                        `
                    })

                    // reset progree bar
                    clearInterval(progress);
                    $('.progress').removeClass('active');
                    $bar.width(500);
                    $bar.text('100%');
                    $(".progress-bar").css('background-color', '#00b314')

                    // setTimeout(function () {
                    //     // update modal
                    //     $(".modal-dialog").addClass('modal-dialog-scrollable')
                    //     $('#modal-progress .modal-body').html(html);
                    //     $("#modal-progress-title").text('Ứng viên phù hợp')
                    //     $('#modal-progress .hide,#modal-progress .in').toggleClass('hide in');
                    // }, 1000)

                    setTimeout(function () {
                        $("#modal-progress").modal('toggle')
                        $("#suggest-candidate").html(html)
                        $("#modal-math-candidate").modal('toggle')
                    }, 1000)

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }

        $('#modal-progress').on('hidden.bs.modal', function () {
            // reset modal
            let html = `<div class="progress">
                    <div class="progress-bar bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">

                    </div>
                </div>`;
            $('#modal-progress .modal-body').html(html);
        });

        function deleteJob(jobId) {
            if (!confirm('Are you sure ?')) {
                return;
            }
            $.ajax({
                type: "DELETE",
                url: "{{route('jobs.destroy', ':jobID')}}".replace(':jobID', jobId),
                data: {
                  "_token": "{{csrf_token()}}"
                },
                success: function (res) {
                    toastr.success(res.msg, 'Notification !')
                    window.location.reload()
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }

        function showModalBookAppointment(careerId) {
            $("#modal-book-appointment").modal('toggle')
            $("#career-id").val(careerId)
        }

        function showModalListAppoints(appointments) {
            $("#modal-show-appointment").modal('toggle')
            let appointmentList = '';
            appointments.forEach(appointment => {
                let statusClass = appointment.status === 'pending' ? 'text-warning' :
                    appointment.status === 'accepted' ? 'text-success' :
                        'text-danger';

                appointmentList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6>${appointment.candidate.fullname}</h6>
                            <p class="mb-1">Ngày: ${appointment.date} | Giờ: ${appointment.time}</p>
                            <small class="${statusClass}">Trạng thái: ${appointment.status}</small><br>
                            <small class="">Ghi chú: ${appointment.note}</small>
                        </div>
                        ${(appointment.status !== 'rejected' && appointment.status !== 'cancel') ? `
                        <div class="d-flex flex-column flex-md-row gap-2 mt-2 mt-md-0">
                            <button class="btn btn-outline-secondary btn-sm" onclick="openEditModal(${appointment.id}, '${appointment.date}', '${appointment.time}')">Chỉnh Sửa</button>
                            <button class="btn btn-outline-primary btn-sm" onclick="openCancelAppointment(${appointment.id})">Hủy lịch</button>
                        </div>
                    ` : ''}
                    </li>
                `;
            });
            $('#appointment-list').html(appointmentList);
        }

        function openEditModal(appointmentId, currentDate, currentTime) {
            $('#appointment-date').val(currentDate);
            $('#appointment-time').val(currentTime);
            $('#modal-edit-appoinment').modal('show');

            // Lưu lại ID của cuộc hẹn hiện tại vào form
            $('#edit-appointment-form').data('appointment-id', appointmentId);
        }

        function openCancelAppointment(appointmentId) {
            $('#modal-cancel-appoinment').modal('show');

            // Lưu lại ID của cuộc hẹn hiện tại vào form
            $('#appointment-id-cancel').val(appointmentId)
        }

        function cancelAppointment() {
            let cancelReason = $("#cancel-reason").val();
            let id = $("#appointment-id-cancel").val();

            if (cancelReason === '') {
                alert('{{trans('lang.You must enter a reason for canceling this appointment')}}')
                return;
            }

            $.ajax({
                type: "POST",
                url: "/appointments/cancel",
                data: {
                    id: id,
                    reason: cancelReason
                },
                success: function (res) {
                    alert('Success !')
                    $("#modal-cancel-appoinment").modal('toggle')
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.error)
                }
            })

        }

        $('#edit-appointment-form').on('submit', function(event) {
            event.preventDefault();

            const appointmentId = $(this).data('appointment-id');
            const newDate = $('#appointment-date').val();
            const newTime = $('#appointment-time').val();
            const reason = $("#appointment-reason").val();

            $.ajax({
                url: `/appointments/${appointmentId}/update`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    date: newDate,
                    time: newTime,
                    reason: reason
                },
                success: function(response) {
                    alert('Ngày và giờ cuộc hẹn đã được cập nhật thành công!');
                    $('#editAppointmentModal').modal('hide');
                    location.reload(); // Refresh lại danh sách cuộc hẹn
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.error);
                }
            });
        });

        function viewReason(career_id) {
            $.ajax({
                type: "get",
                url: "/job/get-reason-decline/" + career_id,
                success: function (res) {
                    $("#reason").text(res)
                    $("#modal-view-reason").modal('toggle')
                }
            })
        }



    </script>


@endpush
