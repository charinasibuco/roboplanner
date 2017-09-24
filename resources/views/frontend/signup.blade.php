@extends('frontend.layouts.template')

@section('title', 'SignUP')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/jquery.idealforms.css')  }}">
    <style>
        /*#progress_bar {*/
        /*!*progress {*!*/
            /*background-color: #f3f3f3;*/
            /*border: 0;*/
            /*height: 18px;*/
            /*border-radius: 9px;*/
            /*width:100%;*/
            /*position: relative;*/
        /*}*/

        /*.progress-value{display:block;position:absolute; width: 0; background-color: #f3f3f3;}*/

        /*#myProgress {*/
            /*position: relative;*/
            /*width: 100%;*/
            /*height: 25px;*/
            /*background-color: #aaa;*/
        /*}*/
        /*#myBar {*/
            /*position: absolute;*/
            /*width: 1%;*/
            /*height: 100%;*/
            /*background-color: #128dd8;*/
            /*text-align: center;*/
            /*color: #fff;*/
        /*}*/

        /*.progress > .progress-type {*/
            /*position: absolute;*/
            /*left: 20px;*/
            /*!*font-weight: 800;*!*/
            /*!*padding: 3px 30px 2px 10px;*!*/
            /*!*color: rgb(255, 255, 255);*!*/
            /*!*background-color: rgba(25, 25, 25, 0.2);*!*/
        /*}*/
        /*.progress > .progress-completed {*/
            /*position: absolute;*/
            /*right: 20px;*/
            /*font-weight: 100;*/
            /*!*padding: 3px 10px 2px;*!*/
        /*}*/
        .navbar-default{
            box-shadow: 0 8px 6px -6px #999;
        }

        .progress {
            position: relative;
        }

        .progress-title {
            position: absolute;
            text-align: center;
            line-height: 20px; /* line-height should be equal to bar height */
            overflow: hidden;
            color: black;
            right: 0;
            left: 0;
            top: 0;
        }
    </style>
@stop

@section('content')
    <div class="container box-padding">
        <div class="row content row-box">
            <div class="col-md-12 idealsteps-container">
                <nav class="idealsteps-nav"></nav>
                {{--<div id="myProgress" class="progress">--}}
                    {{--<div id="myBar"></div>--}}
                    {{--<span class="progress-type">Make Login</span>--}}
                    {{--<span class="progress-completed">0% Completed</span>--}}
                {{--</div>--}}


                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="10"
                             aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        </div>
                        <span class="progress-title">0% Make Login</span>
                    </div>


                <form id="signup-form" action="{{ route('signup_save') }}" class="idealforms form-inline form-horizontal" method="post" role="form" onsubmit="return false" novalidate >
                    {{ csrf_field() }}
                    <div class="message"></div>
                    <div class="idealsteps-wrap">
                                <!-- Step 1 -->
                        <section class="idealsteps-step active" id="account_details" data-title="Account Details" data-section="0">
                            <fieldset class="progression secondary-step active" id="make-login" data-title="Make Login" data-section="0">
                                <legend>Make Login</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row form-center">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label for="first_name" class="main">First Name:</label>
                                            <input id="first_name" name="first_name" type="text" class="required prefill"><span class="error"></span>
                                        </div>
                                        <div class="field">
                                            <label for="last_name" class="main">Last Name:</label>
                                            <input id="last_name" name="last_name" type="text" class="required prefill"><span class="error"></span>
                                        </div>
                                        <div class="field">
                                            <label for="email" class="main">Email:</label>
                                            <input id="email" name="email" type="text" class="required email prefill "><span class="error"></span>
                                        </div>
                                        <div class="field">
                                            <label for="password" class="main">Password:</label>
                                            <input id="password" name="password" type="password" class="required "><span class="error"></span>
                                        </div>
                                        <div class="form-group field">
                                            <label for="confirm" class="main">Confirm Password:</label>
                                            <input id="confirm" name="confirm" type="password" class="required "><span class="error"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-primary secondary-step-next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="progression secondary-step" id="tell-us-about-yourself" data-title="Tell Us About Yourself" data-section="1">
                                <legend>Tell Us About Yourself</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main">Name:</label>
                                            <span id="prefill-first_name"></span>  <span id="prefill-last_name"> </span>
                                        </div>
                                        <div class="field">
                                            <label for="" class="main">Email: </label>
                                            <span id="prefill-email"></span>
                                        </div>
                                        <div class="field">
                                            <label for="age" class="main">Age:</label>
                                            <input type="text" name="age" id="age" class="required numericOnly">
                                            <span class="error"></span>
                                        </div>
                                        <div class="field">
                                            <label for="sex_male" class="main">Sex:</label>
                                            <label for="sex_male"><input type="radio" name="sex" id="sex_male" value="Male" checked>Male</label>
                                            <label for="sex_female"><input type="radio" name="sex" id="sex_female" value="Female">Female</label>
                                            <span class="error"></span>
                                        </div>
                                        <div class="field">
                                            <label for="state" class="main">State:</label>
                                            <input type="text" name="state" id="state" class="required" placeholder="Ex. Nevada">
                                            <span class="error"></span>
                                        </div>
                                        <div class="field">
                                            <label for="occupation" class="main">Occupation:</label>
                                            <input type="text" name="occupation" id="occupation" class="form-control">
                                        </div>
                                        <div class="field">
                                            <label class="main" for ="working_with_yes">Are you Working with Financial Advisor?</label>
                                            <label for="working_with_yes" class="radio-inline"><input type="radio" name="working_with_financial_advisor" id="working_with_yes" value="Yes"> Yes</label>&nbsp;
                                            <label for="working_with_no" class="radio-inline"><input type="radio" name="working_with_financial_advisor" id="working_with_no" value="No" checked="checked">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning secondary-step-prev">« Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary secondary-step-next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="progression secondary-step" id="family" data-title="Family" data-section="2">
                                <legend>Family</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label for="married_yes" class="main">Are you married?</label>
                                                <label for="married_yes" class="radio-inline"><input type="radio" name="married" value="Yes" id="married_yes" class="married required">Yes</label>
                                                <label for="married_no" class="radio-inline"><input type="radio" name="married" value="No" id="married_no" class="married required" checked="checked">No</label>
                                        </div>

                                        <div class="spouse_detail" id="spouse-container">
                                            <div class="field">
                                                <label for="spouse_name"  class="main">Spouse Name:</label>
                                                <input type="text" name="spouse_name" id="spouse_name" class="form-control">
                                            </div>
                                            <div class="field">
                                                <label for="spouse_age"  class="main">Spouse Age:</label>
                                                <input type="text" name="spouse_age" id="spouse_age" class="form-control numericOnly">
                                            </div>
                                            <div class="field">
                                                <label for="spouse_sex_male" class="main">Spouse Sex:</label>
                                                <label for="spouse_sex_male"><input type="radio" name="sex" id="spouse_sex_male" value="Male" checked>Male</label>
                                                <label for="spouse_sex_female"><input type="radio" name="sex" id="spouse_sex_female" value="Female">Female</label>
                                                <span class="error"></span>
                                            </div>

                                        </div>

                                        <div class="field">
                                            <label class="main" for="number_children">How many children do you have?</label>
                                            <select name="number_children" id="number_children">
                                                <option value="">- Select -</option>
                                                <option value="0"> None </option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="specify">Specify</option>
                                            </select>
                                            &nbsp;
                                            <span id="specified_number_children_container">
                                                 <input type="text" name="specified_number_children" id="specified_number_children" class="form-control numericOnly" placeholder="Input Number of Children...">
                                            </span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="childrens" class="clearfix fields">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="field" id="special_needs">
                                            <label class="main" for="have_child_special_needs_yes">Do any children have special needs?</label>
                                                <label for="have_child_special_needs_yes" class="radio-inline"><input type="radio" name="have_child_special_needs" value="Yes" id="have_child_special_needs_yes">Yes</label>
                                                <label for="have_child_special_needs_no" class="radio-inline"><input type="radio" name="have_child_special_needs" value="No" id="have_child_special_needs_no" checked="checked">No</label>
                                        </div>
                                        <div class="field" id="special_needs_trust">
                                            <label class="main" for="have_special_needs_trust_yes">Do you have Special Needs Trust?</label>
                                            <label for="have_special_needs_trust_yes" class="radio-inline"><input type="radio" name="have_special_needs_trust" value="Yes" id="have_special_needs_trust_yes">Yes</label>
                                            <label for="have_special_needs_trust_no" class="radio-inline"><input type="radio" name="have_special_needs_trust" value="No" id="have_special_needs_trust_no" checked="checked">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning secondary-step-prev">« Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary secondary-step-next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="progression secondary-step" id="Expenses" data-title="Expenses" data-section="3">
                                <legend>Expenses</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main" for="do_you_have_large_expenses_coming_up_yes">Do You Have Large Expenses Coming Up?</label>
                                            <label for="do_you_have_large_expenses_coming_up_yes"><input type="radio" name="do_you_have_large_expenses_coming_up" id="do_you_have_large_expenses_coming_up_yes" value="Yes" class="radio-inline">Yes</label>
                                            <label for="do_you_have_large_expenses_coming_up_no"><input type="radio" name="do_you_have_large_expenses_coming_up" id="do_you_have_large_expenses_coming_up_no" value="No" class="radio-inline" checked="checked">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="expenses">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <div class="group">
                                                <div class="panel-group" id="expense_accordion">
                                                    <div class="expense-type-panel panel panel-default">
                                                        <div class="panel-heading panel-heading-dropdown">
                                                            <h4 class="panel-title">
                                                                <span><a id="expense_add" class="btn btn-primary" href="javascript:void(0);">Add</a></span>
                                                                &nbsp; <strong>Expenses</strong>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning secondary-step-prev">« Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary secondary-step-next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="progression secondary-step" id="tax-slide" data-title="Tax Slide" data-section="4">
                                <legend>Tax Information</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="field">
                                            <label class="main" for="who_did_your_taxes_last_year">Who did your taxes last year?</label>
                                            <select name="who_did_your_taxes_last_year" id="who_did_your_taxes_last_year" class="form-control">
                                                <option value="">- Select -</option>
                                                <option value="Turbo Tax">Turbo Tax</option>
                                                <option value="CPA or enrolled Agent">CPA or enrolled Agent</option>
                                                <option value="I did my own taxes">I did my own taxes</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label>Did you have to pay in additional taxes last year?</label>
                                            <label for="did_you_have_to_pay_in_additional_taxes_last_year_yes"><input type="radio" name="did_you_have_to_pay_in_additional_taxes_last_year" id="did_you_have_to_pay_in_additional_taxes_last_year_yes" value="Yes"> Yes</label>
                                            <label for="did_you_have_to_pay_in_additional_taxes_last_year_no"><input type="radio" name="did_you_have_to_pay_in_additional_taxes_last_year" id="did_you_have_to_pay_in_additional_taxes_last_year_no" value="No" checked> No</label>
                                        </div>
                                        <div class="field" id="how_much_to_pay_additional_taxes_field">
                                            <label for="how_much_to_pay_additional_taxes">How much?</label>
                                            <input type="text" name="how_much_to_pay_additional_taxes" placeholder="$" class="form-control currency" id="how_much_to_pay_additional_taxes">
                                        </div>
                                        <div class="field" id="tax-refund">
                                            <label class="main" for="how_big_is_your_refund">How big was your refund last year?</label>
                                            <input type="text" name="how_big_is_your_refund" id="how_big_is_your_refund" placeholder="Refund amount.." class="currency numericOnly">
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning secondary-step-prev">« Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary secondary-step-next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="progression secondary-step" id="state-slide" data-title="State Slide" data-section="5">
                                <legend>Estate Plan</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main" for="do_you_have_a_will_yes">Do you have a will?</label>
                                            <label for="do_you_have_a_will_yes" class="radio-inline"><input type="radio" name="do_you_have_a_will" id="do_you_have_a_will_yes" value="Yes" class="required">Yes</label>
                                            <label for="do_you_have_a_will_no" class="radio-inline"><input type="radio" name="do_you_have_a_will" id="do_you_have_a_will_no" value="No" class="required" checked="checked">No</label>
                                        </div>

                                        <div id="no_will">
                                            <div class="field">
                                                <label class="main" for="do_you_want_to_link_financial_accounts_or_manually_enter_data_yes">Do you want to Link financial accounts or manually enter data?</label>
                                                <label for="do_you_want_to_link_financial_accounts_or_manually_enter_data_yes" class="radio-inline"><input type="radio" name="do_you_want_to_link_financial_accounts_or_manually_enter_data" id="do_you_want_to_link_financial_accounts_or_manually_enter_data_yes" value="Yes">Yes</label>
                                                <label for="do_you_want_to_link_financial_accounts_or_manually_enter_data_no" class="radio-inline"><input type="radio" name="do_you_want_to_link_financial_accounts_or_manually_enter_data" id="do_you_want_to_link_financial_accounts_or_manually_enter_data_no" value="No" checked="checked">No</label>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label class="main" for="do_you_have_power_of_attorney_yes">Do you have financial power of attorney?</label>
                                            <label for="do_you_have_power_of_attorney_yes" class="radio-inline"><input type="radio" name="do_you_have_power_of_attorney" id="do_you_have_power_of_attorney_yes" value="Yes">Yes</label>
                                            <label for="do_you_have_power_of_attorney_no" class="radio-inline"><input type="radio" name="do_you_have_power_of_attorney" id="do_you_have_power_of_attorney_no" value="No" checked="checked">No</label>
                                        </div>
                                         <div class="field">
                                            <label class="main" for="do_you_have_healthcare_proxy_yes">Do you have healthcare proxy?</label>
                                            <label for="do_you_have_healthcare_proxy_yes" class="radio-inline"><input type="radio" name="do_you_have_healthcare_proxy" id="do_you_have_healthcare_proxy_yes" value="Yes">Yes</label>
                                            <label for="do_you_have_healthcare_proxy_no" class="radio-inline"><input type="radio" name="do_you_have_healthcare_proxy" id="do_you_have_healthcare_proxy_no" value="No" checked="checked">No</label>
                                        </div>
                                        <div id="has_will">
                                            <div class="field">
                                                <label class="main" for="how_long_has_it_been_since_you_renewed_it">How long since you last reviewed it?</label>
                                                <select name="how_long_has_it_been_since_you_renewed_it" id="how_long_has_it_been_since_you_renewed_it" class="">
                                                    <option value=""> Select </option>
                                                    <option value="Within last 12 months">Within last 12 months</option>
                                                    <option value="1-3 years ago">1-3 years ago</option>
                                                    <option value="More than 3 years ago">More than 3 years ago</option>
                                                </select>
                                            </div>
                                            
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning secondary-step-prev">« Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary secondary-step-next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="progression secondary-step" id="risk-management" data-title="Risk Management" data-section="6">
                                <legend>Risk Management</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row" id="risk-management">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main" for="do_you_have_life_insurance_yes">Do you have life insurance?</label>
                                            <label for="do_you_have_life_insurance_yes"><input type="radio" name="do_you_have_life_insurance" id="do_you_have_life_insurance_yes" value="Yes" class="required">Yes</label>
                                            <label for="do_you_have_life_insurance_no"><input type="radio" name="do_you_have_life_insurance" id="do_you_have_life_insurance_no" value="No" class="required" checked="checked">No</label>
                                        </div>
                                        <div id="has_death_insurance">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <fieldset>
                                                        <div class="group">
                                                            <div class="panel-group" id="life_insurance">
                                                                <div class="insurance-type-panel panel panel-default">
                                                                    <div class="panel-heading panel-heading-dropdown">
                                                                        <h4 class="panel-title">
                                                                            <span><a id="life_insurance_add" class="btn btn-primary" href="javascript:void(0);">Add</a></span>
                                                                            &nbsp; <strong>Life Insurance</strong>
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12"></div>
                                            </div>

                                        </div>

                                        <div class="field">
                                            <label class="main" for="what_is_the_total_value_of_your_emergency_fund">What is the total value of your emergency fund?</label>
                                            <input type="text" name="what_is_the_total_value_of_your_emergency_fund" id="what_is_the_total_value_of_your_emergency_fund" placeholder="Total amount of emergency fund.." class="form-control currency numericOnly required">
                                        </div>

                                        <div class="field">
                                            <label class="main" for="do_you_have_disability_insurance_yes">Do you have disability insurance?</label>
                                            <label for="do_you_have_disability_insurance_yes"><input type="radio" name="do_you_have_disability_insurance" id="do_you_have_disability_insurance_yes" value="Yes" class="required">Yes</label>
                                            <label for="do_you_have_disability_insurance_no"><input type="radio" name="do_you_have_disability_insurance" id="do_you_have_disability_insurance_no" value="No" class="required" checked="checked">No</label>
                                        </div>

                                        <div class="field">
                                            <label class="main" for="do_you_have_health_insurance_yes">Do you have health insurance?</label>
                                            <label for="do_you_have_health_insurance_yes"><input type="radio" name="do_you_have_health_insurance" id="do_you_have_health_insurance_yes" value="Yes" class="required">Yes</label>
                                            <label for="do_you_have_health_insurance_no"><input type="radio" name="do_you_have_health_insurance" id="do_you_have_health_insurance_no" value="No" class="required" checked="checked">No</label>
                                        </div>

                                        <div class="field">
                                            <label class="main" for="do_you_have_home_owners_insurance_yes">Do you have homeowners insurance?</label>
                                            <label for="do_you_have_home_owners_insurance_yes"><input type="radio" name="do_you_have_home_owners_insurance" id="do_you_have_home_owners_insurance_yes" value="Yes" class="required">Yes</label>
                                            <label for="do_you_have_home_owners_insurance_no"><input type="radio" name="do_you_have_home_owners_insurance" id="do_you_have_home_owners_insurance_no" value="No" class="required" checked="checked">No</label>
                                        </div>
                                        <div class="field" id="tax_free">
                                            <label class="main" for="tax_free">Tax-Free Income:</label>
                                            <input type="text" name="tax_free" id="tax_free" class="form-control numericOnly currency" placeholder="Tax Free Value" >
                                        </div>
                                        <div class="field" id="tax_deferred">
                                            <label class="main" for="tax_deferred">Tax Deffered Investments:</label>
                                            <input type="text" name="tax_deferred" id="tax_deferred" class="form-control numericOnly currency" placeholder="Tax-Deferred Investments" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning secondary-step-prev">« Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary secondary-step-next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="progression secondary-step" id="retirement-plan" data-title="Retirement Plan" data-section="7">
                                <legend>Retirement Plan</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main" for="what_age_do_you_plan_on_retiring_age">What age do you plan on retiring/What age did you retire (default: 65)?</label>
                                            <input type="text" name="what_age_do_you_plan_on_retiring_age" id="what_age_do_you_plan_on_retiring_age" class="required form-control numericOnly" value='65' placeholder="Age..">
                                            <label for="what_age_do_you_plan_on_retiring_i_dont_know">
                                                &nbsp;<input type="checkbox" name="what_age_do_you_plan_on_retiring" id="what_age_do_you_plan_on_retiring_i_dont_know" value="I don't know">I don't know
                                            </label>
                                        </div>

                                        <div class="field">
                                            <label class="main" for="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy_yes">Do you have any health conditions that would greatly affect your life expectancy?</label>
                                            <label class="radio-inline" for="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy_yes"><input type="radio" name="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy" id="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy_yes" value="Yes" class="required">Yes</label>
                                            <label class="radio-inline" for="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy_no"><input type="radio" name="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy" id="do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy_no" class="required" checked="checked">No</label>
                                        </div>
                                        <div class="field" id="age_to_assume">
                                            <label class="main" for="what_age_would_you_like_us_to_assume">What life expectancy would you like us to assume?</label>
                                            <input type="text" name="what_age_would_you_like_us_to_assume" id="what_age_would_you_like_us_to_assume" class="form-control numericOnly" placeholder="Age to assume.." >
                                        </div>
                                        
                                        <div class="field" id="age_to_assume">
                                            <label class="main" for="what_age_would_you_like_us_to_assume">What life expectancy would you like us to assume?</label>
                                            <input type="text" name="what_age_would_you_like_us_to_assume" id="what_age_would_you_like_us_to_assume" class="form-control numericOnly" placeholder="Age to assume.." >
                                        </div>




                                        <div class="field" id="if_married">
                                            <label class="main" for="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy_yes">(If Married) Does your spouse have any health conditions that would greatly affect their life expectancy?</label>
                                            <label class="radio-inline" for="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy_yes"><input type="radio" name="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy" id="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy_yes" value="Yes" class="required">Yes</label>
                                            <label class="radio-inline" for="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy_no"><input type="radio" name="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy" id="does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy_no" value="No" class="required" checked="checked">No</label>
                                        </div>
                                        <div class="field" id="age_to_assume2">
                                            <label class="main" for="what_age_would_you_like_us_to_assume2">What life expectancy would you like us to assume?</label>
                                            <input type="text" name="what_age_would_you_like_us_to_assume2" id="what_age_would_you_like_us_to_assume2" class="form-control numericOnly">
                                        </div>

                                        <div class="field">
                                            <label class="main" for="in_todays_dollars_do_you_know_the_exact_after-tax_income_you_will_need_in_retirement_no_idea_fill_in">In today's dollars, what after-tax income would you need each month to retire?</label>
                                            {{--<label for="in_todays_dollars_do_you_know_the_exact_after-tax_income_you_will_need_in_retirement_no_idea_fill_in"></label>--}}
                                            <input type="text" name="in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement" id="in_todays_dollars_do_you_know_the_exact_after-tax_income_you_will_need_in_retirement_no_idea_fill_in" class="required currency" value="" placeholder="Fill in">
                                            <label for="in_todays_dollars_do_you_know_the_exact_after-tax_income_you_will_need_in_retirement_no_idea"><input type="checkbox" name="in_todays_dollars_do_you_know_the_exact_after_tax_income_you_will_need_in_retirement_no_idea" id="in_todays_dollars_do_you_know_the_exact_after-tax_income_you_will_need_in_retirement_no_idea" value="No idea, help me">No idea, help me</label>

                                        </div>

                                        <div class="field">
                                            <label class="main" for="do_you_plan_on_working_part_time_in_retirement_yes">Do you plan on working part time in retirement?</label>
                                            <label class="radio-inline" for="do_you_plan_on_working_part_time_in_retirement_yes"><input type="radio" name="do_you_plan_on_working_part_time_in_retirement" id="do_you_plan_on_working_part_time_in_retirement_yes" value="Yes" class="required">Yes</label>
                                            <label class="radio-inline" for="do_you_plan_on_working_part_time_in_retirement_no"><input type="radio" name="do_you_plan_on_working_part_time_in_retirement" id="do_you_plan_on_working_part_time_in_retirement_no" value="No" class="required" checked="checked">No</label>
                                        </div>

                                        <div class="field part_time_plan">
                                            <label class="main" for="estimated_income">Estimated Annual Income:</label>
                                            <input type="text" name="estimated_income" id="estimated_income" placeholder="Amount of estimated Income.." class="form-control currency numericOnly">
                                            <label for="not_sure"><input type="checkbox" name="not_sure" id="not_sure">Not sure</label>
                                        </div>

                                        <div class="field">
                                            <label class="main" for="do_you_know_your_social_security_benefit_at_retirement_yes">Do you know your monthly Social Security benefit at Full Retirement Age?</label>
                                            <label class="radio-inline" for="do_you_know_your_social_security_benefit_at_retirement_yes"><input type="radio" name="do_you_know_your_social_security_benefit_at_retirement" id="do_you_know_your_social_security_benefit_at_retirement_yes" value="Yes" class="required">Yes</label>
                                            <label class="radio-inline" for="do_you_know_your_social_security_benefit_at_retirement_no"><input type="radio" name="do_you_know_your_social_security_benefit_at_retirement" id="do_you_know_your_social_security_benefit_at_retirement_no" value="No" class="required" checked="checked">No</label>
                                            <br/>
                                            <span style="display:none" id="social_security_benefit_retirement_note">If you have previously been married for at least 10 years, even if divorced you can still claim up to half of your prior spouse's benefit. This option does not apply if you remarried.</span>
                                        </div>

                                        <div class="know_retirement_benefit">
                                            <div class="field">
                                                <label class="main" for="retirement_benefit_yours">Yours: </label>
                                                <input type="text" class="form-control currency" name="social_security_retirement_benefit_yours" id="retirement_benefit_yours" value="" >
                                            </div>
                                            <div class="field" id="social_security_retirement_benefit_spouse_container">
                                                <label class="main" for="retirement_benefit_spouses">Spouse: </label>
                                                <input type="text" class="form-control" name="social_security_retirement_benefit_spouse" id="retirement_benefit_spouses" value="">
                                            </div>
                                        </div>
                                        <div class="field" id="spouse-pension">
                                            <label class="main" for="do_you_or_your_spouse_have_a_pension_yes">Do you or your spouse have a pension?</label>
                                            <label class="radio-inline" for="do_you_or_your_spouse_have_a_pension_yes"><input type="radio" name="do_you_or_your_spouse_have_a_pension" id="do_you_or_your_spouse_have_a_pension_yes" value="Yes" class="required"> Yes</label>
                                            <label class="radio-inline" for="do_you_or_your_spouse_have_a_pension_no"><input type="radio" name="do_you_or_your_spouse_have_a_pension" id="do_you_or_your_spouse_have_a_pension_no" value="No" class="required" checked="checked"> No</label>
                                        </div><br/>
                                    </div>
                                </div>
                                <div class="row" id="pension">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <div class="group">
                                                <div class="panel-group" id="pension_accordion">
                                                    <div class="pension-type-panel panel panel-default">
                                                        <div class="panel-heading panel-heading-dropdown">
                                                            <h4 class="panel-title">
                                                                <span><a id="pension_add" class="btn btn-primary" href="javascript:void(0);">Add</a></span>
                                                                &nbsp; <strong>Pensions</strong>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        &nbsp;
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main" for="would_you_rather_leave_money_to_heirs">Would you rather...</label>
                                            <label for="would_you_rather_leave_money_to_heirs">
                                                <input type="radio" id="would_you_rather_leave_money_to_heirs" name="would_you_rather" value="Leave largest amount of money to heirs">
                                                Leave largest amount of money to heirs
                                            </label><br/>
                                            <label for="would_you_rather_retire_as_early_as_possible">
                                                <input type="radio" id="would_you_rather_retire_as_early_as_possible" name="would_you_rather" value="Retire as early as possible">
                                                Retire as early as possible
                                            </label><br/>
                                            <label for="would_you_rather_maximize_retirement_income">
                                                <input type="radio" id="would_you_rather_maximize_retirement_income" name="would_you_rather" value="Maximize retirement income">
                                                Maximize retirement income
                                            </label><br/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning secondary-step-prev">« Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                        </section>
                        <section class="idealsteps-step" data-title="Income Statement" id="income-statement" data-section="8">
                            <fieldset class="progression">
                                <legend>Income Statement</legend>
                                <div class="row">
                                    <div class="col-md-12 fielderrors"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main" for="pre_tax_income">What is your annual pre-tax income?</label>
                                            <input type="text" id="pre_tax_income" name="pre_tax_income" class="required currency numericOnly">
                                        </div>

                                        <div class="field" id="pre_tax_income_spouse_container">
                                            <label class="main" for="pre_tax_income">What is your spouse's annual pre-tax income?</label>
                                            <input type="text" id="pre_tax_income_spouse" name="pre_tax_income_spouse" class="currency numericOnly">
                                        </div>

                                        <div class="field">
                                            <label class="main" for="estimate_after_tax_income">What is your household's after-tax monthly income?</label>
                                            <input type="text" id="estimate_after_tax_income" name="households_after_tax_monthly_income" class="required currency numericOnly">
                                        </div>

                                        <div class="field">
                                            <label class="main" for="estimated_monthly_living_expenses">Estimated monthly living expenses?</label>
                                                <input type="text" id="estimated_monthly_living_expenses" name="estimated_montlhy_living_expenses" class="required currency numericOnly">
                                                &nbsp;
                                            <label for="estimated_monthly_living_expenses_dont_know">
                                                <input type="checkbox" id="estimated_monthly_living_expenses_dont_know" name="estimated_monthly_living_expenses_dont_know">
                                                I don't know, Help Me
                                            </label>
                                        </div>

                                        <div class="field">
                                            <label class="main" for="estimated_monthly_living_expenses">Do you anticipate any changes in your annual income?</label><br/>
                                            <label class="radio-inline" for="do_you_anticipate_any_changes_in_your_annual_income_yes">
                                                <input type="radio" id="do_you_anticipate_any_changes_in_your_annual_income_yes" name="do_you_anticipate_any_changes_in_your_annual_income" value="Yes" class="required">
                                                Yes
                                            </label>
                                            <label class="radio-inline" for="do_you_anticipate_any_changes_in_your_annual_income_no">
                                                <input type="radio" id="do_you_anticipate_any_changes_in_your_annual_income_no" name="do_you_anticipate_any_changes_in_your_annual_income" value="No" class="required" checked="checked">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning prev">&laquo; Prev</button>
                                        <button type="button" class="btn btn-lg btn-primary next">Next &raquo;</button>
                                    </div>
                                </div>
                            </fieldset>
                        </section>
                        <section class="idealsteps-step" data-title="Balance Sheet" data-section="9">
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="progression">
                                        <legend>Balance Sheet</legend>
                                        <div class="group">
                                            <div class="panel-group" id="asset_accordion">
                                                <div class="asset-type-panel panel panel-default">
                                                    <div class="panel-heading panel-heading-dropdown">
                                                        <h4 class="panel-title">
                                                            <span><a id="asset_add" class="btn btn-primary" href="javascript:void(0);">Add</a></span>
                                                            &nbsp; <strong>Assets</strong> (Home, Business, 401k's, IRA's, etc.)
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend>&nbsp;</legend>
                                        <div class="group">
                                            <div class="panel-group" id="liability_accordion">
                                                <div class="liability-type-panel panel panel-default">
                                                    <div class="panel-heading panel-heading-dropdown">
                                                        <h4 class="panel-title">
                                                            <span><a id="liability_add" class="btn btn-primary" href="javascript:void(0);">Add</a></span>
                                                            &nbsp; <strong>Liabilities</strong> (Mortgage, Debt, Student Loans, etc.)
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 field buttons">
                                    <button type="button" class="btn btn-lg btn-warning prev">&laquo; Prev</button>
                                    <button type="button" class="btn btn-lg btn-primary next">Next &raquo;</button>
                                </div>
                            </div>
                        </section>
                        <section class="idealsteps-step" data-title="Suitability" data-section="10">
                            <fieldset class="progression">
                                <legend>Suitability</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="field">
                                            <label class="main" for="long_term_rate_return_from_investments">What long-term rate or return do you expect from your investments?</label>
                                            <input type="text" id="long_term_rate_return_from_investments" name="long_term_rate_return_from_investments" value="" class="required percentage numericOnly">
                                        </div>

                                        <div class="field">
                                            <label for="you_would_be_uncomfortable">What % loss on your investments...</label>
                                        </div>
                                        <div class="field">
                                            <label class="main" for="you_would_be_uncomfortable">Makes you uncomfortable:</label>
                                            <input type="text" id="you_would_be_uncomfortable" name="you_would_be_uncomfortable" value="" class="required percentage numericOnly">
                                        </div>

                                        <div class="field">
                                            <label class="main" for="you_would_fire_me_panic_go_to_cash">Makes you panic/go to cash:</label>
                                            <input type="text" id="you_would_fire_me_panic_go_to_cash" name="you_would_fire_me_panic_go_to_cash" value="" class="required percentage numericOnly">
                                        </div>

                                        <div class="field">
                                            <label class="main" for="investment_experience_rate">Rate your investment experience(1-5)</label>
                                            <select name="investment_experience_rate" id="investment_experience_rate" class="required">
                                                <option value=""> Select </option>
                                                <option value="1 – No experience">1 – No experience</option>
                                                <option value="2 – Some experience">2 – Some experience</option>
                                                {{--<option value="3 – Average experience, work/401k's, IRA's, etc.">3 – Average experience, work/401k's, IRA's, etc.</option>--}}
                                                <option value="3 – Average Experience">3 – Average Experience</option>
                                                {{--<option value="4 – Above Average – Multiple accounts outside my employer">4 – Above Average – Multiple accounts outside my employer</option>--}}
                                                <option value="4 – Above Average Experience">4 – Above Average Experience</option>
                                                {{--<option value="5 – Experience trading asset classes outside of stocks, bonds, and mutual funds.">5 – Experience trading asset classes outside of stocks, bonds, and mutual funds.</option>--}}
                                                <option value="5 – Significantly Above Average Experience.">5 – Significantly Above Average Experience.</option>
                                            </select>
                                        </div>

                                        <div class="field">
                                            <label class="main" for="">When do you plan to make major withdrawal?</label>
                                            <label for="less_than_5_years"><input type="radio" id="less_than_5_years" name="when_do_you_plan_to_make_major_withdrawal" value="<5 Years" checked> <5 Years</label><br/>
                                            <label for="5_10_years"><input type="radio" id="5_10_years" name="when_do_you_plan_to_make_major_withdrawal" value="5-10 Years"> 5-10 Years</label><br/>
                                            <label for="10_20_years"><input type="radio" id="10_20_years" name="when_do_you_plan_to_make_major_withdrawal" value="10-20 Years"> 10-20 Years</label><br/>
                                            <label for="20_plus_years"><input type="radio" id="20_plus_years" name="when_do_you_plan_to_make_major_withdrawal" value="20+ Years"> 20+ Years</label><br/>
                                        </div>

                                            <div class="field">
                                                <label class="main" for="inverse_securities">Would you invest in inverse securities or short investments?</label>
                                                <label for="inverse_securities"><input type="radio" id="inverse_securities" name="inverse_securities_or_short_investments" value="Yes" class="required"> Yes</label><br/>
                                                <label for="short_investments"><input type="radio" id="short_investments" name="inverse_securities_or_short_investments" value="No" class="required" checked="checked"> No</label><br/>
                                             </div>
                                        <div class="field">
                                            <label class="main" for="stocks">Have you ever invested in:</label>
                                            <label for="stock"><input type="checkbox" id="stock" name="investments[]" value="Stock"> Stock</label><br/>
                                            <label for="mutual_funds"><input type="checkbox" id="mutual_funds" name="investments[]" value="Mutual Funds"> Mutual Funds</label><br/>
                                            <label for="effs"><input type="checkbox" id="effs" name="investments[]" value="ETFs"> ETFs</label><br/>
                                            <label for="bonds"><input type="checkbox" id="bonds" name="investments[]" value="Bonds"> Bonds</label><br/>
                                            <label for="options"><input type="checkbox" id="options" name="investments[]" value="Options"> Options</label><br/>
                                            <label for="real_estate"><input type="checkbox" id="real_estate" name="investments[]" value="Real Estate"> Real Estate</label><br/>
                                            <label for="commodities"><input type="checkbox" id="commodities" name="investments[]" value="Commodities"> Commodities</label><br/>
                                            <label for="futures"><input type="checkbox" id="futures" name="investments[]" value="Futures"> Futures</label><br/>
                                            <label for="currency_investment"><input type="checkbox" id="currency_investment" name="investments[]" value="Currency"> Currency</label>
                                        </div>
                                        <div class="field">
                                            <label class="main" for="opposed_to_using_leverages_yes">Are you opposed to using leverage?</label>
                                            <label for="opposed_to_using_leverages_yes"><input type="radio" id="opposed_to_using_leverages_yes" name="opposed_to_using_leverages" value="Yes" class="required" checked="checked"> Yes</label><br/>
                                            <label for="opposed_to_using_leverages_no"><input type="radio" id="opposed_to_using_leverages_no" name="opposed_to_using_leverages" value="No" class="required" > No</label><br/>
                                        </div>
                                    </div>
                                 </div>
                                <div class="row">
                                    <div class="col-md-12 field buttons">
                                        <button type="button" class="btn btn-lg btn-warning prev">&laquo; Prev</button>
                                        <button id="form-submit" class="submit btn btn-lg btn-primary">Submit</button>
                                    </div>
                                </div>
                            </fieldset>
                        </section>
                    </div>
                </form>
            </div>

        </div>
    </div>


@stop

@section('scripts')
    <script>
        var URL                 = '{{ route('cached') }}';
        var signup_save_url     = '{{ route('signup_save') }}';
        var session_field       = '{{ session('field') }}';
        var WELCOME_URL         = '{{ route('success') }}';
        var VALIDATE_EMAIL      = '{{ route('uniqueemail') }}';
        var cached  = 0;
        $investments = [];

        @foreach($symbols as $key => $symbol)
            $investments.push("{{ $symbol }}");
        @endforeach
    </script>
    <script src="{{ asset('js/extensions/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js') }}"></script>
    <script src="{{ asset('js/aes.js') }}"></script>
    <script src="{{ asset('js/out/jquery.idealforms.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/jquery.autocomplete.js') }}"></script>
    <script src="{{ asset('js/states.js') }}"></script>

    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/extensions/jquery.price_format.2.0.js') }}"></script>
    <script src="{{ asset('js/signup.js') }}"></script>

@stop

