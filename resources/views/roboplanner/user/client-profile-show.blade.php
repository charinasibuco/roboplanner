@extends('roboplanner.layouts.template')
@section('title', $user->full_name . ' Profile')
@section('styles')
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
                                                <th colspan="2"><i class="fa fa-sliders" aria-hidden="true"></i> State Slide</th>
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
                                                <td class="input input-select" data-field="how_long_has_it_been_since_you_renewed_it">{{ $meta->how_long_has_it_been_since_you_renewed_it or 'N/A' }}</td>

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
                                                <th colspan="2"><i class="fa fa-stethoscope" aria-hidden="true"></i> Risk Management</th>
                                            </tr>
                                            </thead>
                                            <tbody class="radio-row life-insurance" data-hidden="life-insurance">
                                                <tr>
                                                    <td>Do you have life insurance?</td>
                                                    <td class="input input-radio" data-field="do_you_have_life_insurance">{{ $meta->do_you_have_life_insurance or 'No' }}</td>
                                                </tr>
                                            </tbody>
                                            <tbody class='tbody-main hidden-row' data-hidden="life-insurance"></tbody>
                                            <tbody class="hidden-row" data-hidden="life-insurance">
                                            @if(isset($meta->do_you_have_life_insurance) && $meta->do_you_have_life_insurance == 'Yes')

                                                    @if(isset($meta->life_insurance))
                                                        @foreach($meta->life_insurance as $key => $insurance)
                                                            <tbody class="generated">
                                                                <tr>
                                                                    <td>Type:</td>
                                                                    <td class="input input-radio benefit_type" data-field="life_insurance[{{ $key }}][benefit_type]">{{ $insurance->benefit_type }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Loans</td>
                                                                    <td class="input input-checkbox" data-field="life_insurance[{{ $key }}][loans]">{{ $insurance->loans or 'No' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Death Benefit:</td>
                                                                    <td class="input" data-field="life_insurance[{{$key}}][death_benefit]">{{ $insurance->death_benefit }}</td>
                                                                </tr>
                                                                @if($insurance->benefit_type == 'Term')
                                                                <tbody class="hidden-row" data-hidden="benefit_type">
                                                                    <tr>
                                                                        <td>Duration in Months</td>
                                                                        <td class="input" data-field="life_insurance[{{$key}}][duration_in_months]">{{ $insurance->duration_in_months }}</td>
                                                                    </tr>
                                                                </tbody>
                                                                @endif
                                                                <tr>
                                                                    <td>Annual Premium</td>
                                                                    <td class="input" data-field="life_insurance[{{$key}}][yearly_premium]">{{ $meta->yearly_premium or '' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cash Value:</td>
                                                                    <td class="input" data-field="life_insurance[{{$key}}][cash_value]">{{ $insurance->cash_value or '' }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>LTC Rider of Accelerated Benefit</td>
                                                                    <td class="input input-radio ltc_rider" data-field="life_insurance[{{$key}}][ltc_rider_of_accelerated_benefit]">{{ $insurance->ltc_rider_of_accelerated_benefit or 'N/A' }}</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>Beneficiary:</td>
                                                                    <td class="input" data-field="life_insurance[{{$key}}][beneficiary]">{{ $insurance->beneficiary }}</td>
                                                                </tr>
                                                            </tbody>
                                                        @endforeach
                                                    @endif


                                            @endif
                                            <tbody class="stop-insurance"></tbody>
                                            </tbody>

                                            <tr>
                                                <td>What is the total value of your emergency fund?</td>
                                                <td class="input currency required" data-field="what_is_the_total_value_of_your_emergency_fund">{{ $meta->what_is_the_total_value_of_your_emergency_fund or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have Disability Insurance?</td>
                                                <td class="input input-radio" data-field="do_you_have_disability_insurance">{{ $meta->do_you_have_disability_insurance or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have Health Insurance?</td>
                                                <td class="input input-radio" data-field="do_you_have_health_insurance">{{ $meta->do_you_have_health_insurance or 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Do you have Home Owners Insurance?</td>
                                                <td class="input input-radio" data-field="do_you_have_home_owners_insurance">{{ $meta->do_you_have_home_owners_insurance or 'N/A' }}</td>
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
                                                <th colspan="2"><i class="fa fa-money" aria-hidden="true"></i> Income Statement</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>What is your pre-tax income?</td>
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
                                                <th colspan="2"><i class="fa fa-area-chart" aria-hidden="true"></i> Suitability</th>
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
                                                <th colspan="2"><i class="fa fa-pie-chart" aria-hidden="true"></i> Assets</th>
                                            </tr>
                                            </thead>
                                            <tbody class='tbody-main'></tbody>
                                            <!--============================================================================
                                               These hidden inputs is to let the empty array fields get submitted in post
                                            ===============================================================================-->
                                            <input type="hidden" id="assets-default-asset_type" name="assets[default][asset_type]" value="default">
                                            @if(isset($meta->assets))
                                                <?php $item_ctr = 0;?>
                                                @foreach($meta->assets as $item => $vitem)
                                                    <tbody class="generated" id="asset-container-{{ $item_ctr }}">
                                                    <tr class="select-row">
                                                        <td class="asset-type-column">Type:</td>
                                                        <td class="input input-select asset-type" id="assets-{{ $item }}-asset_type" data-field="assets[{{ $item }}][asset_type]">{{ ($vitem->asset_type == '401k' && $vitem->own == 'spouse') ? '403(b)' : $vitem->asset_type  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Own Asset:</td>
                                                        <td class="input input-radio asset" id="assets-{{ $item }}-own" data-field="assets[{{ $item }}][own]">{{ $vitem->own or '' }}</td>
                                                    </tr>
                                                    <tbody id="assets-fields-{{ $item_ctr }}">
                                                    @if($vitem->asset_type == 'Rental' || $vitem->asset_type == 'Home')
                                                        <?php
                                                        $mortgage_property = 'No';
                                                        if(isset($vitem->do_you_have_a_mortgage_or_lien_on_the_property)){
                                                            $mortgage_property = ($vitem->do_you_have_a_mortgage_or_lien_on_the_property ) ? $vitem->do_you_have_a_mortgage_or_lien_on_the_property : 'No';
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td>Do you have a mortgage or lien on the property?</td>
                                                            <td class="input input-radio mortgage" id="assets-{{ $item }}-do_you_have_a_mortgage_or_lien_on_the_property" data-field="assets[{{ $item }}][do_you_have_a_mortgage_or_lien_on_the_property]">{{ $mortgage_property }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Value:</td>
                                                            <td class="input currency" id="assets-{{ $item }}-value" data-field="assets[{{ $item }}][value]">{{ $vitem->value or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Income Received Annually:</td>
                                                            <td class="input currency" id="assets-{{ $item }}-income-recieved-annually" data-field="assets[{{ $item }}][annual_income]">{{$vitem->annual_income or '' }}</td>
                                                        </tr>

                                                    @elseif($vitem->asset_type == 'IRA' || $vitem->asset_type == '401k' || $vitem->asset_type == '403b' || $vitem->asset_type == 'Brokerage' || $vitem->asset_type == '529Plan' || $vitem->asset_type == 'Coverdell' || $vitem->asset_type == 'UTMA' || $vitem->asset_type == 'UGMA' || $vitem->asset_type == 'Simple' || $vitem->asset_type == 'SEP' || $vitem->asset_type == 'Roth')

                                                        <tr>
                                                            <td>Company:</td>
                                                            <td class="input" id="assets-{{ $item }}-company" data-field="assets[{{ $item }}][company]">{{ $vitem->company or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Balance:</td>
                                                            <td class="input currency" id="assets-{{ $item }}-balance" data-field="assets[{{ $item }}][balance]">{{ $vitem->balance }}</td>
                                                        </tr>
                                                        @if(isset($vitem->symbols))

                                                                @foreach($vitem->symbols as $k => $v)
                                                                    @if(isset($v->share_price) && isset($v->symbol) && isset($v->number_of_shares))
                                                                    <?php $count_symbols ++;?>

                                                                <tr class="symbol-row-{{ $item }}-{{ $k }}">
                                                                    <td><a id="{{ $item }}-delete-symbol" style="display:none" class="delete-symbol" onClick="deleteSymbol({{ $item }} '-' {{ $k }})" href="javascript:void(0)">X</a> Symbol:</td>
                                                                    <td class="input symbols" id="assets-{{ $item }}-symbols-{{ $k }}-symbol" data-field="assets[{{ $item }}][symbols][{{ $k }}][symbol]">{{ $v->symbol }}</td>
                                                                </tr>
                                                                <tr class="symbol-row-{{ $item }}-{{ $k }}">
                                                                    <td>Share Price:</td>
                                                                    <td class="input currency" id="assets-{{ $item }}-symbols-{{ $k }}-share_price" data-field="assets[{{ $item }}][symbols][{{ $k }}][share_price]">{{ $v->share_price }}</td>
                                                                </tr>
                                                                <tr class="symbol-row-{{ $item }}-{{ $k }}">
                                                                    <td>Number of Shares:</td>
                                                                    <td class="input numericOnly" id="assets-{{ $item }}-symbols-{{ $k }}-number_of_shares" data-field="assets[{{ $item }}][symbols][{{ $k }}][number_of_shares]">{{ $v->number_of_shares }}</td>
                                                                </tr>
                                                                    @endif
                                                                @endforeach

                                                        @endif
                                                        <tr style="display:none" class="base-symbol-btn" id="base-symbol-{{ $item }}">
                                                            <td>Symbols</td>
                                                            <td><a href='javascript:void(0)' id='assets{{ $item }}_add_symbol' data-type='assets' data-count='{{ $item }}' class='btn btn-primary' onClick='addSymbol({{ $item }})'>+</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Additions:</td>
                                                            <td class="input currency" id="assets-{{ $item }}-additions" data-field="assets[{{ $item }}][additions]">{{ $vitem->additions }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Withdrawals:</td>
                                                            <td class="input currency" id="assets-{{ $item }}-withdrawals" data-field="assets[{{ $item }}][withdrawals]">{{ $vitem->withdrawals }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Interest Rate:</td>
                                                            <td  class="input percentage" id="assets-{{ $item }}-interest_rate" data-field="assets[{{ $item }}][interest_rate]">{{ $vitem->interest_rate }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Beneficiary:</td>
                                                            <td class="input" id="assets-{{ $item }}-beneficiary" data-field="assets[{{ $item }}][beneficiary]">{{ $vitem->beneficiary or "N/A" }}</td>
                                                        </tr>
                                                    @elseif($vitem->asset_type == 'Annuity')
                                                        <tr>
                                                            <td>Company:</td>
                                                            <td class="input" id="assets-{{ $item }}-company" data-field="assets[{{ $item }}][company]">{{ $vitem->company or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Value:</td>
                                                            <td class="input" id="assets-{{ $item }}-value" data-field="assets[{{ $item }}][value]">{{ $vitem->value or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Annual Premiums:</td>
                                                            <td class="input" id="assets-{{ $item }}-value" data-field="assets[{{ $item }}][annual_premiums]">{{ $vitem->annual_premium or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Growth Rate:</td>
                                                            <td class="input" id="assets-{{ $item }}-value" data-field="assets[{{ $item }}][growth_rate]">{{ $vitem->growth_rate or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Additions:</td>
                                                            <td class="input currency" id="assets-{{ $item }}-additions" data-field="assets[{{ $item }}][additions]">{{ $vitem->additions }}</td>
                                                        </tr>
                                                    @elseif($vitem->asset_type == 'CDs')
                                                        <tr>
                                                            <td>Months Remaining:</td>
                                                            <td class="input numericOnly" id="cds-{{ $item }}-months_remaining" data-field="assets[{{ $item }}][months_remaining]">{{ $vitem->months_remaining }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Value:</td>
                                                            <td class="input currency" id="cds-{{ $item }}-value" data-field="assets[{{ $item }}][value]">{{ $vitem->value or "" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Interest Rate:</td>
                                                            <td  class="input percentage" id="cds-{{ $item }}-interest_rate" data-field="assets[{{ $item }}][interest_rate]">{{ $vitem->interest_rate }}</td>
                                                        </tr>
                                                    @elseif($vitem->asset_type == 'Savings' || $vitem->asset_type == 'Checking')
                                                        <tr>
                                                            <td>Company:</td>
                                                            <td class="input" id="assets-{{ $item }}-company" data-field="assets[{{ $item }}][company]">{{ $vitem->company or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Balance:</td>
                                                            <td class="input currency" id="assets-{{ $item }}-balance" data-field="assets[{{ $item }}][balance]">{{ $vitem->balance }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Additions (Annual):</td>
                                                            <td class="input currency" id="assets-{{ $item }}-additions" data-field="assets[{{ $item }}][additions]">{{ $vitem->additions }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Withdrawals (Annual):</td>
                                                            <td class="input currency" id="assets-{{ $item }}-withdrawals" data-field="assets[{{ $item }}][withdrawals]">{{ $vitem->withdrawals }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Interest Rate:</td>
                                                            <td  class="input percentage" id="assets-{{ $item }}-interest_rate" data-field="assets[{{ $item }}][interest_rate]">{{ $vitem->interest_rate }}</td>
                                                        </tr>
                                                    @elseif($vitem->asset_type == 'Business')
                                                        <tr>
                                                            <td>Company Name:</td>
                                                            <td class="input" id="assets-{{ $item }}-company" data-field="assets[{{ $item }}][company]">{{ $vitem->company or '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Value:</td>
                                                            <td class="input" id="assets-{{ $item }}-value" data-field="assets[{{ $item }}][value]">{{ $vitem->value }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Income Generated Per Year:</td>
                                                            <td class="input" id="assets-{{ $item }}-income_generated_per_year" data-field="assets[{{ $item }}][income_generated_per_year]">{{ $vitem->income_generated_per_year }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Money going into Business per year:</td>
                                                            <td class="input" id="assets-{{ $item }}-money_going_into_business_per_year" data-field="assets[{{ $item }}][money_going_into_business_per_year]">{{ $vitem->money_going_into_business_per_year }}</td>
                                                        </tr>
                                                    @endif
                                                    </tbody>

                                                        <?php $item_ctr++;?>
                                                @endforeach
                                            @endif
                                            <tbody class='stop-assets'></tbody>
                                            </tbody>
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
                                                    <th colspan="2">
                                                        <i class="fa fa-info-circle fa-lg"></i> Personal & Family Information
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td>Age:</td>
                                                <td class="input numericOnly required" data-field="age">{{ $meta->age or ''  }}</td>
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
                                                    <td class="input" data-field="spouse_name">{{ $meta->spouse_name or 'N/A'  }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Spouse Age:</td>
                                                    <td class="input numericOnly" data-field="spouse_age">{{ $meta->spouse_age or 'N/A' }}</td>
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
                                                    <th colspan="2">
                                                        <i class="fa fa-users" aria-hidden="true"></i> Children
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
                                                <th colspan="2">
                                                    <i class="fa fa-area-chart" aria-hidden="true"></i> Tax Slide
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
                                                <td>Who did you taxes last year?</td>
                                                <td class="input input-select" data-field="who_did_your_taxes_last_year">{{ $meta->who_did_your_taxes_last_year or 'N/A' }}</td>
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
                                                <th colspan="2"><i class="fa fa-line-chart" aria-hidden="true"></i> Retirement Plan</th>
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
                                                    {{ $meta->do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy or 'N/A' }}
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
                                                @foreach($meta->pension as $index => $item)
                                                    <tbody class='pension hidden-row generated' data-hidden="pension">
                                                        <tr>
                                                            <td class="pension-type-column">Type:</td>
                                                            <td id='pensions-{{ $index }}-type' class="input input-radio type" data-field="pension[{{ $index }}][type]">{{ $item->type or "" }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Does it have a cost of living adjustment?</td>
                                                            <td id='pensions-{{ $index }}-does_it_have_a_cost_of_living_adjustment' class="input input-radio" data-field="pension[{{ $index }}][does_it_have_a_cost_of_living_adjustment]">{{ $item->does_it_have_a_cost_of_living_adjustment or 'N/A' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Projected monthly pension benefit:</td>
                                                            <td id='pensions-{{ $index }}-projected_monthly_pension_benefit' class="input currency" data-field="pension[{{ $index }}][projected_monthly_pension_benefit]">{{ $item->projected_monthly_pension_benefit }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Survivor Benefit?</td>
                                                            <td id='pensions-{{ $index }}-survivor_benefit' class="input input-radio" data-field="pension[{{ $index }}][survivor_benefit]">{{ $item->survivor_benefit }}</td>
                                                        </tr>
                                                    </tbody>
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
                                                <th colspan="2"><i class="fa fa-tags" aria-hidden="true"></i> Liabilities</th>
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
                    $html = $sign+$html.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
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
            $('.input-radio').each(function(){
                $positive = 'Yes';
                $negative = 'No';
                if($radio_row.data('hidden') == 'benefit_type'){
                    $positive = 'Permanent';
                    $negative = 'Term';
                }
                $group = $radio_row.data('hidden');
                $rowDisplayInitial($radio_row,$group,'.hidden-row',$positive);
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


            $('.symbols').autocomplete({
                lookup: $symbols,
                onSelect: function () {
                    $index = $symbols.indexOf($(this).val());
                    if($index > -1){
                        $symbols.splice($index, 1);
                    }
                    $('.symbols').autocomplete({
                        lookup: $symbols});
                    /*$('#state').parent().removeClass('invalid');
                     $('.fielderrors').hide();*/
                }
            });

            $('input.currency').priceFormat({prefix: '$ ', centsLimit: 0});
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


        var $children = [];
        @if(isset($meta->children))
            @foreach($meta->children as $number => $item)
                $children['{{ $number }}'] = [];
                $children['{{ $number }}']['name'] = "{{ $item->name }}";
                $children['{{ $number }}']['age'] = "{{ $item->age }}";
            @endforeach
        @endif



        var $assets = [];
        {{--@if(isset($meta->assets))--}}
            {{--@foreach($meta->assets as $number => $item)--}}
                {{--$assets['{{ $number }}'] = [];--}}
                {{--$assets['{{ $number }}']['asset_type'] = "{{ ($item->asset_type == '401k' && $item->own == 'spouse') ? '403b' : $item->asset_type }}";--}}
                {{--$assets['{{ $number }}']['company'] = "{{ $item->company }}";--}}
                {{--$assets['{{ $number }}']['balance'] = "{{ $item->balance }}";--}}
                {{--$assets['{{ $number }}']['funds'] = "{{ $item->funds }}";--}}
                {{--$assets['{{ $number }}']['additions'] = "{{ $item->additions }}";--}}
                {{--$assets['{{ $number }}']['withdrawals'] = "{{ $item->withdrawals }}";--}}
                {{--$assets['{{ $number }}']['interest_rate'] = "{{ $item->interest_rate }}";--}}
                {{--$assets['{{ $number }}']['beneficiary'] = "{{ $item->beneficiary or "" }}";--}}
            {{--@endforeach--}}
        {{--@endif--}}

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
                        $(this).html("<a id='asset_"+$asset_delete_count+"' href='javascript:void(0);' onclick='delete_asset("+$asset_delete_count+");' class='delete-link delete-asset'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:");
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
                    var $life_insurance_delete_count = 0;
                    $('.life_insurance-type-column').each(function(){
                        $(this).html("<a id='lifet_insurance_"+$life_insurance_delete_count+"' href='javascript:void(0);' onclick='delete_liability("+$life_insurance_delete_count+");' class='delete-link delete-liability'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:");
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
                            if($(this).closest('tbody').hasClass('pension') || $(this).closest('tbody').hasClass('children') || $(this).hasClass('asset') || $(this).hasClass('mortgage')){
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
                            }else if($(this).hasClass('asset')){
                                $(this).html(
                                        "<label for='"+$id+"_own_mine'><input id='"+$id+"_own_mine' name='"+$(this).data('field')+"' type='radio' value='mine'> Mine</label>&nbsp;"+
                                        "<label for='"+$id+"_own_spouse'><input id='"+$id+"_own_spouse' name='"+$(this).data('field')+"' type='radio' value='spouse'> Spouse</label>"
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
                                $("#"+$id+"_own_mine").prop('checked',true);
                                $("#"+$id+"_own_spouse").prop('checked',false);
                            }else{
                                $("#"+$id+"_own_mind").prop('checked',false);
                                $("#"+$id+"_own_spouse").prop('checked',true);
                            }

                            if($value=='Permanent'){
                                $("#benefit_type_permanent").prop('checked',true);
                                $("#benefit_type_term").prop('checked',false);
                            }else if($value=='Term'){
                                $("#benefit_type_permanent").prop('checked',false);
                                $("#benefit_type_term").prop('checked',true);
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
                                $(this).html(
                                        "<select name='"+$(this).data('field')+"' id='"+$(this).data('field')+"' class='type-dropdown required form-control'>"+
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

                    $(this).find('select').each(
                        function(){
                            $(this).find('option').each(function(){
                                if($value == $(this).val()){
                                    $(this).prop('selected',true);
                                }
                            });
                        }
                    );



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
                activateInputMask();
                assetMortGageSelection();
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
                $('.add-assets').closest('tbody').siblings('.stop-assets').before($data);
                $('#asset-container-'+$asset_count).show('normal');
                $(window).scrollTop($('#assets-'+$asset_count+'-type').focus().position().top);
                activateInputMask();
                assets_fields('', $asset_count);
            });
        }


        function assets_fields($type, $asset_count){
            $('#assets-fields-'+ $asset_count).html('');
             $.post($client_template,{type: "asset_field",asset_type: $type,asset_count:$asset_count,_token:$token}, function($data){
                $('#assets-fields-' + $asset_count).append($data);
                activateInputMask();
                assetMortGageSelection();
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

        function add_life_insurance(){
            $insurance_count++;
            $html       = '<tbody style="display:none;" class="generated">';
            $html       += '<tr>' +
                            '<td><a id="insurance_'+$insurance_count+'" onclick="delete_insurance('+$insurance_count+');" class="delete-insurance delete-link" href="javascript:;"><i class="fa fa-times" aria-hidden="true"></i></a> Type:</td>' +
                            '<td>' +
                            '<label for="benefit_type_'+$insurance_count+'_p"><input type="radio" name="life_insurance['+$insurance_count+'][benefit_type]" id="benefit_type_'+$insurance_count+'_p" class="insurance_' + $insurance_count + '_type_choices" value="Permanent" /> Permanent</label> &nbsp;'+
                            '<label for="benefit_type_'+$insurance_count+'_t"><input type="radio" name="life_insurance['+$insurance_count+'][benefit_type]" id="benefit_type_'+$insurance_count+'_t" class="insurance_' + $insurance_count + '_type_choices" value="Term" checked /> Term</label>'+
                            '</td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td>Loans:</td>' +
                                '<td><label for="loans'+$insurance_count+'"><input type="checkbox" id="loans'+$insurance_count+'" name="life_insurance['+$insurance_count+'][loans]" value="Yes" /> Loans?</label></td>'+
                            '</tr>' +
                            '<tr>' +
                                '<td>Death Benefit:</td>' +
                                '<td class="input" data-field="death_benefit"><input type="text" name="life_insurance['+ $insurance_count +'][death_benefit]" /></td>'+
                            '</tr>'+
                            '<tr class="hidden-row" id="duration_'+$insurance+'" data-hidden="benefit_type">'+
                                '<td>Duration in Months</td>' +
                                '<td><input type="text" name="life_insurance['+$insurance_count+'][duration_in_months]" /></td>' +
                            '</tr>'+
                            '<tr>'+
                            '<td>Annual Premium</td>'+
                            '<td class="input" data-field="yearly_premium"><input type="text" name="life_insurance['+ $insurance_count+'][yearly_premium]" /></td>' +
                            '</tr>'+
                            '<tr>'+
                                '<td>Cash Value:</td>'+
                                '<td class="input" data-field="cash_value"><input type="text" name="life_insurance['+$insurance_count+'][cash_value]" class="currency" /></td>'+
                            '</tr>'+
                            '<tr>' +
                                '<td>Beneficiary:</td>'+
                                '<td class="input" data-field="beneficiary"><input type="text" name="life_insurance['+$insurance_count+'][beneficiary]" /></td>'+
                            '</tr>';
            $html       += '</tbody>';
            $('.add-life_insurance').closest('tbody').siblings('.stop-insurance').before($html);
            $('.generated').show('normal');
            activateInputMask();
            $('input.insurance_' + $insurance_count + '_type_choices').change(function(){
                var val = $('input.insurance_' + $insurance_count + '_type_choices:checked').val();
                if(val == 'Permanent'){
                    $('#duration_'+$insurance).hide();
//                    $('#duration_'+$insurance).css({'display': 'none'});
                }else{
                    $('#duration_'+$insurance).show();
//                    $('#duration_'+$insurance).css({'display': 'block'});
                }
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

            $("#asset-container-"+e).fadeOut("normal", function() {
                $(this).remove();
            });
            $("#assets-fields-"+e).fadeOut("normal", function() {
                $(this).remove();
            });
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
            $("#insurance_"+e).closest('tbody.generated').fadeOut("normal", function() {
                $(this).remove();
            });
        }

        $(".meta_save").on('click',
                function(){
                        $count = 0;
                        $check = $(this).closest("form").find(".required").each(function () {
                            if ($(this).find("input").val() == "") {
                                $count++;
                                $(this).find("input").css({'box-shadow': "0px 0px 5px red"});
                            }
                        });
                    if($count > 0 ){
                        alert("Some fields are required!");
                    }
                    if($count == 0){
                    var $post = $(this);

                    var form_route = $post.closest('form.meta_form').prop('action');
                    var formid     = $post.closest('form.meta_form').prop('id');
//                        console.log(formid);
                        console.log(formid);
                    var post_data = $(this).closest('.meta_form').serialize();
                    $.post(form_route, post_data,
                     function(data){
                         var $id = $post.closest('form.meta_form').find('.cancel').prop('id');
                         $post.closest('form.meta_form').find('.table').find('tbody').each(function(){
                             $(this).find('.delete-link').each(function(){ $(this).remove() });
                             $(this).find('.add').each(function(){ $(this).remove() });
                             /** =====================================================================================================
                              *  puts checkbox values in a separate variable so that it can increment throughout all checkbox input
                             ====================================================================================================== **/
                             $symbol_list = "";
                             $checkbox_html = "";
                             $radio_value = "";
                             $(this).find('input').each(
                                 function() {
                                     $value = $(this).val();
                                     if($(this).prop('type')=='radio'){
                                         $value = $("input[name='"+$(this).prop('name')+"']:checked").val();
                                         if(!$("input[name='"+$(this).prop('name')+"']").is(':checked')){
                                             $value = "";
                                         }
                                     }
                                     if($(this).prop('type')=='checkbox'){
                                         $value = "";
                                         $("input[name='"+$(this).prop('name')+"']:checked").each(
                                             function(){
                                                 $value += "<span data-field="+$(this).val()+">"+$(this).val()+"</span><br/>";
                                             }
                                         );



                                     }
                                     $(this).closest('td').html($value);
                                 }
                             );
                            $(this).find('select').each(
                                 function() {
                                     $value = $(this).val();
                                     if($(this).closest("td").hasClass('funds')){
                                         $value = $value.replace('#','');
                                     }
                                     $(this).closest('td').html($value);
                                 }
                            );
                             $(this).find('textarea').each(
                                function() {
                                    $value = $(this).val();
                                    $(this).closest('td').html($value);
                                }
                            );
                         });
                        // $post.closest('form.meta_form').find('.table').find('thead').after($field_history[$id]);
                         $.each(data, function(i, obj) {
                             //use obj.id and obj.name here, for example:
                             $('#'+ obj.key).text(obj.value);
                         });
                $('.delete-symbol').hide();
                     $('.base-symbol-btn').hide();
                         $post.closest('span').siblings('.meta_update').show();
                         $post.closest('span').hide();
                     }, 'json');

                    return false;
                }
                }
        );


        /**======================================================
         * Add Symbols
         *=======================================================*/
        $symbol_count = '{{ $count_symbols }}';
         function addSymbol(e){
             console.log(e);
//            $add_symbol = $("#symbol-container-"+ e);
            $add_symbol = $("tr#base-symbol-"+ e);
             $html = '<tr class="symbol-row-'+ e + '-' + $symbol_count +'">' +
                        '<td><a id="'+$symbol_count+'-delete-symbol" class="delete-symbol" onClick="deleteSymbol(\'' + e + '-'+ $symbol_count +'\')" href="javascript:void(0)">X</a> &nbsp;Symbol:</td>' +
                        '<td class="input symbols" data-field="assets[' + e + '][symbols][' + $symbol_count + '][symbol]"><input type="text" name="assets[' + e + '][symbols][' + $symbol_count + '][symbol]" id="assets-' + e + '-symbols-' + $symbol_count + '-symbol" class="symbols form-control" /></td>' +
                    '</tr>' +
                    '<tr class="symbol-row-'+ e + '-' + $symbol_count +'">' +
                        '<td>Share Price:</td>' +
                        '<td class="input currency" data-field="assets[' + e + '][symbols][' + $symbol_count + '][share_price]"><input type="text" name="assets[' + e + '][symbols][' + $symbol_count + '][share_price]" id="assets-' + e + '-symbols-' + $symbol_count + '-share_price" class="currency form-control" /></td>' +
                    '</tr>' +
                    '<tr class="symbol-row-'+ e + '-' + $symbol_count +'">' +
                        '<td>Number of Shares:</td>' +
                        '<td class="input numericOnly" data-field="assets[' + e + '][symbols][' + $symbol_count + '][number_of_shares]"><input type="text" name="assets[' + e + '][symbols][' + $symbol_count + '][number_of_shares]" id="id="assets-' + e + '-symbols-' + $symbol_count + '-number_of_shares" class="numericOnly form-control" /></td>' +
                    '</tr>';

            $add_symbol.before($html);
            $add_symbol.find(".symbol-row-"+ e).last().show('fast');


            $symbol_count++;
             activateInputMask();
         }
        /**======================================================
         * Delete Symbols
         *=======================================================*/
         function deleteSymbol(e){
            $symbol = $(".symbol-row-"+e);
            $symbol.hide("fast", function(){ $symbol.remove()});

        };

    /**
     * save the form
     */

    </script>
@stop