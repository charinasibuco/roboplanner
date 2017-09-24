@extends('roboplanner.layouts.template')
@section('content')
    <style>
        body{
            overflow-x:hidden;
        }
        h3 {
            color: #5e5e5e;
            font-size: 24px;
            text-align: center;
            margin-top: 5px;
            padding-bottom: 30px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
            /*font-weight: 300;*/
        }

        h4.chart-title {
            color: #5e5e5e;
            font-size: 20px;
            margin-top: 0px;
            text-align: center;
            /*padding-top: 5px;*/
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
            font-weight: 300;
        }

        .container {
            max-width: 970px;
        }

        div[class*='col-'] {
            padding: 0 30px;
        }

        .wrap {
            box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 3px 1px -2px rgba(0, 0, 0, 0.2), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
            border-radius: 4px;
        }

        a:focus,
        a:hover,
        a:active {
            outline: 0;
            text-decoration: none;
        }

        .panel {
            border-width: 0 0 1px 0;
            border-style: solid;
            border-color: #fff;
            background: none;
            box-shadow: none;
        }

        .panel:last-child {
            border-bottom: none;
        }

        .panel-group > .panel:first-child .panel-heading {
           /* border-radius: 4px 4px 0 0;*/
        }

        .panel-group .panel {
            border-radius: 0;
        }

        .panel-group .panel + .panel {
            margin-top: 0;
        }

        .panel-heading {
            background-color: #6869FF;
            border-radius: 0;
            border: none;
            color: #fff;
            padding: 0;
        }

        .panel-title a {
            display: block;
            color: #fff;
            padding: 10px;
            position: relative;
            font-size: 16px;
            font-weight: 400;
        }

        .panel-body {
            background: #fff;
        }

        .panel:last-child .panel-body {
            /*border-radius: 0 0 4px 4px;*/
        }

        .panel:last-child .panel-heading {
            /*border-radius: 0 0 4px 4px;*/
            transition: border-radius 0.3s linear 0.2s;
        }

        .panel:last-child .panel-heading .active {
            border-radius: 0;
            transition: border-radius linear 0s;
        }
        /* #bs-collapse icon scale option */

        .panel-heading a:before {
            content: '\f0fe';
            position: absolute;
            font-family: FontAwesome;
            right: 10px;
            top: 10px;
            font-size: 20px;
            transition: all 0.5s;
            transform: scale(1);
        }

        .panel-heading.active a:before {
            content: ' ';
            transition: all 0.5s;
            transform: scale(0);
        }

        #bs-collapse .panel-heading a:after {
            content: "\f146";
            font-size: 20px;
            position: absolute;
            font-family: FontAwesome;
            right: 10px;
            top: 10px;
            transform: scale(0);
            transition: all 0.5s;
        }

        #bs-collapse .panel-heading a:after {
            content: ' ';
            font-size: 20px;
            position: absolute;
            font-family: FontAwesome;
            right: 10px;
            top: 10px;
            transform: scale(0);
            transition: all 0.5s;
        }

        #bs-collapse .panel-heading.active a:after {
            content: '\f146';
            transform: scale(1);
            transition: all 0.5s;
        }
        /* #accordion rotate icon option */

        #accordion .panel-heading a:before {
            content: '\f106';
            font-size: 20px;
            position: absolute;
            font-family: FontAwesome;
            right: 10px;
            top: 10px;
            transform: rotate(180deg);
            transition: all 0.5s;
        }

        #accordion .panel-heading.active a:before {
            transform: rotate(0deg);
            transition: all 0.5s;
        }

        i.red-flag {
            color:#A52A2A
        }

        i.yellow-flag {
            color:#f7dc6f
        }

        a.list-group-item{
            /*top right bottom left*/
            padding: 7px 7px 7px 0px;
            font-size: 13px;
        }

        .flag-content{
            overflow:hidden;
        }

        .flag-content .flag-content-left{
            width: 20%;
            text-align:center;
            float: left;
        }
        .flag-content .flag-content-right{
            width: 80%;
            float: right;
        }

    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="active">Results</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="results-heading">Wealth Score</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="test-circle"></div>
                {{-- scores ---}}
                <h4 class="chart-title">Liquidity</h4>
                <div class="panel-group wrap liquidity-panel" id="bs-collapse">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".liquidity-panel" href="#liquidity-one">
                                    <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i> Why did I get this score?
                                </a>
                            </h4>
                        </div>
                        <div id="liquidity-one" class="panel-collapse collapse">
                            <div class="panel-body">
                                Where now are the horse and the rider? Where is the horn that was blowing? Where is the helm and the hauberk, and the bright hair flowing?
                            </div>
                        </div>

                    </div>
                    <!-- end of panel -->

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".liquidity-panel" href="#liquidity-two">
                                    <i class="fa fa-arrow-up fa-fw" aria-hidden="true"></i>What can I do to improve?
                                </a>
                            </h4>
                        </div>
                        <div id="liquidity-two" class="panel-collapse collapse">
                            <div class="panel-body">
                                Where is the harp on the harpstring, and the red fire glowing? Where is the spring and the harvest and the tall corn growing?
                            </div>

                        </div>
                    </div>
                    <!-- end of panel -->

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".liquidity-panel" href="#liquidity-three">
                                    <i class="fa fa-flag fa-fw"></i> Flags
                                </a>
                            </h4>
                        </div>
                        <div id="liquidity-three" class="panel-collapse collapse">
                            <div class="list-group">
                                <a href="javascript:void(0)" class="list-group-item list-group-item-danger">
                                    <div class="flag-content">
                                        <div class="flag-content-left">
                                            <i class="fa fa-flag fa-lg"></i>
                                        </div>
                                        <div class="flag-content-right">
                                            Debt payments are a greater than 1/3 of income
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-danger">
                                    <div class="flag-content">
                                        <div class="flag-content-left">
                                            <i class="fa fa-flag fa-lg"></i>
                                        </div>
                                        <div class="flag-content-right">
                                            Less than $2,000 in an emergency fund
                                       </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-warning">
                                    <div class="flag-content">
                                        <div class="flag-content-left">
                                            <i class="fa fa-flag fa-lg"></i>
                                        </div>
                                        <div class="flag-content-right">
                                            Less than 6 months of income in emergency fund
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end of panel -->
                </div>
                <!-- end of #bs-collapse  -->
            </div>
            <div class="col-md-4">
                <div class="test-circle"></div>
                {{-- scores ---}}
                <h4 class="chart-title">Insurance</h4>
                <div class="panel-group wrap insurance-panel" id="accordion">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".insurance-panel" href="#insurance-one">
                                    <i class="fa fa-question-circle fa-fw" aria-hidden="true"></i> Why did I get this score?
                                </a>
                            </h4>
                        </div>
                        <div id="insurance-one" class="panel-collapse collapse">
                            <div class="panel-body">
                                Where now are the horse and the rider? Where is the horn that was blowing? Where is the helm and the hauberk, and the bright hair flowing?
                            </div>
                        </div>

                    </div>
                    <!-- end of panel -->

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".insurance-panel" href="#insurance-two">
                                    <i class="fa fa-arrow-up fa-fw" aria-hidden="true"></i>What can I do to improve?
                                </a>
                            </h4>
                        </div>
                        <div id="insurance-two" class="panel-collapse collapse">
                            <div class="panel-body">
                                Where is the harp on the harpstring, and the red fire glowing? Where is the spring and the harvest and the tall corn growing?
                            </div>

                        </div>
                    </div>
                    <!-- end of panel -->

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".insurance-panel" href="#insurance-three">
                                    <i class="fa fa-flag fa-fw"></i> Flags
                                </a>
                            </h4>
                        </div>
                        <div id="insurance-three" class="panel-collapse collapse">
                                {{--<ul class="fa-ul">
                                    <li><i class="fa-li fa fa-flag fa-lg red-flag"></i>Debt payments are a greater than 1/3 of income</li>
                                    <li><i class="fa-li fa fa-flag fa-lg red-flag"></i>Less than $2,000 in an emergency fund</li>
                                    <li><i class="fa-li fa fa-flag fa-lg yellow-flag"></i>Less than 6 months of income in emergency fund</li>
                                </ul>--}}
                            <div class="list-group">
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="flag-content">
                                        <div class="flag-content-left">
                                            <i class="fa fa-flag fa-lg red-flag"></i>
                                        </div>
                                        <div class="flag-content-right">
                                            Debt payments are a greater than 1/3 of income
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="flag-content">
                                        <div class="flag-content-left">
                                            <i class="fa fa-flag fa-lg red-flag"></i>
                                        </div>
                                        <div class="flag-content-right">
                                            Less than $2,000 in an emergency fund
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="list-group-item">
                                    <div class="flag-content">
                                        <div class="flag-content-left">
                                            <i class="fa fa-flag fa-lg yellow-flag"></i>
                                        </div>
                                        <div class="flag-content-right">
                                            Less than 6 months of income in emergency fund
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- end of panel -->
                </div>
                <!-- end of #bs-collapse  -->
            </div>
            <div class="col-md-4">
                <div class="test-circle"></div>
                {{-- scores ---}}
                <h4 class="chart-title">Legacy</h4>
                <div class="panel-group wrap legacy-panel" id="bs-collapse">
                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".legacy-panel" href="#legacy-one">
                                    Why did I get this score?
                                </a>
                            </h4>
                        </div>
                        <div id="legacy-one" class="panel-collapse collapse">
                            <div class="panel-body">
                                Where now are the horse and the rider? Where is the horn that was blowing? Where is the helm and the hauberk, and the bright hair flowing?
                            </div>
                        </div>

                    </div>
                    <!-- end of panel -->

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".legacy-panel" href="#legacy-two">
                                    What can I do to improve?
                                </a>
                            </h4>
                        </div>
                        <div id="legacy-two" class="panel-collapse collapse">
                            <div class="panel-body">
                                Where is the harp on the harpstring, and the red fire glowing? Where is the spring and the harvest and the tall corn growing?
                            </div>

                        </div>
                    </div>
                    <!-- end of panel -->

                    <div class="panel">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent=".legacy-panel" href="#legacy-three">
                                    Flags
                                </a>
                            </h4>
                        </div>
                        <div id="legacy-three" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="fa-ul">
                                    <li><i class="fa-li fa fa-flag fa-lg red-flag"></i>Debt payments are a greater than 1/3 of income</li>
                                    <li><i class="fa-li fa fa-flag fa-lg red-flag"></i>Less than $2,000 in an emergency fund</li>
                                    <li><i class="fa-li fa fa-flag fa-lg yellow-flag"></i>Less than 6 months of income in emergency fund</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end of panel -->
                </div>
                <!-- end of #bs-collapse  -->
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('js/extensions/jquery-plugin-circliful-master/js/jquery.circliful.js') }}"></script>
<script>
    $( document ).ready(function() {
        $('.collapse.in').prev('.panel-heading').addClass('active');
        $('#accordion, #bs-collapse')
                .on('show.bs.collapse', function(a) {
                    $(a.target).prev('.panel-heading').addClass('active');
                })
                .on('hide.bs.collapse', function(a) {
                    $(a.target).prev('.panel-heading').removeClass('active');
                });

        var color_array = ["#3498DB","#3CB371","#A52A2A"];
        var sample_result_array = ["50","25","75"];
        var color_count = 0;

        $(".test-circle").each( function(){
            $(this).circliful({
                animationStep: 5,
                foregroundBorderWidth: 5,
                backgroundBorderWidth: 15,
                percent: sample_result_array[color_count],
                foregroundColor: color_array[color_count]
            });
            $(this).siblings(".panel-group").children(".panel").children(".panel-heading").css("background-color", color_array[color_count]);
            color_count++;
        });
    });


</script>
@endsection
