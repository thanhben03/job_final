@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <style>
        .list-group-item {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
        }

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
@endpush

@section('content')
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url(images/banner/1.jpg);">
            <div class="overlay-main site-bg-white opacity-01"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <div class="banner-title-outer">
                        <div class="banner-title-name">
                            <h2 class="wt-title">{{ trans('lang.Appointment Manager') }}</h2>
                        </div>
                    </div>
                    <!-- BREADCRUMB ROW -->

                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="index.html">{{ trans('lang.header.home') }}</a></li>
                            <li>{{ trans('lang.Appointment Manager') }}</li>
                        </ul>
                    </div>

                    <!-- BREADCRUMB ROW END -->
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->


        <!-- OUR BLOG START -->
        <div class="section-full p-t120  p-b90 site-bg-white">


            <div class="container">
                <div class="row">

                    <!-- Right Sidebar -->
                    <x-right-sidebar />

                    <div class="col-xl-9 col-lg-8 col-md-12 m-b30">
                        <div class="twm-right-section-panel candidate-save-job site-bg-gray">
                            <div class="product-filter-wrap d-flex justify-content-between align-items-center">
                                <span class="woocommerce-result-count-left">{{ trans('lang.Appointment Manager') }}</span>

                            </div>
                            <div class="container mt-1">
                                <ul class="list-group" id="appointment-list">
                                    <!-- Các dòng cuộc hẹn sẽ được hiển thị ở đây -->
                                </ul>
                            </div>

                            <!-- Modal để hiển thị thông tin chi tiết của cuộc hẹn -->
                            <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="appointmentModalLabel">{{ trans('lang.Appointment Details') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>{{ trans('lang.company') }}:</strong> <span id="modal-company-name"></span></p>
                                            <p><strong>{{ trans('lang.date') }}:</strong> <span id="modal-date"></span></p>
                                            <p><strong>{{ trans('lang.time') }}:</strong> <span id="modal-time"></span></p>
                                            <p><strong>{{ trans('lang.note') }}:</strong> <span id="modal-note"></span></p>
                                            <p><strong>{{ trans('lang.status') }}:</strong> <span id="modal-status"></span></p>
                                            <div id="modal-actions" class="text-end mt-3">
                                                <button class="btn btn-success me-2" id="accept-appointment-btn">Đồng ý</button>
                                                <button class="btn btn-danger" id="reject-appointment-btn">Từ chối</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- OUR BLOG END -->



    </div>
    <!-- CONTENT END -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const candidateId = 1; // Thay bằng ID thực tế của ứng viên

            // Lấy danh sách cuộc hẹn của ứng viên
            $.get(`/appointments/${candidateId}`, function(data) {
                let appointmentList = '';
                data.forEach(appointment => {
                    let statusClass = appointment.status === 'pending' ? 'text-warning' :
                        appointment.status === 'accepted' ? 'text-success' :
                            'text-danger';

                    appointmentList += `
                <li class="list-group-item d-flex justify-content-between align-items-center appointment-item" data-id="${appointment.id}" data-company="${appointment.company.company_name}" data-date="${appointment.date}" data-time="${appointment.time}" data-note="${appointment.note}" data-status="${appointment.status}">
                    <div>
                        <span class="fw-bold">${appointment.career.title} | ${appointment.company.company_name} | ${appointment.created_at}</span>
                        <span class="badge ${statusClass} ms-2">${appointment.status}</span>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </li>
            `;
                });
                $('#appointment-list').html(appointmentList);
            });

            // Xử lý khi người dùng nhấp vào dòng cuộc hẹn
            $(document).on('click', '.appointment-item', function() {
                const appointmentId = $(this).data('id');
                const companyName = $(this).data('company');
                const date = $(this).data('date');
                const time = $(this).data('time');
                const note = $(this).data('note');
                const status = $(this).data('status');

                $('#modal-company-name').text(companyName);
                $('#modal-date').text(date);
                $('#modal-time').text(time);
                $('#modal-note').text(note);
                $('#modal-status').text(status);
                $('#accept-appointment-btn').data('id', appointmentId);
                $('#reject-appointment-btn').data('id', appointmentId);

                if (status === 'pending') {
                    $('#modal-actions').show();
                } else {
                    $('#modal-actions').hide();
                }

                $('#appointmentModal').modal('show');
            });

            // Xử lý sự kiện đồng ý cuộc hẹn
            $('#accept-appointment-btn').on('click', function() {
                const appointmentId = $(this).data('id');
                $.post(`/appointments/${appointmentId}/accept`, function(response) {
                    toastr.success(response.success, 'Notification !')
                    setTimeout(function () {
                        location.reload();
                    }, 1200)
                });
            });

            // Xử lý sự kiện từ chối cuộc hẹn
            $('#reject-appointment-btn').on('click', function() {
                const appointmentId = $(this).data('id');
                $.post(`/appointments/${appointmentId}/reject`, function(response) {
                    toastr.success(response.success, 'Notification !')
                    setTimeout(function () {
                        location.reload();
                    }, 1200)
                });
            });
        });


    </script>

@endpush
