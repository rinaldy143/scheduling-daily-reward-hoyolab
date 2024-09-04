@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-4">
            <!--begin::Card-->
            <div class="card card-custom gutter-b card-stretch">
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                        <!--begin::Pic-->
                        <div class="flex-shrink-0 mr-4 symbol symbol-60 symbol-circle">
                            <img src="assets/media/project-logos/3.png" alt="image" />
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="d-flex flex-column mr-auto">
                            <!--begin: Title-->
                            <div class="d-flex flex-column mr-auto">
                                <a href="#" class="text-dark text-hover-primary font-size-h4 font-weight-bolder mb-1">Nexa - Next generation SAAS</a>
                                <span class="text-muted font-weight-bold">Creates Limitless possibilities</span>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Description-->
                    <div class="mb-10 mt-5 font-weight-bold">I distinguish three main text objectives.First, your objective could be merely to inform people.A second be to persuade people.</div>
                    <!--end::Description-->
                    <!--begin::Data-->
                    <div class="d-flex mb-5">
                        <div class="d-flex align-items-center mr-7">
                            <span class="font-weight-bold mr-4">Start</span>
                            <span class="btn btn-light-primary btn-sm font-weight-bold btn-upper btn-text">14 Jan, 17</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="font-weight-bold mr-4">Due</span>
                            <span class="btn btn-light-danger btn-sm font-weight-bold btn-upper btn-text">15 Oct, 18</span>
                        </div>
                    </div>
                    <!--end::Data-->
                    <!--begin::Progress-->
                    <div class="d-flex mb-5 align-items-cente">
                        <span class="d-block font-weight-bold mr-5">Progress</span>
                        <div class="d-flex flex-row-fluid align-items-center">
                            <div class="progress progress-xs mt-2 mb-2 w-100">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 59%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3 font-weight-bolder">59%</span>
                        </div>
                    </div>
                    <!--ebd::Progress-->
                </div>
                <!--end::Body-->
            </div>
            <!--end:: Card-->
        </div>
    </div>
</div>
@endsection
