@extends('roboplanner.layouts.template')
@section('title',"Dashboard")
@section('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/wealth_score.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/action_steps.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.idealforms.css')  }}">
    <style>
        .results {
            height: 300px;
        }

        .wrapper1, .wrapper2 { width: 100%; overflow-x: scroll; overflow-y: hidden; }
        .wrapper1 { height: 20px; }
        .div1 { height: 20px; }
        .div2 { overflow: none; }
        /*#illustrative_plan caption{*/
            /*font-weight: bold;*/
            /*text-align: center;*/
        /*}*/
        /*#illustrative_plan td, #illustrative_plan th{padding: 3px}*/
        /*#illustrative_plan{*/
            /*width: 1800px !important;*/
        /*}*/

        /*.table-responsive>table>tbody{*/
            /*max-height: 500px;*/
        /*}*/

        .table-responsive > table.fixed-column {
            position: absolute;
            display: inline-block;
            width: auto;
            border-right: 1px solid #ddd;
        }
        #ill_plan th, #ill_plan td{
            text-align: center;
        }
        @media(min-width:768px) {
            .table-responsive > table.fixed-column {
                display: none;
            }
        }

        .retired{
             border-top:3px solid black;s
        }

        .life_expectancy_own{
             border-bottom:3px solid red;
        }

        .life_expectancy_spouse{
             border-bottom:3px solid #FF69B4;
        }


    </style>

@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default bootstrap-admin-navbar-thin">
                <ol class="breadcrumb bootstrap-admin-breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if(Auth::user()->hasRole('administrator'))
                        @if(Request::segment(2) == 'users')
                            <li><a href="{{ route('users') }}">Users</a></li>
                        @else
                            <li><a href="{{ route('clients') }}">Clients</a></li>
                        @endif
                        <li><a href="{{ route('user_show',$user->id) }}">{{ $user->full_name }} Profile</a></li>
                        <li class="active"> {{ $user->full_name }} Dashboard</li>
                     @endif
                </ol>
            </div>
        </div>
    </div>
    <div class="idealsteps-container">
        <nav class="idealsteps-nav"></nav>
        <progress style="display: none" id="progress_bar" value="0" max="100"></progress>
        <form action="" autocomplete="off" class="idealforms">
        <div class="idealsteps-wrap">

            <!-- Step 1 -->
            <section class="idealsteps-step" data-title="Wealth Score">
                <?php //print_r($scores)?>
               @include("roboplanner.wealth_score")
            </section>

            <!-- Step 2 -->

            <section class="idealsteps-step" data-title="Retirement Plan">
                <?php //print_r($retirement_plan)?>
                <?php //print_r($illustrative_plan)?>
                @if(!empty($retirement_plan['series']) || !empty($retirement_plan['categories']))
                    @include("roboplanner.retirement_plan")
                @else
                    Data is Insufficient to Display Graph and Table
                @endif
                <hr>
                <div class="results" style="overflow-x:auto;"></div>
            </section>
            <section class="idealsteps-step" data-title="Action Steps">
                @include("roboplanner.action_steps")
            </section>

            {{--<iframe src="https://docs.google.com/spreadsheets/d/1pl_sk67V9CgfNgf0TtJ3W256H8FwsgkzRnjh9zDF1m4/pubhtml?widget=true&amp;headers=false"></iframe>--}}
        </div>
        <span id="invalid"></span>
        </form>
    </div>


    <div class="container">


    </div>

@endsection

@section('scripts')


    <script src="{{ asset('js/states.js') }}"></script>
    <script src="{{ asset('js/out/jquery.idealforms.js') }}"></script>
    <script src="{{ asset('js/tableHeadFixer.js') }}"></script>

    {{-- Wealth Score Scripts --}}

    <script src="{{ asset('js/extensions/jquery-plugin-circliful-master/js/jquery.circliful.js') }}"></script>
    <script src="{{ asset('js/extensions/masonry-docs/masonry.pkgd.js') }}"></script>
    <script src="{{ asset('js/wealth_score.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.doubleScroll.js') }}"></script>


    {{-- Action Steps Scripts --}}
    <script src="{{ asset('js/extensions/jExpand.js') }}"></script>
    <script>
        var stepsTitle  = [];
        $('.idealsteps-wrap section').each(function(){
            stepsTitle.push($(this).data('title'));
        })
        $('form.idealforms').idealforms({

            //silentLoad: false,
            fadeSpeed: 5,
            steps:{
//                    MY_stepsItems: ['One', 'Two', 'Three'],
                MY_stepsItems: stepsTitle,
                buildNavItems: function(i) {
                    return this.opts.steps.MY_stepsItems[i];
                }
            },
            displayStepCounter: false

        });



        $(function () {
            $('.wrapper1').on('scroll', function (e) {
                $('.wrapper2').scrollLeft($('.wrapper1').scrollLeft());
            });
            $('.wrapper2').on('scroll', function (e) {
                $('.wrapper1').scrollLeft($('.wrapper2').scrollLeft());
            });
        });
        $(window).on('load', function (e) {
            var percents = parseInt($("#ill_plan").width());
            var parentWidth = parseInt($(".wrapper2").width());
            var pixels = parentWidth*(percents/100);

            var width = $('.table').width() * 35;
//            var width = $('.table').width();
            var parentWidth = $('.table').offsetParent().width();
            var percent = 100*width/parentWidth;

            var div = document.getElementById("ill_plan");
//            console.log(window.getComputedStyle(div, null)["width"]);
            console.log(width);
//            console.log(width);

            $('.div1').width(parentWidth + width);
//            $('.div1').width(width);
            $('.div2').width(parentWidth + width);
//            $('.div2').width(width);
        });
        function getInnerWidth(elem) {
            var style = window.getComputedStyle(elem);
            return elem.offsetWidth - parseFloat(style.paddingLeft) - parseFloat(style.paddingRight) - parseFloat(style.borderLeft) - parseFloat(style.borderRight) - parseFloat(style.marginLeft) - parseFloat(style.marginRight);
        }
        $(function(){

//            $('#ïllustrative_plan').doubleScroll();
//            $(".expandable-table").jExpand();
//            $("tbody").each(function(){
//                if($(this).html().trim() == ""){
//                    ($(this).html("<tr><td colspan=3>No records found.</td><tr>"));
//                }
//            });


        });
    </script>


    {{-- Retirement Plan Scripts --}}

    <script src="{{ asset('js/extensions/highstocks/js/highstock.js') }}"></script>
    <script src="{{ asset('js/extensions/highstocks/js/modules/boost.js') }}"></script>
    <script src="{{ asset('js/extensions/highstocks/js/modules/boost.src.js') }}"></script>
    <script src="{{ asset('js/extensions/highstocks/js/modules/exporting.js') }}"></script>
    <script src="{{ asset('js/extensions/highstocks/js/modules/offline-exporting.js') }}"></script>
    <script src="{{ asset('js/extensions/highstocks/js/modules/grouped-categories/grouped-categories.js') }}"></script>

    <script src="{{ asset('js/extensions/math.min.js') }}"></script>
    <script>
        console.log("{{ asset('js/extensions/highcharts/js/modules/grouped-categories/group-categories.js') }}");
       $series = [];
       $categories = [];
        @if(isset($retirement_plan['categories']))
           @foreach($retirement_plan['categories'] as $category)
                $subcategory = [];
                @foreach($category['categories'] as $subcategory)
                    $subcategory.push("{{ $subcategory }}");
                @endforeach
                $category = {name: "{{ $category['name'] }}", categories: $subcategory};
                $categories.push($category);
           @endforeach
        @endif
        @if(isset($retirement_plan['series']))
               @foreach($retirement_plan['series'] as $series_data)
                     $data = [];
                    @foreach($series_data['data'] as $row2)
                        $data.push({{ $row2 }});
                    @endforeach
                    $pointWidth = 20;
                    $series.push({
                        name: "{{ ucwords(str_replace(['_', 'husband', 'wife', 'value'], [' ',$owner, $spouse_name, 'balance'], $series_data['name'])) }}",
                        type: "{{ $series_data['type'] }}",
                        pointWidth: $pointWidth,
                        data: $data
                    });
               @endforeach
        @endif
    </script>
    <script src="{{ asset('js/retirement_plan.js') }}"></script>
    <script src="{{ asset('js/extensions/vue.min.js') }}"></script>
    <script src="{{ asset('js/action_steps.js')  }}"></script>

@endsection
