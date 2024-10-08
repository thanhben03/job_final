@php use Illuminate\Support\Facades\Session; $company = Session::get('company'); @endphp
@extends('layouts.company')

@section('content')
    <!-- Modal Match JOB -->
    <div class="modal fade" id="modal-math-candidate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ứng viên phù hợp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Chúng tôi gợi ý cho bạn một số ứng viên phù hợp với công việc của bạn</p>
                    <ul class="list-group" id="suggest-candidate">

                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content Holder -->
    <div id="content">

        <div class="content-admin-main">

            <div class="wt-admin-right-page-header clearfix">
                <h2>Manage Jobs</h2>
                <div class="breadcrumbs"><a href="#">Home</a><a href="#">Dasboard</a><span>My Job Listing</span></div>
            </div>

            <!--Basic Information-->
            <div class="panel panel-default">
                <div class="panel-heading wt-panel-heading p-a20">
                    <h4 class="panel-tittle m-a0"><i class="fa fa-suitcase"></i> Job Details</h4>
                </div>
                <div class="panel-body wt-panel-body p-a20 m-b30 ">
                    <div class="twm-D_table p-a20 table-responsive">
                        <table id="jobs_bookmark_table" class="table table-bordered twm-bookmark-list-wrap">
                            <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Job Types</th>
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
                                                        str_contains($company->company_avatar, 'http')
                                                        ? $company->company_avatar
                                                        : asset('/images/avatar/'.$company->company_avatar)
                                                        }}"
                                                        alt="#">
                                                </div>
                                            </div>
                                            <div class="twm-mid-content">
                                                <a href="#" class="twm-job-title">
                                                    <a href="{{route('company.show.detail-job', $career['slug'])}}">
                                                        <h4>{{$career['title']}}</h4>
                                                    </a>
                                                    <p class="twm-bookmark-address">
                                                        <i class="feather-map-pin"></i>{{$career['address']}}
                                                    </p>
                                                </a>

                                            </div>

                                        </div>
                                    </td>
                                    <td>{{$career['level']}}</td>
                                    <td>
                                        <div class="twm-jobs-category"><span class="twm-bg-green">Part Time</span></div>
                                    </td>
                                    <td><a href="{{route('company.show.detail-job', $career['id'])}}"
                                           class="site-text-primary">{{$career['cv_applied'] == null ? 0 : count($career['cv_applied'])}}
                                            Applied</a></td>
                                    <td>
                                        <div>{{$career['created_at']}} &</div>
                                        <div>{{$career['expiration_day']}}</div>
                                    </td>

                                    <td>
                                        <div class="twm-table-controls">
                                            <ul class="twm-DT-controls-icon list-unstyled">
                                                <li>
                                                    <button onclick="matchWithCandidate({{$career['id']}})" title="View profile" data-bs-toggle="tooltip"
                                                            data-bs-placement="top">
                                                        <span class="fa fa-eye"></span>
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="{{route('company.show.detail-job', $career['slug'])}}">
                                                        <button title="Edit" data-bs-toggle="tooltip"
                                                                data-bs-placement="top">
                                                            <span class="far fa-edit"></span>
                                                        </button>
                                                    </a>
                                                </li>
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
        function matchWithCandidate(jobId) {
            $.ajax({
                type: 'GET',
                url: '{{ route('match.with.candidate', ':jobID') }}'.replace(':jobID', jobId),
                success: function (res) {
                    let result = Object.values(res.candidates)
                    let html = ''
                    result.forEach(ele => {
                        let stringMatch = Object.values(ele.matches).map(ele => `<p class="mb-0">${ele}</p>`)
                        html += `
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">${ele.candidate.fullname}</h5>
                                    <p class="mb-0"><strong>Gender:</strong> ${ele.candidate.gender}</p>
                                    <p class="mb-0"><strong>Price Per Hours:</strong> ${ele.candidate.price_per_hours}</p>

                                </div>
                                <div>
                                    <a href="" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
{{--                            <p class="mb-1 mt-2"><strong>Description:</strong> {{ Str::limit(${ele.candidate.detail.desc}, 100) }}</p>--}}
                            <div>
                                <small class="text-muted">Join Day: ${ele.candidate.created_at}</small>
                                <small class="">Email: <strong style="color: green">${ele.candidate.email}</strong></small>
                            </div>
                            <div class="wrap-match">
                                ${stringMatch.toString().replace(',','')}
                            </div>
                        </li>
                        `
                    })

                    $("#suggest-candidate").html(html)
                    $("#modal-math-candidate").modal('toggle')

                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.msg, 'Notification !')
                }
            })
        }

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

    </script>
@endpush
