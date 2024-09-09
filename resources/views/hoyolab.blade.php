@extends('layouts.app')

@section('content')
<div class="container">
    @if ($error)
        <div class="alert alert-danger">
            Status: {{ $error->status }} - You need to log in again.
        </div>
    @endif
    <div class="row">

        @foreach ($rewards as $reward)
            {{-- @foreach ($reward as $item) --}}
            <div class="col-xl-4">
                <div class="card card-custom gutter-b card-stretch">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Info-->
                        <!--end::Info-->
                        <!--begin::Description-->
                        <div class="mb-10 mt-5 font-weight-bold">{{ $reward->status }}</div>

                        @php
                            // Decode JSON reward dan info
                            $rewardData = json_decode($reward->reward, true);
                            $infoData = json_decode($reward->info, true);
                        @endphp

                        @if(is_array($rewardData))
                            <div class="d-flex align-items-center">
                                <!--begin::Pic-->
                                <div class="flex-shrink-0 mr-4 symbol symbol-60 symbol-circle">
                                    <img src="{{ $rewardData['award']['icon'] ?? '' }}" alt="{{ $rewardData['award']['name'] ?? '' }}" />
                                </div>
                                <!--end::Pic-->
                                <!--begin::Info-->
                                <div class="d-flex flex-column mr-auto">
                                    <!--begin: Title-->
                                    <div class="d-flex flex-column mr-auto">
                                        {{-- <a href="#" class="text-dark text-hover-primary font-size-h4 font-weight-bolder mb-1">{{ $game['nickname'] }}</a> --}}
                                        {{-- <span class="text-muted font-weight-bold">{{ $game['level'] }} - {{ $game['game_uid'] }}</span> --}}
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::Info-->
                            </div>

                            <div class="mb-10 mt-5 font-weight-bold">
                                <div class="reward-list">
                                    <h5 class="reward-name">{{ $rewardData['award']['name'] ?? 'N/A' }}</h5>
                                    <p class="reward-count">Jumlah diterima: {{ $rewardData['award']['cnt'] ?? 0 }}</p>

                                    @if(isset($infoData['total_sign_day']))
                                        <h5 class="total-sign">
                                            Total absen bulan ini: {{ $infoData['total_sign_day'] }}
                                        </h5>
                                    @endif
                                    <p>Last Updated: {{$reward->updated_at}}</p>
                                </div>
                            </div>
                        @else
                            <div>{{ $reward->reward }}</div>
                        @endif
                        <!--end::Description-->

                        <!--begin::Progress-->
                        <div class="d-flex mb-5 align-items-center">
                            <!-- Progress bisa ditambahkan di sini -->
                        </div>
                        <!--end::Progress-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end:: Card-->
            </div>
            {{-- @endforeach --}}
        @endforeach
    </div>
</div>
@endsection
