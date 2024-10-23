@extends('layouts.app')

@section('content')
    <!-- Modal QuickChat Candidate-->
    <div class="modal fade" id="modal-quickchat-candidate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave your message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input placeholder="Enter a message !" id="message" class="form-control" type="text" name="message">
                    <input  type="text" name="user_id" id="user_id" hidden value="{{$candidate['id']}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="sendMessage()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Candidate Detail V2 START -->
    <div class="section-full p-b90 bg-white">
        <div class="twm-candi-self-wrap-2 overlay-wraper" style="background-image:url(/images/candidates/candidate-bg2.jpg);">
            <div class="overlay-main site-bg-primary opacity-01"></div>
            <div class="container">
                <div class="twm-candi-self-info-2">
                    <div class="twm-candi-self-top">
                        <div class="twm-candi-fee">{{$candidate['price_per_hours']}} / Hours</div>
                        <div class="twm-media">
                            <img
                                src="
                                   {{
                                    str_contains($candidate['avatar'], 'http')
                                    ? $candidate['avatar']
                                    : asset('/images/avatar/'.$candidate['avatar'])
                                    }}"
                                alt="#">
                        </div>
                        <div class="twm-mid-content">

                            <h4 class="twm-job-title">Wanda Montgomery </h4>

                            <p>Senior UI / UX Designer and Developer at Google INC</p>
                            <p class="twm-candidate-address"><i class="feather-map-pin"></i>United States</p>

                        </div>
                    </div>
                    <div class="twm-ep-detail-tags">
                        <button class="de-info twm-bg-green"><i class="fa fa-share-alt"></i> Share</button>
                        <button class="de-info twm-bg-brown"><i class="fa fa-file-signature"></i> Shortlist</button>
                        <button class="de-info twm-bg-purple"><i class="fa fa-exclamation-triangle"></i> Report</button>
                        <button class="de-info twm-bg-sky"><i class="fa fa-save"></i> Save</button>
                    </div>
                    <div class="twm-candi-self-bottom">
                        <button onclick="showModalQuickChat()" class="site-button">Contact Us</button>
                        <a href="contact.html" class="site-button twm-bg-green">Hire Me</a>
                        <a href="files/pdf-sample.pdf" class="site-button secondry">Download CV</a>
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
                                <h4 class="section-head-small mb-4">Profile Info</h4>
                                <div class="twm-s-info-4">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span class="twm-title">Offered Salary</span>
                                                <div class="twm-s-info-discription">{{$candidate['price_per_hours']}} / Day</div>
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
                                                <div class="twm-s-info-discription">{{$candidate['gender']}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-mobile-alt"></i>
                                                <span class="twm-title">Phone</span>
                                                <div class="twm-s-info-discription">{{$candidate['phone']}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-at"></i>
                                                <span class="twm-title">Email</span>
                                                <div class="twm-s-info-discription">{{$candidate['email']}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-book-reader"></i>
                                                <span class="twm-title">Work Type</span>
                                                <div class="twm-s-info-discription">{{$candidate['type_work']}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="twm-s-info-inner">

                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="twm-title">Address</span>
                                                <div class="twm-s-info-discription">{{$candidate['address']}}</div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <h4 class="twm-s-title m-t0">About Me</h4>

                            @if(isset($candidate['introduce']))
                                {!! $candidate['introduce'] !!}
                            @else
                                <x-empty text="No introduce for this candidate" />
                            @endif

                            <h4 class="twm-s-title">Skills</h4>

                            @if(count($candidate['skills']) > 0)
                                <div class="tw-sidebar-tags-wrap">
                                    <div class="tagcloud">
                                        @foreach($candidate['skills'] as $skill)
                                            <a href="javascript:void(0)">{{$skill->name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <x-empty text="No skills for this candidate" />
                            @endif

                            <h4 class="twm-s-title">Work Experience</h4>
                            @if(count($candidate['experiences']) > 0)
                                <div class="twm-timing-list-wrap">

                                    @foreach($candidate['experiences'] as $experience)
                                        <div class="twm-timing-list">
                                            <div class="twm-time-list-date">{{$experience->from_date}} to {{$experience->to_date}}</div>
                                            <div class="twm-time-list-title">{{$experience->title}}</div>
                                            <div class="twm-time-list-position">{{$experience->position}}</div>
                                            <div class="twm-time-list-discription">
                                                <p>{{$experience->description}}</p>
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
        function sendMessage() {
            let message = $("#message");
            let user_id = $("#user_id");

            $.ajax({
                type: "POST",
                url: "{{route('send.chat.to.user')}}",
                data: {
                    "message": message.val(),
                    "user_id": user_id.val(),
                    "_token": "{{csrf_token()}}"
                },
                success: function (res) {
                    toastr.success('Message sent successfully!', 'Notification !')
                    message.val('')
                    $("#modal-quickchat-candidate").modal('toggle')
                }
            })

        }

        function showModalQuickChat() {
            $("#modal-quickchat-candidate").modal('toggle')
        }
    </script>
@endpush
