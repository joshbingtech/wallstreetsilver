@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-wrapper mt-3 border-white">
        <div class="row">
            <div class="col-12 col-sm-12 col-xl-6">
                <div class="row">
                    <div class="col-12 col-sm-6 col-xl-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4> Published Articles </h4>
                                        <h4 class="text-white mt-3"> {{ $total_articles }} </h4>
                                        <h6 class="text-muted"> {{ $total_articles_current_month }} new articles this month </h6>
                                    </div>
                                    <div class="icon-box icon-box-bg-image-warning">
                                        <i class="ti-write gradient-card-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4> Comments </h4>
                                        <h4 class="text-white mt-3"> 229,559 </h4>
                                        <h6 class="text-muted"> 9,120 comments this month</h6>
                                    </div>
                                    <div class="icon-box icon-box-bg-image-danger">
                                        <i class="ti-comments gradient-card-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-xl-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div>
                                        <h4> Registered Users </h4>
                                    </div>
                                    <div id="users-chart-wrapper">
                                        <div id="users-chart"></div>
                                        <strong id="total-users"> {{ $total_user_records }} </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div>
                                        <h4> Visitors Today </h4>
                                    </div>
                                    <div id="visitors-chart-wrapper">
                                        <div id="visitors-chart"></div>
                                        <strong id="total-visitors"> 1,997 </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4> Hot Articles </h4>
                                <div class="featured-articles">
                                    @foreach ($featured_articles as $article)
                                        <div class="row article border-white">
                                            <div class="col-md-4">
                                                <div class="outer">
                                                    <div class="middle">
                                                        <div>
                                                            <img src="{{ asset('articles/'.$article['thumbnail']) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 article-summary">
                                                <h3 class="text-center"> {{ $article['title'] }} </h3>
                                                <div>
                                                    {{ character_limiter($article['description'], 200) }}
                                                    <a href="#"> Continue Reading </a>
                                                </div>
                                                <div class="article-publish-date">
                                                    {{ convertDateTimeTo($article['created_at']) }}
                                                </div>
                                                <div class="article-view">
                                                    <img src="{{ asset('images/icons/view-count.png') }}"> {{ $article['views'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('plugins/highcharts.js') }}"></script>
    <script type="text/javascript">
        var visitors_data = [
            { name: 568, y: 568, device: "Desktop", color: "#33BF8C"},
            { name: 1306, y: 1306, device: "Mobile Phone", color: "#F2B604"},
            { name: 123, y: 123, device: "Tablet", color: "#F95360"},
        ];

        var users_data = [
            { name: "Admin", y: {{ $total_admins }}, color: "#33BF8C"},
            { name: "Journalist", y: {{ $total_journalists }}, color: "#F2B604"},
            { name: "User", y: {{ $total_users }}, color: "#F95360"},
        ];

        $("#visitors-chart").highcharts({
            chart: {
                backgroundColor:'rgba(255, 255, 255, 0.0)',
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: '',
                style: {
                    display: 'none'
                }
            },
            tooltip: {
                formatter: function () {
                    return this.point.name + ' visits on <b>' + this.point.device + '</b>';
                }
            },
            series: [{
                type: 'pie',
                innerSize: '60%',
                startAngle: 270,
                dataLabels: {
                    enabled: true,
                    distance: -20,
                    style: {
                        fontFamily: 'glober_regularregular',
                        fontWeight: 'bold',
                        fontSize: '15px',
                        color: '#FFFFFF',
                        textOutline: false
                    }
                },
                data: visitors_data
            }]
        });

        $("#users-chart").highcharts({
            chart: {
                backgroundColor:'rgba(255, 255, 255, 0.0)',
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: '',
                style: {
                    display: 'none'
                }
            },
            tooltip: {
                formatter: function () {
                    return this.point.name + ': <b>' + this.point.y + '</b>';
                }
            },
            series: [{
                type: 'pie',
                innerSize: '60%',
                startAngle: 270,
                dataLabels: {
                    enabled: true,
                    distance: -20,
                    style: {
                        fontFamily: 'glober_regularregular',
                        fontWeight: 'bold',
                        fontSize: '15px',
                        color: '#FFFFFF',
                        textOutline: false
                    }
                },
                data: users_data
            }]
        });

    </script>
@endpush
