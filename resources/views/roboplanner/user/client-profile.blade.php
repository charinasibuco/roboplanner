@extends('roboplanner.layouts.template')
@section('title', $user->full_name . ' Profile')
@section('styles')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('js/extensions/jquery-datepicker/jquery.datepick.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/jquery.idealforms.css')  }}">
    <style>
        .button-column{
            text-align: right;
        }

        .others-row/*, .home-rows*/{
            display:none;
        }

        /* .home-rows{
            display:none;
        }*/


        .row-title{
            font-size: 20px;
            font-weight: bold;
        }
       /* tbody {
            border: 1px solid #ccc;
        }*/
    </style>
@stop
@section('content')
    <?php $count_symbols = 0;?>
    <div class="row">
        <div class="col-lg-12">
            <div class="navbar navbar-default bootstrap-admin-navbar-thin">
                <ol class="breadcrumb bootstrap-admin-breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if(Request::segment(2) == 'users')
                    <li><a href="{{ route('users') }}">Users</a></li>
                    @else
                        <li><a href="{{ route('clients') }}">Clients</a></li>
                    @endif
                    <li class="active">{{ $user->full_name }} Profile</li>
                    @if(Auth::user()->hasRole('administrator'))
                        <li><a href="{{ route('dashboard_show', $user->id) }}">{{ $user->full_name }} Dashboard </a></li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Session::get('message') }}
        </div>
    @elseif(count($errors) > 0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <li style="list-style:none">{{ $error }}</li>
            </div>
        @endforeach
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">{{ $user->full_name  }} Profile</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-group">
                                    <li class="list-group-item active">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="row-title"><i style="color: white" class="fa fa-user"></i> Profile</div>
                                            </div>
                                            <div class="col-sm-2">
                                                <a class="btn btn-warning" href="{{ route("user_edit",Auth::user()->id) }}">Edit</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item" style="text-align: center">
                                        <img src="{{ isset($user->image)?asset($user->image):asset('images/default_user.png') }}">
                                    </li>
                                    <li class="list-group-item">
                                       <b> Name:</b> {{ $user->first_name." ".$user->last_name }}
                                    </li>
                                    <li class="list-group-item">
                                        <b>Status:</b> {{ $user->status  }}
                                    </li>
                                    <li class="list-group-item">
                                        <b>Email:</b> {{ $user->email  }}
                                    </li>

                                    <li class="list-group-item">
                                        <b>Date Registered:</b> {{ ($user->created_at != null) ? $user->created_at->format('m/d/Y') : 'N/A' }} <small>{{ ($user->created_at != null) ? $user->created_at->diffForHumans() : 'N/A' }}</small>
                                    </li>
                                </ul>

                                <!--  Announcements  -->
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}" id="stateslide-form">
                                        <table class="table">
                                            <thead>
                                            <tr class="success">
                                                <th width='70%'><i class="fa fa-sliders" aria-hidden="true"></i> State Slide</th>
                                                <th width='30%' class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                        <span>
                                                            <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>&nbsp;
                                                            <!-- <input class='btn btn-success meta_save' type="submit" value="Save"> -->
                                                            <input class='btn btn-success meta_save' type="submit" value="Save">
                                                        </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="radio-row" data-hidden="will">
                                                <tr>
                                                    <td>Do you have a will?</td>
                                                    <td class="input input-radio" data-field="do_you_have_a_will">{{ $meta->do_you_have_a_will or 'No' }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class="hidden-row" data-hidden="will">
                                            <tr>
                                                <td> How long since you last reviewed it?</td>
                                                <td class="input input-select" id="how_long_has_it_been_since_you_renewed_it" data-field="how_long_has_it_been_since_you_renewed_it">{{ $meta->how_long_has_it_been_since_you_renewed_it or 'N/A' }}</td>

                                            </tr>
                                            <tr>
                                                <td>Do you have healthcare proxy?</td>
                                                <td class="input input-radio" data-field="do_you_have_healthcare_proxy">{{ $meta->do_you_have_healthcare_proxy or 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have a power of attorney?</td>
                                                <td class="input input-radio" data-field="do_you_have_power_of_attorney">{{ $meta->do_you_have_power_of_attorney or 'No' }}</td>
                                            </tr>
                                            </tbody>
                                            <tbody class="alternate-row" data-hidden="will">
                                                <tr>
                                                    <td>Do you want to link financial accounts or manually enter data?</td>
                                                    <td data-field="do_you_want_to_link_financial_accounts_or_manually_enter_data" class="input input-radio">{{ $meta->do_you_want_to_link_financial_accounts_or_manually_enter_data or 'No' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}" id="riskmanagement-form">
                                        <table class="table life_insurance">
                                            <thead>
                                            <tr class="success">
                                                <th><i class="fa fa-stethoscope" aria-hidden="true"></i> Risk Management</th>
                                                <th class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                        <span>
                                                            <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>&nbsp;
                                                            <input class='btn btn-success meta_save' type="submit" value="Save">
                                                        </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class="radio-row life-insurance" data-hidden="life-insurance">
                                                <tr>
                                                    <td>Do you have life insurance?</td>
                                                    <td class="input input-radio required" data-field="do_you_have_life_insurance">{{ $meta->do_you_have_life_insurance or 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class='tbody-main hidden-row' data-hidden="life-insurance"></tbody>
                                            <tbody class="hidden-row" data-hidden="life-insurance">
                                            <input type="hidden" id="life_insurance-default-benefit_type" name="life_insurance[default][benefit_type]" value="default">
                                            @if(isset($meta->do_you_have_life_insurance) && $meta->do_you_have_life_insurance == 'Yes')
                                                @if(isset($meta->life_insurance) && count($meta->life_insurance) > 0)
                                                    @foreach($meta->life_insurance as $key => $insurance)
                                                        @include('roboplanner.user.client-template.life_insurance', ['insurance_count'=>$key, 'insurance' => $insurance])
                                                    @endforeach
                                                @endif
                                            @endif
                                            <tbody class="stop-insurance"></tbody>
                                            <tr>
                                                <td>What is the total value of your emergency fund?</td>
                                                <td class="input currency required" data-field="what_is_the_total_value_of_your_emergency_fund">{{ $meta->what_is_the_total_value_of_your_emergency_fund or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have Disability Insurance?</td>
                                                <td class="input input-radio required" data-field="do_you_have_disability_insurance">{{ $meta->do_you_have_disability_insurance or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have Health Insurance?</td>
                                                <td class="input input-radio required" data-field="do_you_have_health_insurance">{{ $meta->do_you_have_health_insurance or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have Home Owners Insurance?</td>
                                                <td class="input input-radio required" data-field="do_you_have_home_owners_insurance">{{ $meta->do_you_have_home_owners_insurance or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tax-Free Income:</td>
                                                <td class="input  currency" data-field="tax_free">{{ $meta->tax_free or 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tax Deferred Investments:</td>
                                                <td class="input currency" data-field="tax_deferred">{{ $meta->tax_deferred or 0 }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}" id="income-statement-form">
                                        <table class="table">
                                            <thead>
                                            <tr class="success">
                                                <th><i class="fa fa-money" aria-hidden="true"></i> Income Statement</th>
                                                <th class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                    <span>
                                                        <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>&nbsp;
                                                        <input class='btn btn-success meta_save' type="submit" value="Save">
                                                    </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>What is your pre-tax annual income?</td>
                                                <td class="input currency required" data-field="pre_tax_income">{{ $meta->pre_tax_income }}</td>
                                            </tr>
                                            <tr>
                                                <td>Spouse?</td>
                                                <td class="input currency" data-field="pre_tax_income_spouse">{{ $meta->pre_tax_income_spouse }}</td>
                                            </tr>
                                            @if(isset($meta->estimate_after_tax_monthly_income))
                                            <tr>
                                                <td>Estimate after-tax monthly income?</td>
                                                <td class="input currency required" data-field="estimate_after_tax_monthly_income">{{ $meta->estimate_after_tax_monthly_income }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>Estimated monthly living expenses?</td>
                                                <td class="input currency required" data-field="estimated_monthly_living_expenses_dont_know">{{ isset($meta->estimated_monthly_living_expenses_dont_know) ? $meta->estimated_monthly_living_expenses_dont_know : $meta->estimated_montlhy_living_expenses }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you anticipate any changes in your annual income?</td>
                                                <td class="input input-radio" data-field="do_you_anticipate_any_changes_in_your_annual_income">{{ $meta->do_you_anticipate_any_changes_in_your_annual_income or 'N/A' }}</td>
                                            </tr>

                                            </tbody>
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}">
                                        <table class="table">
                                            <thead>
                                            <tr class="success">
                                                <th><i class="fa fa-area-chart" aria-hidden="true"></i> Suitability</th>
                                                <th class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                    <span>
                                                        <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>&nbsp;
                                                        <input class='btn btn-success meta_save' type="submit" value="Save">
                                                    </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>What long-term rate or return do you expect from your investments?</td>
                                                <td class="input percentage required" data-field="long_term_rate_return_from_investments">
                                                    {{ $meta->long_term_rate_return_from_investments or 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>In investing, what is the smallest percentage you could lose before - You would be uncomfortable:</td>
                                                <td class="input percentage required" data-field="you_would_be_uncomfortable">
                                                    {{ $meta->you_would_be_uncomfortable or 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>You would fire me/panic/go to cash:</td>
                                                <td class="input percentage required" data-field="you_would_fire_me_panic_go_to_cash">
                                                    {{ $meta->you_would_fire_me_panic_go_to_cash or 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>When do you plan to make major withdrawal?</td>
                                                <td class="input input-radio withdrawal" data-field="when_do_you_plan_to_make_major_withdrawal">
                                                    {{ $meta->when_do_you_plan_to_make_major_withdrawal or 'N/A' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">Have you ever invested in:</td>
                                            </tr>

                                            @if(isset($meta->investments))
                                                <tr>
                                                    <td class="input input-checkbox" data-field="investments" colspan="2">
                                                        @foreach($meta->investments as $item)
                                                            <span data-field="{{ $item->name }}">{{ $item->name }}</span><br/>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Would you invest in inverse securities or short investments?</td>
                                                <td class="input input-radio" data-field="inverse_securities_or_short_investments">
                                                    {{ $meta->inverse_securities_or_short_investments or 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Are you opposed to using leverage?</td>
                                                <td class="input input-radio" data-field="opposed_to_using_leverages">
                                                    {{ $meta->opposed_to_using_leverages or 'N/A' }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}">
                                        <table class="assets table">
                                            <thead>
                                            <tr class="success">
                                                <th><i class="fa fa-pie-chart" aria-hidden="true"></i> Assets</th>
                                                <th class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                        <span>
                                                            <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>&nbsp;
                                                            <input class='btn btn-success meta_save' type="submit" value="Save">
                                                        </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class='tbody-main'></tbody>
                                            <!--============================================================================
                                               These hidden inputs is to let the empty array fields get submitted in post
                                            ===============================================================================-->
                                            <input type="hidden" id="assets-default-asset_type" name="assets[default][asset_type]" value="default">
                                            <tbody class='start-assets'></tbody>
                                            @if(isset($meta->assets))
                                                <?php $item_ctr = 0;?>
                                                @foreach($meta->assets as $item => $vitem)
                                                    @include("roboplanner.user.client-template.asset",["item" => $item, "vitem" => $vitem, "asset_count" => $item_ctr,"count_symbols" => $count_symbols, "asset_id" => "assets-".$item."-asset-type"])
                                                    <?php $item_ctr++;?>
                                                @endforeach
                                            @endif
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!--  Family Information -->
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}" id="family-form">
                                        <table class="table">
                                            <thead>
                                                <tr class="success">
                                                    <th>
                                                        <i class="fa fa-info-circle fa-lg"></i> Personal & Family Information
                                                    </th>
                                                    <th class="button-column">
                                                        <a class='btn btn-default meta_update'>Update</a>
                                                        <span>
                                                            <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>&nbsp;
                                                            <input class='btn btn-success meta_save' type="submit" value="Save">
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td>Age:</td>
                                                <td class="input numericOnly required" data-field="age">{{ $meta->age or ''  }}</td>
                                            </tr>
                                            <tr>
                                                <td>Sex:</td>
                                                <td class="input input-radio sex" data-field="sex">{{ $meta->sex or ''  }}</td>
                                            </tr>
                                            <tr>
                                                <td>State:</td>
                                                <td class="input required" data-field="state">{{ $meta->state or ''  }}</td>
                                            </tr>
                                            <tr>
                                                <td>Occupation:</td>
                                                <td class="input" data-field="occupation">{{ $meta->occupation or ''  }}</td>
                                            </tr>
                                            <tbody class="radio-row" data-hidden="married">
                                                <tr>
                                                    <td>Married?</td>
                                                    <td class="input input-radio" data-field="married">{{ $meta->married or 'No'  }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class="hidden-row" data-hidden="married">
                                                <tr>
                                                    <td>Spouse Name:</td>
                                                    <td class="input required" data-field="spouse_name">{{ $meta->spouse_name or 'N/A'  }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Spouse Age:</td>
                                                    <td class="input numericOnly required" data-field="spouse_age">{{ $meta->spouse_age or 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Spouse Sex:</td>
                                                    <td class="input input-radio spouse_sex sex required" data-field="spouse_sex">{{ $meta->spouse_sex or 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {!!  csrf_field() !!}
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}" id="children-form">
                                        <table class="table children">
                                            <thead>
                                                <tr class="success">
                                                    <th><i class="fa fa-users" aria-hidden="true"></i> Children</th>
                                                    <th class="button-column">
                                                        <a class='btn btn-default meta_update'>Update</a>
                                                        <span>
                                                            <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>&nbsp;
                                                            <input class='btn btn-success meta_save' type="submit" value="Save">
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class='tbody-main'></tbody>
                                            <!--============================================================================
                                                These hidden inputs is to let the empty array fields get submitted in post
                                             ===============================================================================-->
                                            <input type="hidden" id="children-default-name" name="children[default][name]" value="default">
                                            @if(isset($meta->children))
                                                @foreach($meta->children as $key => $child)
                                                    <tbody class="children generated">
                                                        <tr>
                                                            <td class="child-name">Name:</td>
                                                            <td class="input" id="children-{{ $key }}-name" data-field="children[{{ $key }}][name]">{{ $child->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Age:</td>
                                                            <td class="input numericOnly" id="children-{{ $key }}-age" data-field="children[{{ $key }}][age]">{{ $child->age }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Do you want a College Plan (below 18 yrs)?</td>
                                                            <td class="input input-radio" id="children-{{ $key }}-child_college_plan" data-field="children[{{ $key }}][child_college_plan]">{{ $child->child_college_plan or 'N/A' }}</td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach
                                            @endif
                                            <tbody class="stop-children">
                                                <tr>
                                                    <td>Do any Children have Special Needs?</td>
                                                    <td class="input input-radio" data-field="have_child_special_needs">{{ $meta->have_child_special_needs or 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Have Special Needs Trust?</td>
                                                    <td class="input input-radio" data-field="have_special_needs_trust">{{ $meta->have_special_needs_trust or 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {!!  csrf_field() !!}
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}" id="tax-slide-form">
                                        <table class="expenses table">
                                            <thead>
                                            <tr class="success">
                                                <th><i class="fa fa-area-chart" aria-hidden="true"></i> Tax Slide</th>
                                                <th class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                        <span>
                                                            <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>&nbsp;
                                                            <input class='btn btn-success meta_save' type="submit" value="Save">
                                                        </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Working with Financial Adviser?</td>
                                                <td class="input input-radio" data-field="working_with_financial_advisor">{{ $meta->working_with_financial_advisor or 'N/A' }}</td>
                                            </tr>
                                            @if(isset($meta))
                                                <tbody class="radio-row" data-hidden="large-expense">
                                                <tr>
                                                    <td>Do You Have Large Expenses Coming Up?</td>
                                                    <td class="input input-radio" data-field="do_you_have_large_expenses_coming_up">{{ $meta->do_you_have_large_expenses_coming_up or 'N/A' }}</td>
                                                </tr>
                                                </tbody>
                                                <tbody class="hidden-row" data-hidden="large-expense">
                                                <tr>
                                                    <td colspan='2'>Expenses:</td>
                                                </tr>
                                                <tbody>
                                                <tbody class='tbody-main hidden-row' data-hidden="large-expense"></tbody>
                                                @if(isset($meta->expenses))
                                                    @foreach($meta->expenses as $item => $vitem)
                                                        <tbody class="hidden-row generated" data-hidden="large-expense">
                                                        <tr class="select-row">
                                                            <td class="expense-type-column">Type:</td>
                                                            <td class="input input-select expense-type" id="expenses-{{ $item }}-expense_type" data-field="expenses[{{ $item }}][expense_type]">{{ $vitem->expense_type or '' }}</td>
                                                        </tr>
                                                        <tr class="others-row">
                                                            <td>Name:</td>
                                                            <td class="input others" id="expenses-{{ $item }}-others" data-field="expenses[{{ $item }}][others]">{{ $vitem->others or "" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Expense Amount:</td>
                                                            <td class="input currency" id="expenses-{{ $item }}-expense_amount" data-field="expenses[{{ $item }}][expense_amount]">{{ $vitem->expense_amount or "" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Timeframe (Start):</td>
                                                            <td class="input datepicker" id="expenses-{{ $item }}-timeframe_start" data-field="expenses[{{ $item }}][timeframe_start]">{{ $vitem->timeframe_start or "" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Timeframe (End):</td>
                                                            <td class="input datepicker" id="expenses-{{ $item }}-timeframe_end" data-field="expenses[{{ $item }}][timeframe_end]">{{ $vitem->timeframe_end or "" }}</td>
                                                        </tr>
                                                        </tbody>
                                                    @endforeach
                                                @endif
                                                <tbody class='stop-expenses hidden-row' data-hidden="large-expense"></tbody>
                                            @endif
                                            <tr>
                                                <td>Who did your taxes last year?</td>
                                                <td class="input input-select" id="who_did_your_taxes_last_year" data-field="who_did_your_taxes_last_year">{{ $meta->who_did_your_taxes_last_year or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>How big was your refund last year?</td>
                                                <td class="input currency" data-field="how_big_is_your_refund">{{ $meta->how_big_is_your_refund or 'N/A' }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}" id="retirementplan-form">
                                        <table class="pensions table">
                                            <thead>
                                            <tr class="success">
                                                <th><i class="fa fa-line-chart" aria-hidden="true"></i> Retirement Plan</th>
                                                <th class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                    <span>
                                                        <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>&nbsp;
                                                        <input class='btn btn-success meta_save' type="submit" value="Save">
                                                    </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>What age do you plan on retiring?</td>
                                                <td class="input numericOnly required" data-field="what_age_do_you_plan_on_retiring_age">{{ $meta->what_age_do_you_plan_on_retiring_age or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have any health conditions that would greatly affect your life expectancy?</td>
                                                <td class="input input-radio" data-field="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy">
                                                    {{ $meta->do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy or 'No' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>In today's dollars, what after-tax income would you need each month to retire</td>
                                                <td class="input currency" data-field="in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement">
                                                    {{ $meta->in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement or '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>What life expectancy would you like us to assume instead?</td>
                                                <td class="input numericOnly" data-field="what_age_would_you_like_us_to_assume">{{ $meta->what_age_would_you_like_us_to_assume or 'N/A' }}</td>
                                            </tr>


                                            
                                            <tbody class="hidden-row" data-hidden="married">
                                                <tr>
                                                    <td>(If Married) Does your spouse have any health conditions that would greatly affect their life expectancy?</td>
                                                    <td class="input input-radio" data-field="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy">
                                                        {{ $meta->does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy or 'N/A' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody class="radio-row" data-hidden="part-time">
                                                <tr>
                                                    <td>Do you plan on working part time in retirement?</td>
                                                    <td class="input input-radio" data-field="do_you_plan_on_working_part_time_in_retirement">
                                                        {{ $meta->do_you_plan_on_working_part_time_in_retirement or 'N/A' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody class="hidden-row" data-hidden="part-time">
                                                <tr>
                                                    <td>Estimated Income:</td>
                                                    <td class="input currency" data-field="estimated_income">{{ $meta->estimated_income }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class="radio-row" data-hidden="social-security">
                                                <tr>
                                                    <td>Do you know your monthly social security benefit at full retirement age?</td>
                                                    <td class="input input-radio" data-field="do_you_know_your_social_security_benefit_at_retirement">{{ $meta->do_you_know_your_social_security_benefit_at_retirement or 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class="hidden-row" data-hidden="social-security">
                                                <tr>
                                                    <td colspan="2">Social Security...</td>
                                                </tr>
                                                <tr>
                                                    <td>Yours:</td>
                                                    <td class="input currency" data-field="social_security_retirement_benefit_yours">{{ $meta->social_security_retirement_benefit_yours or '0.00' }}</td>
                                                </tr>
                                                <tbody class="hidden-row" data-hidden="married">
                                                    <tr>
                                                        <td>Spouse:</td>
                                                        <td class="input currency" data-field="social_security_retirement_benefit_spouse">{{ $meta->social_security_retirement_benefit_spouse or '0.00' }}</td>
                                                    </tr>
                                                </tbody>
                                            </tbody>
                                            <tbody class="radio-row" data-hidden="pension">
                                                <tr>
                                                    <td>Do you or your spouse have a pension?</td>
                                                    <td class="input input-radio" data-field="do_you_or_your_spouse_have_a_pension">{{ $meta->do_you_or_your_spouse_have_a_pension or 'N/A' }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class="hidden-row" data-hidden="pension">
                                                <tr>
                                                    <td colspan="2">Pensions:</td>
                                                </tr>
                                            </tbody>
                                            <tbody class='tbody-main hidden-row' data-hidden="pension"></tbody>
                                            <!--============================================================================
                                            These hidden inputs is to let the empty array fields get submitted in post
                                            ===============================================================================-->
                                            <input type="hidden" id="pension-default-type" name="pension[default][type]" value="default">


                                            @if(isset($meta->pension) && count($meta->pension) > 0)
                                                @foreach($meta->pension as $key => $item)
                                                    @include('roboplanner.user.client-template.pension', ['pension_count'=>$key, 'pension' => $item])
                                                @endforeach
                                            @endif
                                            <tbody class='stop-pensions hidden-row' data-hidden="pension"></tbody>
                                            <tbody>
                                                <tr>
                                                    <td>Would you rather:</td>
                                                    <td class="input input-radio" data-field="would_you_rather">{{ $meta->would_you_rather or 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Retirement Income Need:</td>
                                                    <td class="input currency" data-field="retirement_income_funded">{{ $meta->retirement_income_funded or 'N/A' }}</td>
                                                </tr>
                                                @if(isset($meta->income_need_today))
                                                    <tr>
                                                        <td>Income Need Today:</td>
                                                        <td class="input currency" data-field="income_need_today">{{  $meta->income_need_today }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
                                </div>


                                &nbsp;
                                <div class="table-responsive">
                                    <form class="meta_form" method="post" action="{{ route('meta_update',$user->id) }}">
                                        <table class="liabilities table">
                                            <thead>
                                            <tr class="success">
                                                <th><i class="fa fa-tags" aria-hidden="true"></i> Liabilities</th>
                                                <th class="button-column">
                                                    <a class='btn btn-default meta_update'>Update</a>
                                                        <span>
                                                            <a class='btn btn-danger cancel' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i>
                                                            </a>&nbsp;
                                                            <input class='btn btn-success meta_save' type="submit" value="Save">
                                                        </span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody class='tbody-main'></tbody>
                                            <!--============================================================================
                                               These hidden inputs is to let the empty array fields get submitted in post
                                            ===============================================================================-->
                                            <input type="hidden" id="liabilities-default-liability_type" name="liabilities[default][liability_type]" value="default">
                                            @if(isset($meta->liabilities))
                                                @foreach($meta->liabilities as $item => $vitem)
                                                    <tbody class="generated">
                                                    <tr class="select-row">
                                                        <td class="liability-type-column">Type:</td>
                                                        <td class="input input-select liability-type" id="liabilities-{{ $item }}-liability_type" data-field="liabilities[{{ $item }}][liability_type]">
                                                            @if(isset($vitem->liability_type))
                                                                @if($vitem->liability_type == 'HELOC')
                                                                    Home Equity Line of Credit
                                                                @else
                                                                    {{ $vitem->liability_type }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Owner/Debtor:</td>
                                                        <td class="input" id="liabilities-{{ $item }}-owner_debtor" data-field="liabilities[{{ $item }}][owner_debtor]">{{ $vitem->owner_debtor or '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bank:</td>
                                                        <td class="input" id="liabilities-{{ $item }}-bank" data-field="liabilities[{{ $item }}][bank]">{{ $vitem->bank or '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Balance:</td>
                                                        <td class="input currency" id="liabilities-{{ $item }}-balance" data-field="liabilities[{{ $item }}][balance]">{{ $vitem->balance }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Monthly Payment:</td>
                                                        <td class="input currency" id="liabilities-{{ $item }}-monthly_payment" data-field="liabilities[{{ $item }}][monthly_payment]">{{ $vitem->monthly_payment }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Interest Rate:</td>
                                                        <td class="input percentage" id="liabilities-{{ $item }}-interest_rate" data-field="liabilities[{{ $item }}][interest_rate]">{{ $vitem->interest_rate }}</td>
                                                    </tr>
                                                    @if($vitem->liability_type != 'Credit Card' && $vitem->liability_type != 'Auto Loan' && $vitem->liability_type != 'Personal Loan' && $vitem->liability_type != 'Business Loan' && $vitem->liability_type != 'HELOC')

                                                    <tr>
                                                        <td>Loan Term (Start):</td>
                                                        <td class="input datepicker" id="liabilities-{{ $item }}-loan_term_start" data-field="liabilities[{{ $item }}][loan_term_start]">{{ $vitem->loan_term_start }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Loan Term (End):</td>
                                                        <td class="input datepicker" id="liabilities-{{ $item }}-loan_term_end" data-field="liabilities[{{ $item }}][loan_term_end]">{{ $vitem->loan_term_end }}</td>
                                                    </tr>
                                                    {{--<tr>--}}
                                                        {{--<td>Loan Date:</td>--}}
                                                        {{--<td class="input datepicker" id="liabilities-{{ $item }}-loan_date" data-field="liabilities[{{ $item }}][loan_date]">{{ $vitem->loan_date }}</td>--}}
                                                    {{--</tr>--}}
                                                    </tbody>
                                                @endforeach
                                            @endif
                                            <tbody class='stop-liabilities'></tbody>
                                        </table>
                                        {!! csrf_field() !!}
                                    </form>
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
@section('scripts')
    <script src="{{ asset('js/extensions/jquery.price_format.2.0.js') }}"></script>
    <script src="{{ asset('js/extensions/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/extensions/jquery-datepicker/jquery.plugin.js') }}"></script>
    <script src="{{ asset('js/jquery.autocomplete.js') }}"></script>
    <script src="{{ asset('js/states.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/extensions/validation/dist/jquery.validate.js') }}"></script>
   {{-- <script type="text/javascript" src="{{ asset('js/extensions/jquery-datepicker/jquery.datepick.js') }}"></script>--}}
    <script>
        /** ===========================================================================
         * Route Variables
         * ============================================================================== **/
        $client_template = "{{ route('client_template') }}";
        $token = "{{ csrf_token() }}";
        /**=========================================================
         * format display to currency
         *======================================================== **/
        var $symbols = [];
        @if(isset($symbols))
            @foreach($symbols as $key => $symbol)
                    $symbols['{{ $key }}'] = "{{ $symbol }}";
            @endforeach
        @endif
        /* writeSymbol = function($e,$id){
         $("#"+$id).removeAttr('readonly');
         $("#"+$id).val('');
         $("#"+$e.id).remove();
         autoCompleteSymbols();
         }*/
        autoCompleteSymbols = function(){
            $('.symbols').autocomplete({
                lookup: $symbols,
                onSelect: function () {
                    $index = $symbols.indexOf($(this).val());
                    if($index > -1){
                        $symbols.splice($index, 1);
                    }
                    $('.symbols').autocomplete({
                        lookup: $symbols});
                    //  $(this).prop("readonly",true);
                    /*  $id = $(this).prop('id');
                     $write_id = '"'+$id+'"';
                     $(this).before("<a href='javascript:void(0)' class='write-symbol' id='"+$(this).prop('id')+"-write' onclick='writeSymbol(this,"+$write_id+")'>X</a>");
                     */
                    /*$('#state').parent().removeClass('invalid');
                     $('.fielderrors').hide();*/
                }
            });
        }

        cleanFormat = function($type,$html){
            if($html != ""){
                if($type == "currency"){
                    $sign = "$ ";
                }else{
                    $sign = "% ";
                }
                $characters = ['$','%',','];
                $characters.forEach(function($item,$index){
                    $html = $html.replace($item,'');
                });
                $html = Math.round(parseFloat($html));
                $html = $html.toString();
               /* $html = ($html.indexOf('$') > -1 || $html.indexOf('%') > -1)?$html:($sign+$html);*/
//                $html = $sign+$html.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
//                $html = $html.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + $sign;
                if($type == "currency"){
                    //$html = $sign+$html.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    $html = $sign+$html.replace( /(\d)(?=(\d{3})+\.)/g, "$1,");
                }else if($type == 'percentage'){
                    $html = $html.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ;
                    $html = $html + ''+$sign;
                }


            }
            return $html;
        };
        $(document).ready(function(){
            $('td.currency').each(function(){
                $(this).html(cleanFormat('currency',$(this).html()));
                /*$html = $(this).html();*/

                /*if($html != ""){
                    $(this).html('$ '+$html.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                }*/
            });
            $('td.percentage').each(function(){
                $(this).html(cleanFormat('percentage',$(this).html()));
                /*$html = $(this).html();
                if($html != ""){
                    $(this).html('% '+$html.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                }*/
            });
        });
        /**
         * limit number inputs to numeric
         */
        /*$('div.percentage').priceFormat({prefix: '% ', centsLimit: 0});*/
        function numericOnly(){
            $(".numericOnly").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                            // Allow: Ctrl+C
                        (e.keyCode == 67 && e.ctrlKey === true) ||
                            // Allow: Ctrl+X
                        (e.keyCode == 88 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

            return false;
        }

        /** ===========================================================================
         * Scripts for Hidden Fields
         * ============================================================================== **/
        $('.input-select').each(function(){
            if($(this).html() == "Others"){
                $(this).closest('.select-row').siblings('.others-row').show();
            }else if($(this).html() == "Home"){
                $(this).closest('.generated').find('.home-rows').show();
            }else{
                $(this).closest('.select-row').siblings('.others-row').hide();
                $(this).closest('.select-row').siblings('.others-row').find('.input').html('');
            }
        });
        $clearFields = function(e){
            e.find(':input').each(function(){
                $(this).not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
            });
            e.find(':checkbox').each(function(){
                $(this).prop('checked', false);
            });
            e.find(':radio').each(function(){
                $(this).prop('checked', false);
            });
        }

        $rowDisplayInitial = function(e,group,row,value){
            $(row).each(function(){
                //alert($(this).html());
            
                if($(this).data('hidden') == group){
                    if(e.find('.input-radio').html() == value) {
                        $(this).show();
                    }else{
                        $clearFields($(this));
                        $(this).hide();
                    }
                }
            });

        }
        $(".radio-row").each(function(){
            $radio_row = $(this);
            $radio_row.find(".input-radio").each(function(){
                $positive = 'Yes';
                $negative = 'No';
                if($radio_row.data('hidden') == 'benefit_type'){
                    $positive = 'Permanent';
                    $negative = 'Term';
                }
                $group = $radio_row.data('hidden');
                //alert($group+":"+$radio_row.find(".input-radio").html());
                $hidden_row = $(".hidden-row[data-hidden='"+$group+"']");
                if($radio_row.find(".input-radio").html().replace(/\s+/g, '') == $positive){
                    $hidden_row.show();
                }else{
                    $hidden_row.hide();
                }
                
                //$rowDisplayInitial($radio_row,$group,'.hidden-row',$positive);
                $rowDisplayInitial($radio_row,$group,'.alternate-row',$negative);
            });
        });


        var activateInputMask = function(){
            $( ".datepicker" ).datepicker();
            numericOnly();
            var states               = ['Alaska', 'Arkansas', 'California', 'Connecticut', 'Delaware', 'Georga', 'Idaho', 'Indiana', 'Iowa', 'Kentucky',
                'Louisiana', 'Maryland', 'Massachusetts', 'Mississippi', 'Montana', 'Nevada', 'New Hampshire', 'New Jersey', 'North Carolina', 'North Dakota',
                'Ohio', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Dakota', 'Tennessee', 'Utah', 'Vermont', 'Virginia', 'West Virginia'];


            var StatesArray = $.map(statesArray, function (team) { return { value: team, data: { category: 'NBA' } }; });
            $('#state').autocomplete({
                lookup: StatesArray,
                onSelect: function (suggestion) {
                    $('#state').parent().removeClass('invalid');
                    $('.fielderrors').hide();
                }
            });

            autoCompleteSymbols();
            $('input.currency').priceFormat({prefix: '$ ', centsLimit: 0});
            $('input.share-price').priceFormat({prefix: '$ ', centsLimit: 2});
            $('input.percentage').priceFormat({prefix: '% ', centsLimit: 0});
            $('select').change(
                function(){
                    if($(this).val() == 'Others'){
                        $(this).closest('.select-row').siblings('.others-row').show('fast');
                    }else if($(this).val() == "Home"){
                        $(this).closest('.generated').find('.home-rows').show();
                    }else{
                        $(this).closest('.select-row').siblings('.others-row').hide('fast');
                        $(this).closest('.select-row').siblings('.others-row').find('input').val('');
                    }
                }
            );
            /** ===========================================================================
             * Scripts for Hidden Fields
             * ============================================================================== **/
            $rowDisplayChange = function(e,group,row,value){
                $(row).each(function(){
                    if($(this).data('hidden') == group){
                        if(e.val() == value){
                            $(this).show('fast');
                        }else{
                            $clearFields($(this));
                            $(this).hide('fast');
                        }
                    }
                });
            }
            $('input[type="radio"]').change(function(){
                $radio = $(this);
                $positive = 'Yes';
                $negative = 'No';
                if($radio.prop('name') == 'benefit_type'){
                    $positive = 'Permanent';
                    $negative = 'Term';
                }
                $group = $(this).closest('.radio-row').data('hidden');
                $rowDisplayChange($radio,$group,'.hidden-row',$positive);
                $rowDisplayChange($radio,$group,'.alternate-row',$negative);
            });

        }




        /** ===================================================================
         * Variables
         ======================================================================*/
        var $route = "{{ route('meta_update',$user->id) }}";
        var $field_history = [];
        var $history_count = 0;
        var $children_count = "{{ isset($meta->children)?count($meta->children):0 }}";
        var $asset_count = "{{ isset($meta->assets)?$item_ctr:0 }}";
        var $liability_count = "{{ isset($meta->liabilities)?count($meta->liabilities):0 }}";
        var $expense_count = "{{ isset($meta->expenses)?count($meta->expenses):0 }}";
        var $pension_count = "{{ isset($meta->pension)?count($meta->pension):0 }}";
        var $insurance_count = "{{ isset($meta->life_insurance)?count($meta->life_insurance):0 }}";
        var $symbols_html = "";
        var $symbol_count = '{{ $count_symbols }}';
        var $check_symbols = "{{ route('check_symbols')  }}";

        var $children = [];
        @if(isset($meta->children))
            @foreach($meta->children as $number => $item)
                $children['{{ $number }}'] = [];
                $children['{{ $number }}']['name'] = "{{ $item->name }}";
                $children['{{ $number }}']['age'] = "{{ $item->age }}";
            @endforeach
        @endif



        var $assets = [];
    
        var $liabilities = [];
        @if(isset($meta->liabilities))
            @foreach($meta->liabilities as $number => $item)
                $liabilities['{{ $number }}'] = [];
                $liabilities['{{ $number }}']['liability_type'] = "{{ $item->liability_type or "" }}";
                $liabilities['{{ $number }}']['owner_debtor'] = "{{ $item->owner_debtor or "" }}";
                $liabilities['{{ $number }}']['bank'] = "{{ $item->bank or ""}}";
                $liabilities['{{ $number }}']['balance'] = "{{ $item->balance or "" }}";
                $liabilities['{{ $number }}']['monthly_payment'] = "{{ $item->monthly_payment or "" }}";
                $liabilities['{{ $number }}']['interest_rate'] = "{{ $item->interest_rate }}";
                $liabilities['{{ $number }}']['loan_term_start'] = "{{ $item->loan_term_start or ""}}";
                $liabilities['{{ $number }}']['loan_term_end'] = "{{ $item->loan_term_end or "" }}";
                $liabilities['{{ $number }}']['loan_date'] = "{{ $item->loan_date or "" }}";
        @endforeach
        @endif
        $insurance = [];

        var $expenses = [];
        @if(isset($meta->expenses) && is_array($meta->expenses))
            @foreach($meta->expenses as $number => $item)
                $expenses['{{ $number }}'] = [];
                $expenses['{{ $number }}']['expense_type'] = "{{ $item->expense_type or "" }}";
                $expenses['{{ $number }}']['expense_amount'] = "{{ $item->expense_amount or "" }}";
                $expenses['{{ $number }}']['timeframe_start'] = "{{ $item->timeframe_start or ""}}";
                $expenses['{{ $number }}']['timeframe_end'] = "{{ $item->timeframe_end or "" }}";
            @endforeach
        @endif

        var $pensions = [];
            @if(isset($meta->pension) && is_array($meta->pension))
                @foreach($meta->pension as $number => $item)
                    $pensions['{{ $number }}'] = [];
                    $pensions['{{ $number }}']['type'] = "{{ $item->type or "" }}";
                    $pensions['{{ $number }}']['does_it_have_a_cost_of_living_adjustment'] = "{{ $item->does_it_have_a_cost_of_living_adjustment or ""}}";
                    $pensions['{{ $number }}']['projected_monthly_pension_benefit'] = "{{ $item->projected_monthly_pension_benefit or "" }}";
                    $pensions['{{ $number }}']['survivor_benefit'] = "{{ $item->survivor_benefit or "" }}";
            @endforeach
        @endif

$(".meta_save").closest('span').hide();
        $(".meta_update").click(
            function(){
             $save = $(this);
              $(this).closest("form").find(".delete-link").show();
          /*  jQuery.validator.addMethod("symbols", function(value, element) {
                    // allow any non-whitespace characters as the host part
                $option = this.optional( element );
                $.post($check_symbols,{symbols: value,_token:$token}).done(function($data){
                    if($data != 'true'){
                        return $option;
                    }else{
                        return true;
                    }
                });

                }, 'fsdfsdfsdfsdf');*/
            $(this).closest("form").validate();

//             $(this).closest("form").validate({
//                 submitHandler: function(form){
//                     var $post = $save.closest("form");
//                     var form_route = $post.prop('action');
//                     var formid     = $post.prop('id');
// //                        console.log(formid);
//                     console.log(formid);
//                     var post_data = $post.serialize();
//                     $.post(form_route, post_data, function(data){
//                         var $id = $post.find('.cancel').prop('id');
//                         $post.find('.table').find('tbody').each(function(){
//                             $(this).find('.delete-link').each(function(){ $(this).remove() });
//                             $(this).find('.add').each(function(){ $(this).remove() });
//                          /** =====================================================================================================
//                           *  puts checkbox values in a separate variable so that it can increment throughout all checkbox input
//                          ====================================================================================================== **/
//                              $symbol_list = "";
//                              $checkbox_html = "";
//                              $radio_value = "";
//                              $(this).find('input').each(
//                                  function() {
//                                      $value = $(this).val();
//                                      if($(this).prop('type')=='radio'){
//                                          $value = $("input[name='"+$(this).prop('name')+"']:checked").val();
//                                          if(!$("input[name='"+$(this).prop('name')+"']").is(':checked')){
//                                              $value = "";
//                                          }
//                                      }
//                                      if($(this).prop('type')=='checkbox'){
//                                          $value = "";
//                                          $("input[name='"+$(this).prop('name')+"']:checked").each(
//                                              function(){
//                                                  $value += "<span data-field="+$(this).val()+">"+$(this).val()+"</span><br/>";
//                                              }
//                                          );



//                                      }
//                                      $(this).closest('td').html($value);
//                                  }
//                              );
//                             $(this).find('select').each(
//                                  function() {
//                                      $value = $(this).val();
//                                      if($(this).closest("td").hasClass('funds')){
//                                          $value = $value.replace('#','');
//                                      }
//                                      $(this).closest('td').html($value);
//                                      console.log($value);
//                                  }
//                             );
//                             $(this).find('textarea').each(
//                                 function() {
//                                     $value = $(this).val();
//                                     $(this).closest('td').html($value);
//                             });
//                             $.each(data, function(i, obj) {
//                              //use obj.id and obj.name here, for example:
//                                 $('#'+ obj.key).text(obj.value);
//                             });

                       
//                             $('.delete-symbol').hide();
//                             $('.base-symbol-btn').hide();
//                             $post.find('.meta_save').closest('span').siblings('.meta_update').show();
//                             $post.find('.meta_save').closest('span').hide();
//                         });

//                              // $post.closest('form.meta_form').find('.table').find('thead').after($field_history[$id]);
                         
//                     });
//                     return false;
//                 }
//             });


            /**=======================================
             * Children Table
             ====================================* */
                $field_history[$history_count] = '';
                $(this).closest('.table').find('thead').nextAll().each(function(){$field_history[$history_count] += $(this).wrap('<div/>').parent().html();});
                /** =================================
                 * Unwraps table div
                 ====================================**/
                $(this).closest('.table').find('thead').nextAll().each(function(){$(this).find('tbody').unwrap() });
                /** ============================================================
                 * Adding a cancel button for currently existing elements
                ================================================================**/
                if($(this).closest('.table').hasClass('children')) {
                    var $child_count = 0;
                    $('.child-name').each(function(){
                        $(this).html("<a id='child_"+$child_count+"' href='javascript:void(0);' onclick='delete_child("+$child_count+");' class='delete-link delete-child'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Name:");
                        $child_count++;
                    });
                }
                if($(this).closest('.table').hasClass('assets')) {
                    var $asset_delete_count = 0;
                    $('.asset-type-column').each(function(){
                        $(this).html("<a id='asset_"+$asset_delete_count+"' href='javascript:void(0);' onclick='delete_asset($(this));' class='delete-link delete-asset'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:");
                        $asset_delete_count++;
                    });


                    $('.delete-symbol').show();
                }

                if($(this).closest('.table').hasClass('liabilities')) {
                    var $liability_delete_count = 0;
                    $('.liability-type-column').each(function(){
                        $(this).html("<a id='liability_"+$liability_delete_count+"' href='javascript:void(0);' onclick='delete_liability("+$liability_delete_count+");' class='delete-link delete-liability'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:");
                        $liability_delete_count++;
                    });
                }
                if($(this).closest('.table').hasClass('life_insurance')) {
                    var $life_insurance_delete_count = 1;
                    $('.life_insurance-type-column').each(function(){
                        $(this).html("<a id='life_insurance_"+$life_insurance_delete_count+"' href='javascript:void(0);' onclick='delete_insurance($(this));' class='delete-link delete-insurance'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:");
                        $life_insurance_delete_count++;
                    });
                }
                if($(this).closest('.table').hasClass('pensions')) {
                    var $pension_delete_count = 0;
                    $('.pension-type-column').each(function(){
                        $(this).html("<a id='pension_"+$pension_delete_count+"' href='javascript:void(0);' onclick='delete_pension("+$pension_delete_count+");' class='delete-link delete-pension'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:");
                        $pension_delete_count++;
                    });
                }

                if($(this).closest('.table').hasClass('expenses')) {
                    var $expense_delete_count = 0;
                    $('.expense-type-column').each(function(){
                        $(this).html("<a id='expense_"+$expense_delete_count+"' href='javascript:void(0);' onclick='delete_expense("+$expense_delete_count+");' class='delete-link delete-expense'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:");
                        $expense_delete_count++;
                    });
                }

                    /**==============================================================
                     * ADD Button
                     * generates an 'add' button for meta data with generatable fields
                     ==================================================================**/
                    $generators = ['children','assets','liabilities','expenses','pensions', 'life_insurance'];
                    $element = $(this);
                    $.each($generators, function($index, $value){
                            if($value == 'life_insurance'){
                                $upper_value = 'Insurance';
                            }else{
                                $upper_value = $value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                    return letter.toUpperCase();
                                });
                            }
                        if($element.closest('.'+$value).find('.add').length == 0){
                            $element.closest('.'+$value).find('.tbody-main').prepend(
                                    "<tr class='add'>" +
                                    "<td colspan='2'>" +
                                    "<a class='btn btn-primary add-"+$value+"' href='javascript:void(0)' onclick='javascript:add_"+$value+"()'>Add "+$upper_value+"</a>" +
                                    "</td>" +
                                    "</tr>"
                            )
                        }

                        if($value == 'assets'){
                            $rowid = $element.closest('.'+$value).find('.symbol-base').data('rowid');
                            $element.closest('.'+$value).find('.base-symbol-btn').show()
                        }


                        }
                    );
                /** =====================================
                 * Inputs
                 ====================================== **/
                $(this).closest('.table').find('.input').each(
                    function(){
                        $value = $.trim($(this).html());
                        /** ==================================================================================================================
                         * Radio Inputs
                         * NOTE: radio inputs for generated fields will use id instead of data fields because of JS can't get brackets in id
                        ================================================================================================================ **/
                        if($(this).hasClass('input-radio')){
                            $id = $(this).data('field');
                            if($(this).hasClass('asset_own') || $(this).closest('tbody').hasClass('pension') || $(this).closest('tbody').hasClass('children') || $(this).hasClass('asset') || $(this).hasClass('mortgage')){
                                $id = $(this).prop('id');
                            }
                            if($(this).hasClass('benefit_type') ){
                                $(this).html(
                                    "<label for='benefit_type_permanent'><input id='benefit_type_permanent' name="+$(this).data('field')+" type='radio' value='Permanent' class='benefit_type_choices'> Permanent</label>&nbsp;"+
                                    "<label for='benefit_type_term'><input id='benefit_type_term' name="+$(this).data('field')+" type='radio' value='Term' class='benefit_type_choices'> Term</label>"
                                );
                            }else if($(this).hasClass('ltc_rider')){
                                $(this).html(
                                        "<label for='ltc_rider_1'><input id='ltc_rider_1' name="+$(this).data('field')+" type='radio' value='Yes, I have a Rider' class='ltc_rider_choices'> Yes, I have a Rider</label>&nbsp;"+
                                        "<label for='ltc_rider_2'><input id='ltc_rider_2' name="+$(this).data('field')+" type='radio' value='Yes, I have Accelerated Benefit' class='benefit_type_choices'> Yes, I have Accelerated Benefit</label>"+
                                        "<label for='ltc_rider_3'><input id='ltc_rider_3' name="+$(this).data('field')+" type='radio' value='No/I don\'t know' class='benefit_type_choices'> No/I don't know</label>"
                                );
                            }
                            else if($(this).hasClass('type')){
                                $(this).html(
                                    "<label for="+$id+"_public><input id="+$id+"_public name='"+$(this).data('field')+"' type='radio' value='Public'> Public</label>&nbsp;"+
                                    "<label for="+$id+"_private><input id="+$id+"_private name='"+$(this).data('field')+"' type='radio' value='Private'> Private</label>"
                                );
                            }else if($(this).hasClass('withdrawal')){
                                $(this).html(
                                        "<label for="+$id+"_less_than_5_years><input id='"+$id+"_less_than_5_years' name='"+$(this).data('field')+"' type='radio' value='<5 Years'> <5 Years</label>&nbsp;"+
                                        "<label for="+$id+"_5_10_years><input id='"+$id+"_5_10_years' name='"+$(this).data('field')+"' type='radio' value='5-10 Years'> 5-10 Years</label>&nbsp;"+
                                        "<label for="+$id+"_10_20_years><input id='"+$id+"_10_20_years' name='"+$(this).data('field')+"' type='radio' value='10-20 Years'> 10-20 Years</label>&nbsp;"+
                                        "<label for="+$id+"_20_plus_years><input id='"+$id+"_20_plus_years' name='"+$(this).data('field')+"' type='radio' value='20+ Years'> 20+ Years</label>"
                                );
                            }else if($(this).hasClass('asset_own') || $(this).hasClass('pension_own')){
                                $(this).html(
                                        "<label for='"+$id+"-mine'><input id='"+$id+"-mine' name='"+$(this).data('field')+"' type='radio' value='mine'> Mine</label>&nbsp;"+
                                        "<label for='"+$id+"-spouse'><input id='"+$id+"-spouse' name='"+$(this).data('field')+"' type='radio' value='spouse'> Spouse</label>"
                                );
                            }
                            else if($(this).data('field') == 'would_you_rather'){
                                $(this).html(
                                    "<label for="+$(this).data('field')+"_leave_money_to_heirs"+"><input id="+$(this).data('field')+"_leave_money_to_heirs"+" name="+$(this).data('field')+" type='radio' value='Leave largest amount of money to heirs'> Leave largest amount of money to heirs</label>"+
                                    "<label for="+$(this).data('field')+"_retire_as_early_as_possible"+"><input id="+$(this).data('field')+"_retire_as_early_as_possible"+" name="+$(this).data('field')+" type='radio' value='Retire as early as possible'> Retire as early as possible</label>"+
                                    "<label for="+$(this).data('field')+"_maximize_retirement_income"+"><input id="+$(this).data('field')+"_maximize_retirement_income"+" name="+$(this).data('field')+" type='radio' value='Maximize retirement income'> Maximize retirement income</label>"

                                );
                            }else if($(this).hasClass('mortgage')){

                                $(this).html(
                                        '<label for="'+$id+'"_yes"><input id="'+$id+'_yes" class="mortgage_choices" name="'+$(this).data('field')+'" type="radio" value="Yes"> Yes</label>&nbsp;'+
                                        '<label for="'+$id+'_no"><input id="'+$id+'_no" class="mortgage_choices" name="'+$(this).data('field')+'" type="radio" value="No"> No</label>'
                                );
                            }else if($(this).hasClass('sex')){
                                $(this).html(
                                        '<label for="'+$id+'_male"><input id="'+$id+'_male" class="sex" name="'+$(this).data('field')+'" type="radio" value="Male"> Male</label>&nbsp;'+
                                        '<label for="'+$id+'_female"><input id="'+$id+'_female" class="sex" name="'+$(this).data('field')+'" type="radio" value="Female"> Female</label>'
                                );
                            }else{
                                $(this).html(
                                    "<label for="+$id+"_yes"+"><input id="+$id+"_yes"+" name="+$(this).data('field')+" type='radio' value='Yes'> Yes</label>&nbsp;"+
                                    "<label for="+$id+"_no"+"><input id="+$id+"_no"+" name="+$(this).data('field')+" type='radio' value='No'> No</label>"
                                );
                            }
                            if($value=='Yes'){
                                $("#"+$id+"_yes").prop('checked',true);
                                $("#"+$id+"_no").prop('checked',false);
                            }else if($value=='No'){
                                $("#"+$id+"_yes").prop('checked',false);
                                $("#"+$id+"_no").prop('checked',true);
                            }


                            if($value=='mine'){
                                $("#"+$id+"-mine").prop('checked',true);
                                $("#"+$id+"-spouse").prop('checked',false);
                            }else if($value=='spouse'){
                                $("#"+$id+"-mine").prop('checked',false);
                                $("#"+$id+"-spouse").prop('checked',true);
                            }

                            if($value=='Permanent'){
                                $("#benefit_type_permanent").prop('checked',true);
                                $("#benefit_type_term").prop('checked',false);
                            }else if($value=='Term'){
                                $("#benefit_type_permanent").prop('checked',false);
                                $("#benefit_type_term").prop('checked',true);
                            }

                            if($value=='Male'){
                                $("#"+$id+"_male").prop('checked',true);
                                $("#"+$id+"_female").prop('checked',false);
                            }else if($value=='Female'){
                                $("#"+$id+"_male").prop('checked',false);
                                $("#"+$id+"_female").prop('checked',true);
                            }

                            if($value == 'Yes, I have a Rider'){
                                $('#ltc_rider_1').prop('checked', true);
                                $('#ltc_rider_2').prop('checked', false);
                                $('#ltc_rider_3').prop('checked', false);
                            }else if($value == 'Yes, I have Accelerated Benefit'){
                                $('#ltc_rider_1').prop('checked', false);
                                $('#ltc_rider_2').prop('checked', true);
                                $('#ltc_rider_3').prop('checked', false);
                            }else{
                                $('#ltc_rider_1').prop('checked', false);
                                $('#ltc_rider_2').prop('checked', false);
                                $('#ltc_rider_3').prop('checked', true);
                            }

                            if($value=='Private'){
                                $("#"+$id+"_private").prop('checked',true);
                                $("#"+$id+"_public").prop('checked',false);
                            }else if($value=='Public'){
                                $("#"+$id+"_private").prop('checked',false);
                                $("#"+$id+"_public").prop('checked',true);
                            }

                            if($value=='<5 Years'){
                                $("#"+$id+"_less_than_5_years").prop('checked',true);
                                $("#"+$id+"_5_10_years").prop('checked',false);
                                $("#"+$id+"_10_20_years").prop('checked',false);
                                $("#"+$id+"_20_plus_years").prop('checked',false);
                            }else if($value=='5-10 Years'){
                                $("#"+$id+"_less_than_5_years").prop('checked',false);
                                $("#"+$id+"_5_10_years").prop('checked',true);
                                $("#"+$id+"_10_20_years").prop('checked',false);
                                $("#"+$id+"_20_plus_years").prop('checked',false);
                            }else if($value=='10-20 Years'){
                                $("#"+$id+"_less_than_5_years").prop('checked',false);
                                $("#"+$id+"_5_10_years").prop('checked',false);
                                $("#"+$id+"_10_20_years").prop('checked',true);
                                $("#"+$id+"_20_plus_years").prop('checked',false);
                            }else if($value=='20+ Years'){
                                $("#"+$id+"_less_than_5_years").prop('checked',false);
                                $("#"+$id+"_5_10_years").prop('checked',false);
                                $("#"+$id+"_10_20_years").prop('checked',false);
                                $("#"+$id+"_20_plus_years").prop('checked',true);
                            }

                            if($value=='Leave largest amount of money to heirs'){
                                $("#"+$(this).data('field')+"_leave_money_to_heirs").prop('checked',true);
                                $("#"+$(this).data('field')+"_retire_as_early_as_possible").prop('checked',false);
                                $("#"+$(this).data('field')+"_maximize_retirement_income").prop('checked',false);
                            }else if($value=='Retire as early as possible'){
                                $("#"+$(this).data('field')+"would_you_rather_leave_money_to_heirs").prop('checked',false);
                                $("#"+$(this).data('field')+"_retire_as_early_as_possible").prop('checked',true);
                                $("#"+$(this).data('field')+"_maximize_retirement_income").prop('checked',false);
                            }else if($value=='Maximize retirement income'){
                                $("#"+$(this).data('field')+"_leave_money_to_heirs").prop('checked',false);
                                $("#"+$(this).data('field')+"_retire_as_early_as_possible").prop('checked',false);
                                $("#"+$(this).data('field')+"_maximize_retirement_income").prop('checked',true);
                            }
                        }
                        /** =============================================
                         * Select inputs
                         ================================================ **/
                        else if($(this).hasClass('input-select')){
                            if($(this).data('field')=='how_long_has_it_been_since_you_renewed_it'){
                                $(this).html(
                                        "<select id="+$(this).data('field')+" name="+$(this).data('field')+" class='form-control'>"+
                                        "<option value=''> Select </option>"+
                                        "<option value='Within last 12 months'>Within last 12 months</option>"+
                                        "<option value='1-3 years ago'>1-3 years ago</option>"+
                                        "<option value='More than 3 years ago'>More than 3 years ago</option>"+
                                        "</select>"
                                );
                            }
                            if($(this).data('field')=='expense'){
                                $(this).html(
                                    "<select id="+$(this).data('field')+" name="+$(this).data('field')+" class='form-control'>"+
                                        "<option value='0' disabled> - Select - </option>"+
                                        "<option value='Home'>Home</option>"+
                                        "<option value='Home Remodel'>Home Remodel</option>"+
                                        "<option value='Car'>Car</option>"+
                                        "<option value='Vacation'>Vacation</option>"+
                                        "<option value='Second Home'>Second Home</option>"+
                                        "<option value='Others'>Others</option>"+
                                    "</select>"
                                );
                            }
                            if($(this).data('field')=='who_did_your_taxes_last_year'){
                                $(this).html(
                                    "<select class='form-control' id="+$(this).data('field')+" name="+$(this).data('field')+" >"+
                                    "<option value='0' disabled>- Select -</option>"+
                                    "<option value='Turbo Tax'>Turbo Tax</option>"+
                                    "<option value='CPA or enrolled Agent'>CPA or enrolled Agent</option>"+
                                    "<option value='I did my own taxes'>I did my own taxes</option>"+
                                    "</select>"
                                );
                            }
                            if($(this).hasClass('asset-type')){
                                //alert($(this).data('field'));
                                $(this).html(
                                        "<select name='"+$(this).data('field')+"' id='"+$(this).prop("id")+"' onchange='assets_fields(this.value, this.id)' class='type-dropdown required form-control'>"+
                                        "<option value='0' disabled>Select type of asset</option>"+
                                        "<option value='IRA'>IRA</option>"+
                                        "<option value='Home'>Home</option>"+
                                        "<option value='Rental'>Rental Properties</option>"+
                                        "<option value='401k'>401(k)</option>"+
                                        "<option value='403b'>403(b)</option>"+
                                        "<option value='Brokerage'>Brokerage Acct.</option>"+
                                        "<option value='Annuity'>Annuity</option>"+
                                        "<option value='529Plan'>529 Plan</option>"+
                                        "<option value='Coverdell'>Coverdell</option>"+
                                        "<option value='UTMA'>UTMA</option>"+
                                        "<option value='UGMA'>UGMA</option>"+
                                        "<option value='Simple'>Simple</option>"+
                                        "<option value='SEP'>SEP</option>"+
                                        "<option value='Roth'>Roth</option>"+
                                        "<option value='CDs'>CDs</option>"+
                                        "<option value='Savings'>Savings</option>"+
                                        "<option value='Checking'>Checking</option>"+
                                        "<option value='Business'>Business</option>"+
//                                        "<option value='Others'>Others</option>"+
                                        "</select>"
                                );

                                //$("#"+$(this).prop("id")).attr("onchange",'assets_fields(this.value, $(this).data("count"))');
                            }
                            if($(this).hasClass('funds')){
                                $funds_html = "<select name='"+$(this).data('field')+"' id='"+$(this).data('field')+"' class='type-dropdown required form-control'>";
                                $funds_html += "<option value=''>Not investing in funds</option>";
                                $.each($symbols,function($key, $value) {
                                    $funds_html += "<option value='"+$value+"'>"+$value.replace('#','')+"</option>";
                                });
                                $funds_html += "</select>";
                                $(this).html($funds_html)
                            }
                            if($(this).hasClass('liability-type')){
                                $(this).html(
                                    "<select name='"+$(this).data('field')+"' id='"+$(this).data('field')+"' class='type-dropdown required form-control'>"+
                                    "<option value='0' disabled>Select type of liability</option>"+
                                    "<option value='Mortgage'>Mortgage</option>"+
                                    "<option value='Credit Card'>Credit Card</option>"+
                                    "<option value='Student Loans'>Student Loans</option>"+
                                    "<option value='Auto Loan'>Auto Loan</option>"+
                                    "<option value='Business Loan'>Business Loan</option>"+
                                    "<option value='Personal Loan'>Personal Loan</option>"+
                                    "<option value='HELOC'>HELOC</option>"+
                                    "<option value='Others'>Others</option>"+
                                    "</select>"
                                );
                            }
                            if($(this).hasClass('expense-type')){
                                $(this).html(
                                    "<select name='"+$(this).data('field')+"' id='"+$(this).data('field')+"' class='type-dropdown required form-control'>"+
                                    "<option value='0' disabled>Select type of expense</option>"+
                                    "<option value='Home'>Home</option>"+
                                    "<option value='Home Remodel'>Home Remodel</option>"+
                                    "<option value='Car'>Car</option>"+
                                    "<option value='Vacation'>Vacation</option>"+
                                    "<option value='Second Home'>Second Home</option>"+
                                    "<option value='Others'>Others</option>"+
                                    "</select>"
                                );
                            }
                        }
                        /** =============================================
                         * Checkbox inputs
                         ================================================ **/
                        else if($(this).hasClass('input-checkbox')){
                            if($(this).data('field')=='investments'){
                                $list = ['Stock','Mutual Funds','Effs','Bonds','Options','Real Estate','Commodities','Futures'];
                                $invest_ = "";
                                $investments = [];
                                $(this).find('span').each(function(){
                                    $investments.push($(this).data('field'));
                                });
                                $.each($list,function($key, $value){
                                    if($.inArray($value, $investments) > -1){
                                        $invest_ += "<label for='"+$value+"'><input type='checkbox' name='investments[]' id='"+$value+"' value='"+$value+"' checked> "+$value+"</label><br/>";
                                    }else{
                                        $invest_ += "<label for='"+$value+"'><input type='checkbox' name='investments[]' id='"+$value+"' value='"+$value+"'> "+$value+"</label><br/>";
                                    }
                                });

                                $(this).html($invest_);
                            }
                            if($(this).data('field')=='loans'){
                                $checked = "";
                                if($(this).html() == "Yes"){
                                    $checked = "checked";
                                }
                                $loan = "<label for='loans_"+$(this).data('count')+"_Yes'><input type='checkbox' name='life_insurance["+$(this).data('count')+"][loans]' id='loans_"+$(this).data('count')+"_Yes' value='Yes' "+$checked+"> Yes?</label>";
                            
                                $(this).html($loan);
                            }
                        }
                        else{
                            /** =====================================================================================================================
                             * (for generated fields)check if element has a data-field property, since ajax can't read ids with brackets
                             * return defaults if not
                             ==================================================================================================================== **/
                            $(this).html("<input class='form-control' id='"+$(this).data('field')+"' name='"+$(this).data('field')+"' value='"+$value+"'>");
                        }

                        if($(this).hasClass('numericOnly')) {
                            $(this).find('input').addClass('numericOnly');
                        }

                        if($(this).hasClass('datepicker')) {
                            $(this).find('input').addClass('datepicker');
                        }

                        if($(this).hasClass('currency')) {
                            $(this).find('input').addClass('currency');
                        }

                        if($(this).hasClass('percentage')) {
                            $(this).find('input').addClass('percentage');
                        }
                        if($(this).hasClass('symbols')) {
                            $(this).find('input').addClass('symbols');
                        }
                        if($(this).hasClass('share-price')) {
                            $(this).find('input').addClass('share-price');
                        }

                    $(this).find('select').each(
                        function(){
                            $(this).find('option').each(function(){
                                if($value == $(this).val()){
                                    $(this).prop('selected',true);
                                }
                            });
                        }
                    );

                    if($(this).hasClass('required')){
                       $(this).find('input').prop('required',true);
                    }


                    $('input[name="do_you_have_life_insurance"]').change(function(){
                        var val = $('input[name="do_you_have_life_insurance"]:checked').val();

                        if(val == 'Yes'){
                            $(this).parent().parent().parent().parent().parent().find('.tbody-main').show();
                            $(this).parent().parent().parent().parent().parent().find('.generated').show();
                        }else{
                            $(this).parent().parent().parent().parent().parent().find('.tbody-main').hide();
                            $(this).parent().parent().parent().parent().parent().find('.generated').hide();

                        }
                    })
                }
            );
                $(this).hide();
                $(this).siblings('span').show();
                $(this).siblings('span').find('.cancel').prop('id',+$history_count);
                $history_count++;
//                saveMeta();
                autoCompleteSymbols();
                activateInputMask();
                //assetMortGageSelection();
            }
        );

        /** ==================================================================================================
         * Cancel saving
         ============================================================================================== **/
        $(".cancel").click(
            function(){
                /*$table_html = '';
                 $.each($field_history[$(this).prop('id')],function($key,$value){ $table_html += $value; });
                console.log($table_html);*/
                $(this).closest('.table').find('thead').nextAll().each(function(){ $(this).remove(); });
                $(this).closest('.table').find('thead').after($field_history[$(this).prop('id')]);
                $(this).closest('span').siblings('.meta_update').show();
                $(this).closest('span').hide();
                $('.delete-symbol').hide();
                $('.delete-link').hide();
            }
        );

        /** =======================================================
         * Add Children functionality
         ================================================================= **/
        function add_children(){
            $children_count++;
            $.post($client_template,{type: "children",children_count:$children_count,_token:$token}, function($data){
                $('.add-children').closest('tbody').siblings('.stop-children').before($data);
                $('#children-'+$children_count+'-tbody').show('normal');
                $(window).scrollTop($('#children-'+$children_count+'-name input').focus().position().top);
                activateInputMask();
            });
           
        }

        /** =======================================================
         * Add Pension functionality
         ================================================================= **/
        function add_pensions(){
            $pension_count++;
            $.post($client_template,{type: "pension",pension_count:$pension_count,_token:$token}, function($data){
                $('.add-pensions').closest('tbody').siblings('.stop-pensions').before($data);
                $('#pensions-'+$pension_count+'-tbody').show('normal');
                $(window).scrollTop($('#pensions-'+$pension_count+'-type input').focus().position().top);
                activateInputMask();
            });
        }

        /** =======================================================
         * Add Expenses functionality
         ================================================================= **/
        function add_expenses(){
            $expense_count++;
            $.post($client_template,{type: "expense",expense_count:$expense_count,_token:$token}, function($data){
                $('.add-expenses').closest('tbody').siblings('.stop-expenses').before($data); 
                $('#expenses-'+$expense_count+'-tbody').show('normal');
                $(window).scrollTop($('#expenses-'+$expense_count+'-type select').focus().position().top);
                activateInputMask();
            });
        }

        /** ==========================================
         * Add Asset functionality
         ====================================== **/
        function add_assets(){
            $asset_count++;
             $.post($client_template,{type: "asset",asset_count:$asset_count,_token:$token}, function($data){
                $('.add-assets').closest('tbody').siblings('.start-assets').after($data);
                $('#asset-container-'+$asset_count).show('normal');
                $(window).scrollTop($('#assets-'+$asset_count+'-type').focus().position().top);
                activateInputMask();
                assets_fields('', $asset_count);
            });
        }


        function assets_fields($type, $asset_id){
            //alert($('#assets-field-'+$asset_count).html());
            $('.'+$asset_id+"_fields").remove();
             $.post($client_template,{type:"asset_field",asset_type: $type,asset_count:$asset_count,_token:$token}, function($data){
                $('#asset-'+$asset_count+"-own").after($data);
                activateInputMask();
                //assetMortGageSelection();
            });
        }

        function assetMortGageSelection(){
//            console.log('mort');
            $('.mortgage_choices').change(function(){
//                console.log('Mortgage selection');
                var val = $('.mortgage_choices:checked').val();
                if(val == 'Yes'){
                    if($(".liabilities").find('.add-liabilities').length == 0){
                        $( ".liabilities .meta_update" ).on( "click", function( ) {
                            add_liabilities('Mortgage');
                        });
                        $('.liabilities').find('.meta_update').trigger('click');
                    }else{
                        add_liabilities('Mortgage');
                    }


                }
            });
        }

        /** ==================================================
         * Add Liabilities functionality
         ================================================== **/
        function add_liabilities( $type ){
            $liability_count++;
            $selection = ['Mortgage', 'Credit Card', 'Student Loans', 'Auto Loan', 'Business Loan', 'HELOC', 'Others'];
            
            $.post($client_template,{type: "liability",selection:$selection,liability_count:$liability_count,_token:$token}, function($data){
                $('.add-liabilities').closest('tbody').siblings('.stop-liabilities').before($data);
                $('#liability-container-'+$liability_count).show('normal');
                $(window).scrollTop($('#liabilities-'+$liability_count+'-liability_type').focus().position().top);
                activateInputMask();
            });
        }


        var insuranceTerm = function(e){
            if(e.value == "Permanent"){
                $('#'+e.id).closest('.generated').find('.insurance-duration').hide('normal');
            }else{
                $('#'+e.id).closest('.generated').find('.insurance-duration').show('normal');
            }
        }
        function add_life_insurance(){
            $insurance_count++;
            $.post($client_template,{type: "life_insurance",insurance_count:$insurance_count,_token:$token}, function($data){
                $('.add-life_insurance').closest('tbody').siblings('.stop-insurance').before($data);
                $('#life-insurance-container-'+$insurance_count).show('normal');
                activateInputMask();
                
            });
        
        }


        /** ======================================================
         * delete child,asset,liability, pension
         ====================================================== **/
        function delete_child(e){
            $("#child_"+e).closest('tbody').fadeOut("normal", function() {
                $(this).remove();
            });
            //$children_count--;
        }
        function delete_expense(e){
            $("#expense_"+e).closest('tbody').fadeOut("normal", function() {
                $(this).remove();
            });
            //$expense_count--;
        }
        function delete_asset(e){
            e.closest('tbody').fadeOut("normal", function() {
                $(this).remove();
            });
            // $("#asset-container-"+e).fadeOut("normal", function() {
            //     $(this).remove();
            // });
            // $("#assets-fields-"+e).fadeOut("normal", function() {
            //     $(this).remove();
            // });
// $(".asset_"+e).closest('tbody').fadeOut("normal", function() {
//            $(this).remove();
//        });
            //$asset_count--;
        }

        function delete_liability(e){
            $("#liability_"+e).closest('tbody').fadeOut("normal", function() {
                $(this).remove();
            });
            //$liability_count--;
        }

        function delete_pension(e){
            $("#pension_"+e).closest('tbody').fadeOut("normal", function() {
                $(this).remove();
            });
            //$pension_count--;
        }


        function delete_insurance(e){
            e.closest("tbody.generated").fadeOut("normal", function() {
                $(this).remove();
            });
        }

        
        /**======================================================
         * Add Symbols
         *=======================================================*/
        
         function addSymbol(e){
            $add_symbol = $("tr#base-symbol-"+e);
            $.post($client_template,{type: "symbol",symbol_count:$symbol_count,e:e,_token:$token}, function($data){
                $add_symbol.before($data);
                $add_symbol.find(".symbol-row-"+ e).last().show('fast');
                $(window).scrollTop($('#assets-'+e+'-symbols-'+$symbol_count+'-symbol').focus().position().top);
                $symbol_count++;
                activateInputMask();
            });
    
         }
        /**======================================================
         * Delete Symbols
         *=======================================================*/
         function deleteSymbol(e,symbol_count){
            $symbol = $(".symbol-row-"+e+"-"+symbol_count);
            $symbol.hide("fast", function(){ $symbol.remove()});

        };

    /**
     * save the form
     */

    </script>
@stop