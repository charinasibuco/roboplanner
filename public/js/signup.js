var result = 1;
var invalid_ctr = 0;

var width               = 1;
var totalSection        = 12;
$(function (){
    var yellowFlag          = [];
    var redFlag             = [];

    var elem                = $("#myBar");
    //var $progressbar        = $("#myBar");
    //var $completed          = $('.progress-completed');
    //var $progressType       = $('.progress-type');


    var states               = ['Alaska', 'Arkansas', 'California', 'Connecticut', 'Delaware', 'Georga', 'Idaho', 'Indiana', 'Iowa', 'Kentucky',
                            'Louisiana', 'Maryland', 'Massachusetts', 'Mississippi', 'Montana', 'Nevada', 'New Hampshire', 'New Jersey', 'North Carolina', 'North Dakota',
                            'Ohio', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Dakota', 'Tennessee', 'Utah', 'Vermont', 'Virginia', 'West Virginia'];


    var StatesArray = $.map(statesArray, function (team) { return { value: team, data: { category: 'NBA' } }; });
    var $state      = $('#state');
    var progress_value = 0;
    var increment = 100/$(".progression").length;
    var prev_count = 0;
    $(document).ready(function(){
        section = $("section#account_details");
        progress_value += increment;
        rounded = Math.round(progress_value);
        $(".progress-bar").css("width", rounded+"%");
        $(".progress-title").html(rounded+"%"+" "+section.find('fieldset.progression').first().data('title'));
    });
    addProgress = function(event){
        fieldset = event.closest("fieldset.progression").next("fieldset.progression").find("legend").html();
        if(fieldset == null){
            fieldset = event.closest("section").next("section").find("fieldset.progression").first().find("legend").html();
        }

        if(prev_count == 0){
            progress_value += increment;
            rounded = Math.round(progress_value);
            $(".progress-title").html(rounded+"%"+" "+fieldset);
        }
        if(prev_count > 0){
            prev_count--;
        }
        $(".progress-bar").css("width",rounded+"%");

    }

    haltProgress = function(event){
        prev_count++;
        //fieldset = event.closest("fieldset.progression").prev("fieldset.progression").find("legend").html();
        //if(fieldset == null){
        //    fieldset = event.closest("section").prev("section").find("fieldset.progression").first().find("legend").html();
        //}
        //progress_value -= increment;
        //rounded = Math.round(progress_value);
        //$(".progress-bar").css("width",rounded+"%");
        //$(".progress-title").html(rounded+"%"+" "+fieldset);
    }
    //addProgress = function(currentSection, $next){
    //    console.log(currentSection);
    //    var body = $("html, body");
    //    var title = $next.next().data('title');
    //    $progressType.text(title);
    //    body.stop().animate({scrollTop:0}, '500', 'swing', function() {
    //        //alert("Finished animating");
    //        if (currentSection >= totalSection){ return; }
    //        currentSection++;
    //        width   = Math.round(100 * currentSection / totalSection);
    //        $progressbar.css("width", width + "%");
    //        //$('body').animate({ scrollTop: 0 }, 'slow');
    //        //$progressbar.text(width + "%");
    //
    //        $completed.text(width + "% Completed")
    //    });
    //
    //
    //}

    //minusProgress = function(currentSection, $next){
    //    console.log(currentSection);
    //    var body = $("html, body");
    //    var title = $next.prev().data('title');
    //    $progressType.text(title);
    //    body.stop().animate({scrollTop:0}, '500', 'swing', function() {
    //        //if (currentSection == 1) {
    //        //    return;
    //        //}
    //        //if(currentSection == 10) {
    //        //    currentSection = 11;
    //        //    //currentSection--;
    //        //}else{
    //        //    currentSection += 1;
    //        //}
    //
    //        currentSection++;
    //
    //        width = Math.round(100 * currentSection / totalSection);
    //        $progressbar.css("width", width + "%");
    //
    //        $completed.text(width + "% Completed")
    //    });
    //
    //}

    $('#state').autocomplete({
        lookup: StatesArray,
        onSelect: function (suggestion) {
            $('#state').parent().removeClass('invalid');
            $('.fielderrors').hide();
        }
    });
    var form        = $("#signup-form");
    var stepsTitle  = [];
    var phrase      = 'Aasdpl234fdjakspqewrqwcnxsqqwer';
    $('.idealsteps-wrap section').each(function(){
        stepsTitle.push($(this).data('title'));
    });

    //--- Form step script
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
        displayStepCounter: false,
        rules: {
            'first_name': 'required',
            'last_name': 'required',
            'email': 'required email',
            'password': 'required pass',
            'confirm': 'required equalto:password',
            'age': 'required',
            'state': 'required'
            //'date': 'required date',
            //'picture': 'required extension:jpg:png',
            //'website': 'url',
            //'hobbies[]': 'minoption:2 maxoption:3',
            //'phone': 'required phone',
            //'zip': 'required zip',
            //'options': 'select:default',
        },

        errors: {
            //'username': {
            'email': {
                ajaxError: 'Username not available'
            }
        },

        onSubmit: function(invalid, e) {
            e.preventDefault();
            var valid = firstStepValidation();
            if(valid == true){
                save_signup();
            }
            return false;
        }

    });

    //Scroll to top function
    var scrollTopFunc = function(){
        var body = $("html, body");
        body.stop().animate({scrollTop:0}, '500', 'swing', function() {
            alert("Finished animating");
        });
    }

    $('form.idealforms').find('input, select, textarea').on('change keyup', function() {
        $('#invalid').hide();
    });

    var initial_progress = $('#tell-us-about-yourself');
    //minusProgress(0, initial_progress);

    $('.prev').click(function(){
        var $ths_elem = $(this);
        var $step       = $ths_elem.closest('.idealsteps-step');
        //if($ths_elem.closest('.idealsteps-step').prev('.idealsteps-step').find('.secondary-step').)
        //$ths_elem.closest('.idealsteps-step').prev('.idealsteps-step').find('.secondary-step').last().show();
        var $secondary  = $ths_elem.closest('.idealsteps-step').prev('.idealsteps-step').find('.secondary-step.active');
        $('.prev').show();

        $('form.idealforms').idealforms('prevStep');
        haltProgress($ths_elem);
        //if($secondary.attr('id') == 'retirement-plan'){
        //   // minusProgress(7, $step);
        //}else{
        //   // minusProgress($step.prev().data('section'), $step);
        //}

    });

    $('.next').click(function(){

        var $this       = $(this);
        invalid_ctr = 0;
        var $step       = $this.closest('.idealsteps-step');
        $step.find('input,textarea,select').each(function(index){
            var $item = $(this);
            if($(this).hasClass('required')) {

                if($(this).prop('type') == 'radio'){
                    var $name = 'input[name='+$(this).prop('name')+']';
                    if( $($name+':checked').length == 0){
                        invalid_ctr++;
                        $(this).parent().parent().addClass('invalid invalid-radio');
                        /* $(this).parent().addClass('invalid-radio');*/
                        $step.find('.fielderrors').text('Please fill in the required field(s)!').show();
                    }
                }else{
                    if($(this).val() == ''){
                        invalid_ctr++;
                        $(this).parent().addClass('invalid');
                        $step.find('.fielderrors').text('Please fill in the required field(s)!').show();
                    }
                }


            }else{
                if( $(this).parent().hasClass('invalid')){
                    $(this).parent().removeClass('invalid');
                    $('.fielderrors').text('').hide();
                    invalid_ctr = 0;
                }
            }
        });


        if(invalid_ctr > 0){
            return false;
        }

        addProgress($step);

        //tempSave($step.attr('id'), $this);
        //nextEvents($this);

        $('.next').show("fast",function(){
            //addProgress($step.next().data('section'), $step);
        });

        $('form.idealforms').idealforms('nextStep');
        //frame(25, '+')
        //console.log($step.data('section'));
        //$('body').animate({ scrollTop: 0 }, 'slow');
    });

    $('#signup-form').submit(function(e){
        e.preventDefault();
        save_signup();
       return false;
    });

    function firstStepValidation(){
        var invalid_ctr = 0;
        var $step       = $('.idealsteps-step');
        $step.find('input,textarea,select').each(function(index){
            var $item = $(this);
            if($(this).hasClass('required')) {


                if($(this).prop('type') == 'radio'){
                    var $name = 'input[name='+$(this).prop('name')+']';
                    if( $($name+':checked').length == 0){
                        invalid_ctr++;

                    }
                }else{
                    if($(this).val() == ''){
                        invalid_ctr++;
                    }
                }


            }
        });


        if(invalid_ctr > 0){
            return false;
        }

        return true;
    }

    var empty_fields_error      = false;
    var invalid_fields_error    = false;
    var $invalid_error_msg      = new Array();
    var $ctr = 0;
    //-- next step button events

    $('.secondary-step-next').click(function(){
        var $this                   = $(this);

        //var invalid_ctr             = 0;
        var $step                   = $this.closest('.secondary-step');


        if($step.prop('id') == 'make-login'){
            var $result = uniqueEmail($step);
        }else{
            invalid_ctr  = 0;
            $('.field').removeClass('invalid');
            validateStep($step, invalid_ctr);
            //frame(3, '+')
        }

        if(invalid_ctr <= 0){
            addProgress($step);
        }
    });

    // -- Previous Button events
    $('.secondary-step-prev').click(function(){
        var $this   = $(this);
        var $step   = $this.closest('.secondary-step');
        $step.fadeOut('fast',function(){
            $step.removeClass('active');
            $step.hide();
            if($(this).prop('id') == 'income-statement'){
                //alert("hahaha");
                $("#make-login").hide();
                $('.next').hide();

            }
            $('body').animate({ scrollTop: 0 }, 'slow');
        }).prev().delay(500).fadeIn('fast', function(){
            if($(this).prop('id') == 'retirement-plan'){
                $('.next').hide();
            }
            $(this).addClass('active');
            //minusProgress($step.prev().data('section'), $step);
            //$('body').animate({ scrollTop: 0 }, 'slow');

        });

        haltProgress($step);
    });

    var callback = function($this){
        console.log(invalid_ctr);

        $('.fielderrors').text('').hide();


        if (invalid_ctr > 0) {
            var emsg = '';
            if (empty_fields_error == true) {
                $ctr++;
                $invalid_error_msg[0] = '<p>Please fill in the required field(s)!</p>';
            }

            if (invalid_fields_error == true) {
                //emsg    += $invalid_error_msg;
                //$step.find('.fielderrors').append('<p>' + $invalid_error_msg + '</p>');
            }
            $.each($invalid_error_msg, function (k, val) {
                if (val != undefined) {
                    emsg += val;
                }
            });
            $this.find('.fielderrors').html(emsg).show();
            return false;
        } else {
            $('.fielderrors').text('').hide();

            nextEvents($this);
        }
    }

    var invalid_pass = false;
    var invalid_confirm = false;
    var invalid_email = false;

    var validateStep = function($step, error_ctr){
        invalid_ctr = error_ctr == 'NaN'? error_ctr : 0;
        $step.find('input,textarea,select').each(function(index){
            var $item = $(this);
            $ctr++;
            if($(this).hasClass('required')) {
                //console.log('required');

                if($(this).prop('type') == 'radio'){
                    var $name = 'input[name='+$(this).prop('name')+']';
                    if( $($name+':checked').length == 0){
                        invalid_ctr++;
                        $(this).parent().parent().addClass('invalid invalid-radio');
                        empty_fields_error = true;
                    }
                }
                if($(this).val() == ''){
                    invalid_ctr++;
                    $(this).parent().addClass('invalid');
                    empty_fields_error = true;
                }else{
                    if($(this).prop('name') == 'password'){
                        if ($(this).parent().hasClass('invalid')) {
                            invalid_ctr++;
                            invalid_pass = true;
                            $invalid_error_msg[invalid_ctr] = '<p>'+$(this).parent().find('.error').text()+'!</p>';
                            console.log('check pass');
                        }else{
                            if(invalid_pass ==  true){
                                invalid_pass = false;
                                invalid_ctr--;
                            }

                        }
                    }else if($(this).prop('name') == 'confirm' ){
                        if ($(this).parent().hasClass('invalid')) {
                            invalid_ctr++;
                            invalid_confirm = true;
                            $invalid_error_msg[invalid_ctr] = '<p>'+$(this).parent().find('.error').text()+'!</p>';
                            console.log('check pass');
                        }else{
                            if(invalid_confirm ==  true){
                                invalid_ctr--;
                                invalid_confirm = false;
                            }
                        }
                    }else if($(this).prop('name') == 'email'){
                        if ($(this).parent().hasClass('invalid')) {
                            invalid_ctr++;
                            invalid_email = true;
                            $invalid_error_msg[invalid_ctr] = '<p>'+$(this).parent().find('.error').text()+'!</p>';
                            console.log('check pass');
                        }else{
                            if(invalid_email ==  true){
                                invalid_ctr--;
                                invalid_email = false;
                            }
                        }
                    }
                }
            }else{
                if( $(this).parent().hasClass('invalid')){
                    $(this).parent().removeClass('invalid');
                    invalid_ctr = 0;
                    $('.fielderrors').text('').hide();
                }
                $ctr--;
            }

            //$ctr++;d
        });

        callback($step);
        //frame(3, '+')

        //addProgress($step.next().data('section'), $step);

        //$('body').animate({ scrollTop: 0 }, 'slow');
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function uniqueEmail($obj){
        var email       = $('#email');
        var emailValue  = email.val();
        var $return     = false;
        if(email.val() != '' && validateEmail(emailValue) == true) {

            var token = $('input[name="_token"]').val();
            $.ajax({
                type: "POST",
                url: VALIDATE_EMAIL,
                data: {email: emailValue, _token: token},
                async: false,
                statusCode: {
                    404: function () {
                        alert("page not found");
                    }
                },
                success: function (data) {
                    //alert(data.message);
                    if (data.status == 1) {
                        var html = $obj.find('.fielderrors').html();
                        var $msg = html + '<p id="email-error">' + data.message + '</p>';
                        email.closest('.icon').css({'background-position': '-16px 0'})
                        email.parent().removeClass('valid');
                        email.parent().addClass('invalid');
                        $invalid_error_msg[3] = data.message;
                        $obj.find('.fielderrors').html($msg).show();
                        invalid_ctr++;
                        //console.log('sed');
                        validateStep($obj);
                        $return = true;
                    } else {
                        invalid_ctr--;
                        //invalid_ctr = 0;
                        //stackoverflow_removeArrayItem(3);
                        $invalid_error_msg = [];
                        //delete elements[3];
                        email.parent().removeClass('invalid');
                        email.parent().addClass('valid');
                        $obj.find('.fielderrors').find('#email-error').remove();
                        email.closest('.icon').css({'background-position': '0 0'});
                        validateStep($obj);
                        $return = true;
                    }
                },
                dataType: 'json'
            });
        }else{
            validateStep($obj);
        }

        //return $return;
    }



    //--- End of form step script

    $('.prefill').on('blur', function(){
        var field   = $(this);
        var id      = field.attr('id');
        var val     = field.val();
        $('#prefill-' + id).text(val);
    });

    //input mask for number only
    //--- Form step script
    //$(".numericOnly").numberOnly({
    //    valid: "0123456789+-.$,"
    //});
    $(".numericOnly").numberOnly();


    $('#other_expense_field').css({'display':'none'});

    $('#expense').change(function(){
       var val  = $(this).val();
        if(val == 'Others'){
            $('#other_expense_field').css({'display':'block'});
        }else{
            $('#other_expense_field').css({'display':'none'});
        }
    });

    $('#age').on('blur', function(){
       var $this = $(this)
        if($this.val() != ''){

        }
    });

    $('#if_married').css({'display': 'none'});
    $('#if_married').find('input').removeClass('required');
    $('#social_security_retirement_benefit_spouse_container').css({'display': 'none'});
    $('#pre_tax_income_spouse_container').css({'display': 'none'});

    //--- Radio button on change events
    $('#signup-form input[name=married]').change(function(){
        var value = $( 'input[name=married]:checked' ).val();
        if(value == 'Yes'){
            $('#spouse-container').show();
            $('#if_married').css({'display': 'block'});
            $('#pre_tax_income_spouse_container').css({'display': 'block'});
            if(!$('#if_married').find('input').hasClass('required')){
                $('#if_married').find('input').removeClass('required');
            }

            $('#social_security_retirement_benefit_spouse_container').css({'display': 'block'});
        }else{
            $('#spouse-container').css({'display': 'none'});
            $('#if_married').css({'display': 'none'});
            $('#if_married').find('input').removeClass('required');
            $('#social_security_retirement_benefit_spouse_container').css({'display': 'none'});
            $('#pre_tax_income_spouse_container').css({'display': 'none'});
        }
    });

    $('#college_plan').css({'display': 'none'});
    $('#special_needs').css({'display': 'none'});
    $('#special_needs_trust').css({'display': 'none'});

    $('#number_children').change(function(){
        var val     = $(this).val();
        var html    = '';
        if(val != 'specify'){
            addChildren(val);
            $('#specified_number_children_container').css({'display': 'none'});
        }else if(val == 'specify'){
            $('#childrens').html('');
            $('#specified_number_children_container').show();
            $('#specified_number_children').bind('keyup',function(e){
                var $this_    = $(this);
                //var $this_    = $(e.target);
                $('#childrens').html('');
                var $val      = $this_.val();
                addChildren($val);

            })
        }else{
            $('#childrens').html('');
            $('#college_plan').css({'display': 'none'});
            $('#special_needs').css({'display': 'none'});
        }


    });

    function addChildren($val){
        var val = $val;
        var html    = '';
        $('#childrens').html('');
        for(var i = 1; i<= val; i++){
            html += '<div class="group" style="padding:3px;border-style: solid; border-width: 1px; border-radius:5px">'
                + '<div class="row">' +
                '<div class="col-md-3">'+
                "<label for='child["+ i +"][name]' class='main'>Child's Name:</label>"+
                '<input type="text" id="child['+ i +'][name]" name="child['+ i +'][name]" value="" id="childname-'+ i +'" placeholder="Child\'s Name.." class="form-control"></div>' +
                '<div class="col-md-3">'+
                "<label for='child["+ i +"][age]' class='main'>Child's Age:</label>"+
                '<input type="text" id="child['+ i +'][age]" name="child['+ i +'][age]" value="" id="childage-'+ i +'" placeholder="Child\'s Age.." class="form-control"></div>' +
                '<div class="col-md-6">'
                + '<div class="group" id="college_plan">'
                + '<label class="main" for="child_'+ i +'_college_plan_yes">If child under 18 - do you want a college plan?</label>'
                + '<label for="child_'+ i +'_college_plan_yes" class=""><input type="radio" name="child['+ i +'][child_college_plan]" value="Yes" id="child_'+ i +'_college_plan_yes">Yes</label>&nbsp;'
                + '<label for="child_'+ i +'_college_plan_no" class=""><input type="radio" name="child['+ i +'][child_college_plan]" value="No" id="child_'+ i +'_college_plan_no">No</label>'
                + '</div>'+
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-sm-12">'

                + '</div>'
                + '</div>'
                +'</div>';

        }
        $('#childrens').html(html);

        if(val != 0) {
            $('#college_plan').css({'display': 'block'});
            $('#special_needs').css({'display': 'block'});
        }
    }

    $('#signup-form input[name=do_you_have_large_expenses_coming_up]').change(function(){
        var val  = $('input[name=do_you_have_large_expenses_coming_up]:checked').val();

        if(val == 'Yes'){
            $('#expenses').show()
        }else{
            $('#expenses').css({'display': 'none'});
        }
    });


    //$('#no_will').css({'display': 'none'});
    $('#has_will').css({'display': 'none'});

    $('#signup-form input[name=do_you_have_a_will]').change(function(){
        var val  = $('input[name=do_you_have_a_will]:checked').val();
        if(val == 'Yes'){
            $('#no_will').css({'display': 'none'});
            $('#has_will').show();
        }else{
            $('#no_will').show();
            $('#has_will').css({'display': 'none'});
        }
    });



    $('#signup-form input[name="have_child_special_needs"]').change(function(){
        var val  = $('input[name=have_child_special_needs]:checked').val();
        if(val == 'Yes'){
            $('#special_needs_trust').css({'display': 'block'});
        }else{
            $('#special_needs_trust').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_have_life_insurance]').change(function(){
        var val  = $('input[name=do_you_have_life_insurance]:checked').val();
        if(val == 'Yes'){
            $('#has_death_insurance').show();
        }else{
            $('#has_death_insurance').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=benefit_type]').change(function(){
        var val = $('input[name=benefit_type]:checked').val();
        if(val == 'Permanent'){
            $('#benefit_type_permanent_yes').show();
        }else{
            $('#benefit_type_permanent_yes').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=ltc_rider_of_accelerated_benefit]').change(function(){
        var val  = $('input[name=ltc_rider_of_accelerated_benefit]:checked');
        console.log(val.attr('id'));
        if(val.attr('id') == 'yes_i_have_a_rider'){
            $('#has_rider').show();
            $('#annual_death_benefit').css({'display': 'none'});
        }else if(val.attr('id') == 'yes_i_have_accelerated_benefit'){
            $('#has_rider').css({'display': 'none'});
            $('#annual_death_benefit').show();
        }else{
            $('#has_rider').css({'display': 'none'});
            $('#annual_death_benefit').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy]').change(function(){
        var val  = $('input[name=do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy]:checked').val();

        if(val == 'Yes'){
            $('#age_to_assume').show();
        }else{
            $('#age_to_assume').css({'display': 'none'});
        }
    })

    $('#signup-form input[name=does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy]').change(function(){
        var val  = $('input[name=does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy]:checked').val();

        if(val == 'Yes'){
            $('#age_to_assume2').show();
        }else{
            $('#age_to_assume2').css({'display': 'none'});
        }
    });


    $('#signup-form input[name=do_you_plan_on_working_part_time_in_retirement]').change(function(){
       var val  = $('input[name=do_you_plan_on_working_part_time_in_retirement]:checked').val();
        if(val == 'Yes'){
            $('.part_time_plan').show();
        }else{
            $('.part_time_plan').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_know_your_social_security_benefit_at_retirement]').change(function(){
        var val  = $('input[name=do_you_know_your_social_security_benefit_at_retirement]:checked').val();
        if(val == 'Yes'){
            $('.know_retirement_benefit').show();
        }else{
            $('.know_retirement_benefit').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_know_your_social_security_benefit_at_retirement]').change(function(){
        var val  = $('input[name=do_you_know_your_social_security_benefit_at_retirement]:checked').val();
        if(val == 'Yes'){
            $('.know_retirement_benefit').show();
        }else{
            $('.know_retirement_benefit').css({'display': 'none'});
        }
    });

    $("#signup-form input[name='do_you_know_your_social_security_benefit_at_retirement']").click(function(){
        if($(this).val() == "Yes"){
            $("#social_security_benefit_retirement_note").show("fast");
        }else{
            $("#social_security_benefit_retirement_note").hide("fast");
        }
    });


    $('#pension').hide();
    $('#signup-form input[name=do_you_or_your_spouse_have_a_pension]').change(function(){
        var val  = $('input[name=do_you_or_your_spouse_have_a_pension]:checked').val();
        if(val == 'Yes'){
            $('#pension').show('fast');
        }else{
            $('#pension').hide('fast');
        }
    });
    //--- Radio button change events scripts end
    $('#estimated_monthly_living_expenses_dont_know').click(function(){
        console.log(1);
        if($(this).checked()==true)
        {
            $('#estimated_monthly_living_expenses').prop('disabled',true);
        }
        else
        {
            $('#estimated_monthly_living_expenses').prop('disabled',false);
        }
    });

    var CryptoJSAesJson = {
        stringify: function (cipherParams) {
            var j = {ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
            if (cipherParams.iv) j.iv = cipherParams.iv.toString();
            if (cipherParams.salt) j.s = cipherParams.salt.toString();
            return JSON.stringify(j);
        },
        parse: function (jsonStr) {
            var j = JSON.parse(jsonStr);
            var cipherParams = CryptoJS.lib.CipherParams.create({ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
            if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
            if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
            return cipherParams;
        }
    }

    var nextEvents = function($this){
        $this.closest('.secondary-step').fadeOut('fast',function(){
            $this.closest('.secondary-step').removeClass('active');
            $this.closest('.secondary-step').hide();
            if($(this).closest('.secondary-step').attr('id') == 'retirement-plan'){
                $('.next').show();
                $('form.idealforms').idealforms('nextStep');
            }


        }).next().delay(500).fadeIn('fast', function(){
            //$('.invalid').removeClass('invalid');
            if($(this).attr('id') == 'retirement-plan'){
                $('.next').show();

            }
            $(this).addClass('active');
        });
    }

    var save_signup = function($id){
        var $step       = $('.idealsteps-step');
        validateStep($step, 0);
        if (invalid_ctr > 0) {
            return false;
        }

        var vardata                         = $( 'form#signup-form').serialize();
        var serializeData   = [];
        var phrase          = 'Aasdpl234fdjakspqewrqwcnxsqqwer';
        $.each($( 'form#signup-form').serializeArray(), function(i, field) {
            //if(field.name == 'password' || field.name == 'confirm'){
            //    //serializeData[this.name] = CryptoJS.AES.encrypt(this.value, phrase);
            //    serializeData.push(field.name + '='+ CryptoJS.AES.encrypt(JSON.stringify(field.value), phrase, {format: CryptoJSAesJson}).toString());
            //    //var decrypted = JSON.parse(CryptoJS.AES.decrypt(encrypted, "my passphrase", {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
            //}
            //else{
                serializeData.push(field.name + '=' + field.value
                        .replace(/&/g, '&amp;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#39;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;'));
            //}

        });
        //console.log(serializeData.toSource());
        serializeData       = serializeData.join('&');
        var postData        = serializeData
                            + '&step=' + $id
                            + '&phrase=' + phrase;
        //return false;
        $.ajax({
            url: signup_save_url,
            method: "POST",
            //data: {"_token": $('input[name=_token]').val()},
            data: postData,
            cache: false,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            },
            statusCode: {
                404: function() {
                    alert( "page not found" );
                }
            },
            beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            }
        }).fail(function(data)
        {
            /*alert('fail');*/
        })
           /* .fail(function(jqXHR, textStatus, errorThrown)
            {
                alert("Error: "+errorThrown+" , Please try again");
            })           */ .done(function(data) {
            //$( this ).addClass( "done" );
            if(data.status == 500){
                window.location.href = data.url;
            }else if(data.status == 1){
                window.location.href = WELCOME_URL;
            }else{
                $('.message').text(data.message);
            }

        });
    }
});

$.widget('themex.numberOnly', {
    options: {
        valid : "0123456789",
        allow : [46,8,9,27,13,35,39],
        ctrl : [65],
        alt : [],
        extra : []
    },
    _create: function() {
        var self = this;

        self.element.keypress(function(e){
            var pval = (e.which) ? e.which : e.keyCode;
            if(self._codeInArray(e,self.options.allow) || self._codeInArray(e,self.options.extra))
            {
                return;
            }
            if(e.ctrlKey && self._codeInArray(e,self.options.ctrl))
            {
                return;
            }
            if(e.altKey && self._codeInArray(e,self.options.alt))
            {
                return;
            }
            if(!e.shiftKey && !e.altKey && !e.ctrlKey)
            {
                if(self.options.valid.indexOf(String.fromCharCode(pval)) != -1)
                {
                    return;
                }
            }
            e.preventDefault();
        });
    },

    _codeInArray : function(event,codes) {
        for(code in codes)
        {
            if(event.keyCode == codes[code])
            {
                return true;
            }
        }
        return false;
    }

});

/**==========================================
 * what_age_do_you_plan_on_retiring_age
===========================================**/

$(function(){
    $('#what_age_do_you_plan_on_retiring_age').keyup(
        function(){
            if($(this).val() == ""){
                $(this).val(65);
            }
        }
    );
});
/**
 *
 */
$(function(){
    $(".panel-heading-dropdown").css("min-height","65px");
});
/**
 * function to generate fields for assets and liabilities
 * @param type
 * @param count
 */
$(".type-dropdown").change(function(){
    $("#"+$(this).prop("id")+"_add").removeClass("disabled");
});

$( function() {
    activateInputMask();
} );

/** ===================================================================================
 * tax information
 */

$('#tax-refund').css({'display': 'none'});
//$('#how_much_to_pay_additional_taxes_field').css({'display': 'block'});

//did_you_have_to_pay_in_additional_taxes_last_year
$('#signup-form input[name="did_you_have_to_pay_in_additional_taxes_last_year"]').change(function(){
    var val  = $('input[name="did_you_have_to_pay_in_additional_taxes_last_year"]:checked').val();
    console.log(val);
    if(val == 'Yes'){
        $('#how_much_to_pay_additional_taxes_field').css({'display': 'block'});
        $('#tax-refund').css({'display': 'none'});
    }else{
        $('#how_much_to_pay_additional_taxes_field').css({'display': 'none'});
        $('#tax-refund').css({'display': 'block'});
    }



});

var al_input = function(type, count){
    /**
     * adds the html fields fo a new item
     */
    var value = $( 'input[name=married]:checked' ).val();
    if(type == 'asset'){
    $fields =  "<div class='field al-field select-type'>"+
        "<label for='company' class='main'>Type:</label>"+
        "<select name='"+type+"["+count+"][asset_type]' data-type='"+type+"' data-count='"+count+"' onchange='alternateQuestions(this)' id='"+type+count+"_asset_type' class='type-dropdown required'>"+
        "<option value='0' selected disabled>Select type of asset</option>"+
        "<option value='IRA'>IRA</option>"+
        "<option value='Rental'>Rental Properties</option>"+
        "<option value='Home'>Home</option>"+
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
        "<option value='Roth'>IRA - Roth</option>"+
        "<option value='CDs'>CDs</option>"+
        "<option value='Savings'>Savings</option>"+
        "<option value='Checking'>Checking</option>"+
        "<option value='Business'>Business</option>"+
        "</select>"+
        "&nbsp;"+
        "</div>";
       /* "<div class='field al-field al-others questions-default' style='display:none'>"+
        "<label for='"+type+count+"_others' class='main'>Others:</label>"+
        "<input type='text' id='"+type+count+"_others' name='"+type+"["+count+"][others]' value='' class=''>"+
        "</div>";*/

    if(value == 'Yes') {
        $fields += "<div class='field al-field questions questions-default' data-field='own'>" +
            "<label class='main'>Own Asset:</label>" +
            "<label for='" + type + count + "_mine' style='width: 100px; text-align: left;'><input type='radio' id='" + type + count + "_mine' name='" + type + "[" + count + "][own]' value='mine' class='' style='float: left;width: 30px;margin-top:4px'> Mine</label>" +
            "<label for='" + type + count + "_spouse' style='width: 100px;text-align: left'><input type='radio' id='" + type + count + "_spouse' name='" + type + "[" + count + "][own]' value='spouse' class='' style='float: left;width: 30px;margin-top:4px'> Spouse</label>" +
            "</div>";
    }else{
        $fields += "<div class='field al-field questions questions-default' data-field='own'>" +
        "<input type='hidden' id='" + type + count + "_mine' name='" + type + "[" + count + "][own]' data-field='own' value='mine' class=''>"+
        "</div>";
    }
        $fields += "<div style='display:none' class='field al-field questions' data-field='do_you_have_a_mortgage_or_lien_on_the_property'>" +
            "<label class='main'>Do you have a mortgage or lien on the property?</label>" +
            "<label for='" + type + count + "_do_you_a_have_mortgage_or_lien_on_the_property_yes' style='width: 100px; text-align: left;'><input type='radio' id='" + type + count + "_do_you_a_have_mortgage_or_lien_on_the_property_yes' name='" + type + "[" + count + "][do_you_a_have_mortgage_or_lien_on_the_property]' value='Yes' class='' style='float: left;width: 30px;margin-top:4px' onClick='liabilityAdd(\"Mortgage\")'> Yes</label>" +
            "<label for='" + type + count + "_do_you_a_have_mortgage_or_lien_on_the_property_no' style='width: 100px;text-align: left'><input type='radio' id='" + type + count + "_do_you_a_have_mortgage_or_lien_on_the_property_no' name='" + type + "[" + count + "][do_you_a_have_mortgage_or_lien_on_the_property]' value='No' class='' style='float: left;width: 30px;margin-top:4px' checked> No</label>" +
            "</div>";
    $fields += "<div class='field al-field questions questions-default' data-field='company'>"+
        "<label for='"+type+count+"_company' class='main'>Company:</label>"+
        "<input type='text' id='"+type+count+"_company' name='"+type+"["+count+"][company]' value='' class=''>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='balance'>"+
        "<label for='"+type+count+"_balance' class='main'>Balance:</label>"+
        "<input type='text' id='"+type+count+"_balance' name='"+type+"["+count+"][balance]' value='' class='currency numericOnly'>"+
        "</div>"+
        "<div style='display:none' class='field al-field questions' data-field='annual_income'>"+
        "<label for='"+type+count+"_cds' class='main'>Annual Income:</label>"+
        "<input type='text' id='"+type+count+"_annual_income' name='"+type+"["+count+"][annual_income]' value='' class='currency numericOnly'>"+
        "</div>"+
        // "<div style='display:none' class='field al-field questions' data-field='income_generated_per_year'>"+
        // "<label for='"+type+count+"_cds' class='main'>Income Generated Per Year:</label>"+
        // "<input type='text' id='"+type+count+"_annual_income' name='"+type+"["+count+"][income_generated_per_year]' value='' class='currency numericOnly'>"+
        // "</div>"+
        "<div class='field al-field questions questions-default' data-field='symbols'>"+
        "<label for='"+type+count+"_symbols' class='main'>Symbols:<a href='javascript:void(0)' id='"+type+count+"_add_symbol' data-type='"+type+"' data-count='"+count+"' class='btn btn-primary' onClick='addSymbol(this)'>+</a></label>"+
        "</div>"+
        "<div class='field al-field questions' data-field='cds' style='display:none'>"+
        "<label for='"+type+count+"_months_remaining'>Months Remaining:</label>"+
        "<input type='text' class='numericOnly' id='"+type+count+"_months_remaining' name='"+type+"["+count+"][months_remaining]'>"+
        "</div>"+
        "<div class='field al-field questions' data-field='cds' style='display:none'>"+
        "<label for='"+type+count+"_dollar_value'>Value:</label>"+
        "<input type='text' class='numericOnly currency' id='"+type+count+"_value' name='"+type+"["+count+"][value]'>"+
        "</div>"+
        "<div class='field al-field questions' data-field='cds' style='display:none'>"+
        "<label for='"+type+count+"_interest_rate'>Interest Rate:</label>"+
        "<input type='text' class='numericOnly percentage' id='"+type+count+"_interest_rate' name='"+type+"["+count+"][interest_rate]'>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='additions'>"+
        "<label for='"+type+count+"_additions' class='main'>Additions per year:</label>"+
        "<input type='text' id='"+type+count+"_additions' name='"+type+"["+count+"][additions]' value='' class='currency numericOnly'>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='withdrawals'>"+
        "<label for='"+type+count+"_withdrawals' class='main'>Withdrawals per year:</label>"+
        "<input type='text' id='"+type+count+"_withdrawals' name='"+type+"["+count+"][withdrawals]' value='' class='currency numericOnly'>"+
        "</div>"+
        "<div style='display:none' class='field al-field questions' data-field='value'>"+
        "<label for='"+type+count+"_value' class='main'>Value:</label>"+
        "<input type='text' id='"+type+count+"_value' name='"+type+"["+count+"][value]' value='' class='numericOnly currency'>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='interest_rate'>"+
        "<label for='"+type+count+"_interest_rate' class='main'>Interest Rate:</label>"+
        "<input type='text' id='"+type+count+"_interest_rate' name='"+type+"["+count+"][interest_rate]' value='' class='percentage numericOnly'>"+
        "</div>"+
        "<div style='display:none' class='field al-field questions' data-field='gowth_rate'>"+
        "<label for='"+type+count+"_gowth_rate' class='main'>Growth Rate:</label>"+
        "<input type='text' id='"+type+count+"_gowth_rate' name='"+type+"["+count+"][gowth_rate]' value='' class='percentage numericOnly'>"+
        "</div>"+
        "<div style='display:none' class='field al-field questions' data-field='annual_premiums'>"+
        "<label for='"+type+count+"_annual_premiums' class='main'>Annual Premiums:</label>"+
        "<input type='text' id='"+type+count+"_annual_premiums' name='"+type+"["+count+"][annual_premiums]' value='' class='currency numericOnly'>"+
        "</div>"+
        "<div style='display:none' class='field al-field questions' data-field='money_going_into_business_per_year'>"+
        "<label for='"+type+count+"_money_going_into_business_per_year' class='main'>Money going into business per year:</label>"+
        "<input type='text' id='"+type+count+"_money_going_into_business_per_year' name='"+type+"["+count+"][money_going_into_business_per_year]' value='' class='currency numericOnly'>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='beneficiary'>"+
        "<label for='"+type+count+"_beneficiary' class='main'>Beneficiary:</label>"+
        "<input type='text' id='"+type+count+"_beneficiary' name='"+type+"["+count+"][beneficiary]' value='' class=''>"+
        "</div>";
    }else if(type == 'liability'){
        $fields =  "<div class='field al-field select-type'>"+
        "<label for='"+type+count+"_liability_type' class='main'>Type:</label>"+
        "<select name='"+type+"["+count+"][liability_type]' onchange='alternateQuestions(this)' id='"+type+count+"_liability_type' data-count='"+count+"' data-type='liability' class='type-dropdown required liability-type'>"+
        "<option value='0' selected disabled>Select type of liability</option>"+
        "<option value='Mortgage'>Mortgage</option>"+
        "<option value='Credit Card'>Credit Card</option>"+
        "<option value='Student Loans'>Student Loans</option>"+
        "<option value='Auto Loan'>Auto Loan</option>"+
        "<option value='Business Loan'>Business Loan</option>"+
        "<option value='Personal Loan'>Personal Loan</option>"+
        "<option value='HELOC'>Home Equity Line of Credit</option>"+
        "<option value='Others'>Others</option>"+
        "</select>"+
        "&nbsp;"+
        "</div>"+
        "<div class='field al-field questions al-others' style='display:none' data-field='liability_others'>"+
        "<label for='"+type+count+"_others' class='main'>Name:</label>"+
        "<input type='text' id='"+type+count+"_others' name='"+type+"["+count+"][others]' value='' class=''>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='liability_owner_debtor'>"+
        "<label for='"+type+count+"_owner_debtor' class='main'>Owner/Debtor:</label>"+
        "<input type='text' id='"+type+count+"_owner_debtor' name='"+type+"["+count+"][owner_debtor]' value='' class=''>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='liability_lender'>"+
        "<label for='"+type+count+"_lender' class='main'>Lender:</label>"+
        "<input type='text' id='"+type+count+"_lender' name='"+type+"["+count+"][lender]' value='' class=''>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='liability_balance'>"+
        "<label for='"+type+count+"_balance' class='main'>Balance:</label>"+
        "<input type='text' id='"+type+count+"_balance' name='"+type+"["+count+"][balance]' value='' class='numericOnly currency'>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='liability_monthly_payment'>"+
        "<label for='"+type+count+"_monthly_payment' class='main'>Monthly Payment:</label>"+
        "<input type='text' id='"+type+count+"_monthly_payment' name='"+type+"["+count+"][monthly_payment]' value='' class='numericOnly currency'>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='liability_interest_rate'>"+
        "<label for='"+type+count+"_interest_rate' class='main'>Interest Rate:</label>"+
        "<input type='text' id='"+type+count+"_interest_rate' name='"+type+"["+count+"][interest_rate]' value='' class='numericOnly percentage'>"+
        "</div>"+
        "<div class='field al-field questions' style='display:none' data-field='liability_loan_term_start'>"+
        "<label for='"+type+count+"_loan_term_start' class='main'>Loan Term (Start):</label>"+
        "<input type='text' id='"+type+count+"_loan_term_start' name='"+type+"["+count+"][loan_term_start]' value='' class='liability-datepicker'>"+
        "</div>"+
        "<div class='field al-field questions questions-default' data-field='liability_loan_term_end' style='display:none'>"+
        "<label for='"+type+count+"_loan_term_end' class='main'>Loan Term (End):</label>"+
        "<input type='text' id='"+type+count+"_loan_term_end' name='"+type+"["+count+"][loan_term_end]' value='' class='liability-datepicker'>"+
        "</div>";
    }else if(type == 'expense'){
        $fields =  "<div class='field al-field'>"+
            "<label for='company' class='main'>Type:</label>"+
            "<select name='"+type+"["+count+"][expense_type]' id='"+type+count+"_expense_type' onchange='javascript:al_others_show(this)' class='type-dropdown required type-dropdown-expense'>"+
            "<option value='0' selected disabled>Select type of expense</option>"+
            "<option value='Home'>Home</option>"+
            "<option value='Home Remodel'>Home Remodel</option>"+
            "<option value='Car'>Car</option>"+
            "<option value='Vacation'>Vacation</option>"+
            "<option value='Second Home'>Second Home</option>"+
            "<option value='Others'>Others</option>"+
            "</select>"+
            "&nbsp;"+
            "</div>";
        $fields    += "<div class='field al-field al-others' style='display:none'>"+
            "<label for='"+type+count+"_others' class='main'>Others:</label>"+
            "<input type='text' id='"+type+count+"_others' name='"+type+"["+count+"][others]' value='' class=''>"+
            "</div>";
        $fields     += "<div class='field al-field'>"+
            "<label for='"+type+count+"_expense_amount' class='main'>Expense Amount:</label>"+
            "<input type='text' id='"+type+count+"_expense_amount' name='"+type+"["+count+"][expense_amount]' value='' class='numericOnly currency'>"+
            "</div>";
        $fields    += "<div class='field al-field'>"+
            "<label for='"+type+count+"_timeframe_start' class='main'>Timeframe (Start):</label>"+
            "<input type='text' id='"+type+count+"_timeframe_start' name='"+type+"["+count+"][timeframe_start]' value='' class='datepicker'>"+
            "</div>";
        $fields     += '<div class="field al-field">'+
                '<label for="'+type+count+'_timeframe_end" class="main">Timeframe (End):</label>'+
                '<select>' +
                '<option value="">Less than 6 months</option>'+
                '<option value="6 months to 1 year">6 months to 1 year</option>'+
                '<option value="1 year to 5 years">1 year to 5 years</option>'+
                '<option value="5 years to 10 years">5 years to 10 years</option>'+
                '<option value="10 years to 20 years">10 years to 20 years</option>'+
                '<option value="20+ years">20+ years</option>'+
                '</select>'+
                '<div>';
        //$fields    += "<div class='field al-field'>"+
        //    "<label for='"+type+count+"_timeframe_end' class='main'>Timeframe (End):</label>"+
        //    "<input type='text' id='"+type+count+"_timeframe_end' name='"+type+"["+count+"][timeframe_end]' value='' class='datepicker'>"+
        //    "</div>";
    }
    else if(type == 'pension'){
        $fields = "<div class='field al-field'>"+
                "<label for='"+type+count+"_pension_type_public' class='main'>Type:</label>"+
                '<label class="" for="'+type+count+'_pension_type_public"><input type="radio" name="pension['+count+'][type]" id="'+type+count+'_pension_type_public" value="Public"> Public</label>'+
                '<label class="" for="'+type+count+'_pension_type_private"><input type="radio" name="pension['+count+'][type]" id="'+type+count+'_pension_type_private" value="Private"> Private</label>'+
            "</div>"+
            "<div class='field al-field'>"+
                "<label for='"+type+count+"_own_yes' class='main'>Owner:</label>"+
                '<label class="" for="'+type+count+'_own_mine"><input type="radio" name="pension['+count+'][own]" id="'+type+count+'_own_mine" value="mine" checked> Mine</label>'+
                '<label class="" for="'+type+count+'_own_spouse"><input type="radio" name="pension['+count+'][own]" id="'+type+count+'_own_spouse" value="spouse"> Spouse</label>'+
            "</div>"+
            "<div class='field al-field'>"+
                "<label for='"+type+count+"_does_it_have_a_cost_of_living_adjustment_yes' class='main'>Does it have a cost of living adjustment?</label>"+
                '<label class="" for="'+type+count+'_does_it_have_a_cost_of_living_adjustment_yes"><input type="radio" name="pension['+count+'][does_it_have_a_cost_of_living_adjustment]" id="'+type+count+'_does_it_have_a_cost_of_living_adjustment_yes" value="Yes"> Yes</label>'+
                '<label class="" for="'+type+count+'_does_it_have_a_cost_of_living_adjustment_no"><input type="radio" name="pension['+count+'][does_it_have_a_cost_of_living_adjustment]" id="'+type+count+'_does_it_have_a_cost_of_living_adjustment_no" value="No"> No</label>'+
            "</div>"+
            "<div class='field al-field'>"+
            "<label for='"+type+count+"_projected_monthly_pension_benefit' class='main'>Monthly Pension Benefit?</label>"+
            "<input type='text' id='"+type+count+"_projected_monthly_pension_benefit' name='"+type+"["+count+"][projected_monthly_pension_benefit]' value='' class='numericOnly currency'>"+
            "</div>"+
            "<div class='field al-field'>"+
                "<label for='"+type+count+"_survivor_benefit_yes' class='main'>Survivor Benefit?</label>"+
                '<label class="" for="'+type+count+'_survivor_benefit_yes"><input type="radio" name="pension['+count+'][survivor_benefit]" id="'+type+count+'_survivor_benefit_yes" value="Yes"> Yes</label>'+
                '<label class="" for="'+type+count+'_survivor_benefit_no"><input type="radio" name="pension['+count+'][survivor_benefit]" id="'+type+count+'_survivor_benefit_no" value="No"> No</label>'+
            "</div>"+
            "<div class='field al-field'>"+
                "<label for='"+type+count+"_what_percent_gets_passed_on' class='main'>What % gets passed on?</label>"+
                '<input type="text" id="'+type+count+'_what_percent_gets_passed_on" name="pension['+count+'][what_percent_gets_passed_on]" class="numericOnly percentage"> '+
            "</div>";
    }else if(type == 'insurance'){
        $fields = '<div class="field ">' +
                    '<label class="main" for="'+type+count+'death_benefit">Death Benefit:</label>'+
                    '<input type="text" name="life_insurance['+count+'][death_benefit]" id="'+type+count+'death_benefit" placeholder="" class="form-control currency numericOnly">'+
                '</div>';

        $fields += '<div class="field ">'+
                    '<label class="main" for="'+type+count+'benefit_type_permanent">Type:</label>'+
                    '<label class="radio-inline" for="'+type+count+'benefit_type_permanent" style="width: 150px; text-align: left;"><input type="radio" name="life_insurance['+count+'][benefit_type]" id="'+type+count+'benefit_type_permanent" value="Permanent" class="insurance_type" style="margin:5px 0 0 0 ;width:30px;position:relative">Permanent</label>'+
                    '<label class="radio-inline" for="'+type+count+'benefit_type_term" style="width: 150px; text-align: left;"><input type="radio" name="life_insurance['+count+'][benefit_type]" id="'+type+count+'benefit_type_term" value="Term" checked="checked" class="insurance_type" style="margin:5px 0 0 0;width:30px;position:relative">Term</label>'+
                    '</div>';

        $fields += '<div id="'+type+count+'benefit_type_permanent_yes">';

        $fields += '<div class="field ">'+
                    '<label class="main" for="'+type+count+'loans" style="width: 150px; text-align: left;"><input type="checkbox" name="life_insurance['+count+'][loans]" id="'+type+count+'loans" value="Yes" style="margin:5px 0 0 0px;width:30px;position:relative">Loans?</label>'+
                    '</div>';
        $fields += '<div class="field ">'+
                    '<label class="main" for="'+type+count+'insurance_company">Company:</label>'+
                    '<input type="text" name="life_insurance['+count+'][insurance_company]" id="'+type+count+'insurance_company" class="form-control">'+
                    '</div>';
        $fields += '<div class="field " id="duration_months">'+
                    '<label class="main" for="'+type+count+'duration">Duration in Months:</label>'+
                    '<input type="text" name="life_insurance['+count+'][duration_in_months]" id="'+type+count+'duration" class="form-control">'+
                    '</div>';
        $fields += '<div class="field ">'+
                    '<label class="main" for="'+type+count+'yearly_premium">Annual Premium:</label>'+
                    '<input type="text" name="life_insurance['+count+'][yearly_premium]" id="'+type+count+'yearly_premium" class="form-control currency">'+
                    '</div>'+
                    '</div>';

        $fields += '<div class="field ">'+
                    '<label class="main" for="'+type+count+'yes_i_have_a_rider">LTC Rider of Accelerated Benefit:</label>'+
                    '<label for="'+type+count+'yes_i_have_a_rider"><input type="radio" name="life_insurance['+count+'][ltc_rider_of_accelerated_benefit]" id="'+type+count+'yes_i_have_a_rider" value="Yes, I have a Rider" style="margin:5px 0 0 0;width:30px;position:relative">Yes, I have a Rider</label><br>'+
                    '<label for="'+type+count+'yes_i_have_accelerated_benefit"><input type="radio" name="life_insurance['+count+'][ltc_rider_of_accelerated_benefit]" id="'+type+count+'yes_i_have_accelerated_benefit" value="Yes, I have Accelerated Benefit" style="margin:5px 0 0 0;width:30px;position:relative">Yes, I have Accelerated Benefit</label><br>'+
                    '<label for="'+type+count+'no_i_dont_know"><input type="radio" name="life_insurance['+count+'][ltc_rider_of_accelerated_benefit]" id="'+type+count+'no_i_dont_know" value="No/I don\'t know" checked="checked" style="margin:5px 0 0 0;width:30px;position:relative">No/I don\'t know</label>'+
                    '</div>';

        //$fields += '<div id="has_rider">'+
        //            '<div class="field">'+
        //            '<label class="main" for="'+type+count+'how_mush_is_the_annual_amount_on_the_rider">How much is the annual amount on the Rider?</label>'+
        //            '<input type="text" name="life_insurance['+count+'][how_mush_is_the_annual_amount_on_the_rider]" id="'+type+count+'how_mush_is_the_annual_amount_on_the_rider" placeholder="Annual amount on the Rider.." class="form-control currency numericOnly">'+
        //            '</div>'+
        //            '</div>';
        $fields += '<div class="field ">'+
                    '<label class="main" for="'+type+count+'cash_value">Cash Value:</label>'+
                    '<input type="text" name="life_insurance['+count+'][cash_value]" id="'+type+count+'cash_value" class="form-control currency" placeholder="Cash amount value">'+
                    '</div>';
        $fields += '<div>'+
                    '<div class="field ">'+
                    '<label class="main" for="'+type+count+'beneficiary">Beneficiary</label>'+
                    '<input type="text" name="life_insurance['+count+'][beneficiary]" id="'+type+count+'beneficiary" placeholder="" class="form-control">'+
                    '</div>'+
                    '</div>';
    }

    $("."+type+"-type-panel").after(
        "<div class='al_fieldset panel panel-default' style='display: none;'>"+
        "<div class='panel-heading'>"+
        "<h4 class='panel-title'>"+
        "<a href='javascript:void(0);' class='clear-panel btn btn-warning'>cancel</a>"+"</h4>"+
        "</div>"+
        "<div id='collapse"+count+"' class='"+type+"-collapse panel-collapse collapse in'>"+
        "<div class='panel-body'>"+
        $fields+
        "</div>"+
        "</div>"
    );
    //alternateQuestions($('#collapse'+count+" .panel-body .select-type select"));
    /*$('#collapse'+count+" panel-body select-type select").each(function(){
        alert($(this).html());
        $(this).find(".select-type").each(function(){
            alert($(this).html());
            alternateQuestions($(this).find('select').val());
        });
    });*/


    /** ==================================================================================
     * Selecting Life Insurance Type
     */
    $('#signup-form input.insurance_type').change(function(){
        var val = $('#signup-form input.insurance_type:checked').val();
        if(val == 'Permanent'){
            $('#duration_months').css({'display': 'none'});
        }else{
            $('#duration_months').css({'display': 'block'});
        }
    });




    /**=====================================================================================
     * Animation and field focus
     =======================================================================================*/
    $("."+type+"-type-panel").siblings('.al_fieldset').show('fast');
    $("#"+type+count+"_asset_type").focus();


    /**================================================================================
     * deletes the liability when the clear link is clicked
     =================================================================================*/
    $('.clear-panel').click(
     function(){
             title=$(this).siblings("."+type+"-title").find("."+type+"-name").html();
             $('#'+type+' option').each(function(){
                 if($(this).val()==title){
                    $(this).prop("disabled",false);
                 }
             });
            $delay_remove = $(this);
             $(this).parents(".panel").hide('fast',function(){
                 $delay_remove.parents(".panel").remove();
             });

            // setTimeout(function(){

            // }, 100);
             $('#'+type).val("0");
            asset_count--;
         }
     );


};

/**======================================================
 * Add Symbols
 *=======================================================*/
$symbol_count = 0;
addSymbol = function(e){
    $add_symbol = $("#"+ e.id);
    $html =
        "<div class='symbol-row' style='display:none'>"+
            "<div class='row'>"+
                "<div class='col-md-4'>"+
                    "<label for='"+$add_symbol.data('type')+"_"+$add_symbol.data('type')+"_"+$symbol_count+"_symbol'><a id='"+$symbol_count+"-delete-symbol' class='delete-symbol' onClick='deleteSymbol(this)'>X</a>Symbol:</label>"+
                    "<input type='text' class='autocomplete' id='"+$add_symbol.data('type')+"_"+$add_symbol.data('type')+"_"+$symbol_count+"_symbol' name='"+$add_symbol.data('type')+"["+$add_symbol.data('count')+"][symbols]["+$symbol_count+"][symbol]'>"+
                "</div>"+
                "<div class='col-md-4'>"+
                    "<label for='"+$add_symbol.data('type')+"_"+$add_symbol.data('type')+"_"+$symbol_count+"_share_price'>Share Price:</label>"+
                    "<input type='text' class='numericOnly currency' id='"+$add_symbol.data('type')+"_"+$add_symbol.data('type')+"_"+$symbol_count+"_symbol' name='"+$add_symbol.data('type')+"["+$add_symbol.data('count')+"][symbols]["+$symbol_count+"][share_price]'>"+
               "</div>"+
                "<div class='col-md-4'>"+
                    "<label for='"+$add_symbol.data('type')+"_"+$add_symbol.data('type')+"_"+$symbol_count+"_number_of_shares'># of shares:</label>"+
                    "<input type='text' class='numericOnly' id='"+$add_symbol.data('type')+"_"+$add_symbol.data('type')+"_"+$symbol_count+"_number_of_shares' name='"+$add_symbol.data('type')+"["+$add_symbol.data('count')+"][symbols]["+$symbol_count+"][number_of_shares]'>"+
                "</div>"+
            "</div>"+
        "</div>";
    $add_symbol.closest('.al-field').append($html);
    $add_symbol.closest('.al-field').find(".symbol-row").last().show('fast');
    activateInputMask();
    $symbol_count++;
};
/**======================================================
 * Delete Symbols
 *=======================================================*/
deleteSymbol = function(e){
    $symbol = $("#"+e.id);
    $symbol.closest(".symbol-row").hide("fast", function(){ $symbol.closest(".symbol-row").remove()});

};


/**======================================================================================
 *  Rental Questions
 ======================================================================================*/
checkFields = function($this,$fields){
    $this.closest('.panel-body').find('.questions').each(
        function(){
            $(this).show();
            if($fields.indexOf($(this).data('field')) < 0){
                $(this).hide();
            }
        }
    );
};
alternateQuestions = function(e){
    $type = (e.id == null)? e : $("#"+ e.id);
    $html = "";
    $liability_group_1 = ['Credit Card','Personal Loan', 'Auto Loan', 'Personal', 'Business Loan', 'HELOC'];
    $asset_group_1 = ["Savings", "Checking"];
    $asset_group_2 = ["Rental", "Home"];
    /**====================================================
    *   for assets
     * ====================================================*/
    if($asset_group_2.indexOf($type.val()) >= 0){
        $show_fields = ["value","do_you_have_a_mortgage_or_lien_on_the_property","annual_income"];
        checkFields($type,$show_fields);
        /*$asset_type.closest('.al-field').after($html);*/
    }else if($type.val() == "Annuity"){
        $show_fields = ["company","value","annual_premiums","growth_rate","additions"];
        checkFields($type,$show_fields);

    }else if($type.val() == "CDs"){
        $show_fields = ["cds"];
        checkFields($type,$show_fields);

    }else if($asset_group_1.indexOf($type.val()) >= 0){
        $show_fields = ["company","balance","additions","withdrawals","interest_rate"];
        checkFields($type,$show_fields);

    }else if($type.val() == "Business"){
        //$show_fields = ["company","value","annual_income","money_going_into_business_per_year"];
        $show_fields = ["company","value","annual_income","money_going_into_business_per_year"];
        checkFields($type,$show_fields);
    }
    /**====================================================
     *   for liabilities
     * ====================================================*/
    else if($type.data('type') == "liability" && $type.val() == "Mortgage"){
        $show_fields = ["liability_owner_debtor","liability_lender","liability_balance","liability_monthly_payment","liability_interest_rate","liability_loan_term_start","liability_loan_term_end"];
        checkFields($type,$show_fields);
    }else if($type.data('type') == "liability" && ($liability_group_1.indexOf($type.val()) >= 0)){
        $show_fields = ["liability_owner_debtor","liability_lender","liability_balance","liability_monthly_payment","liability_interest_rate","liability_loan_term_end"];
        checkFields($type,$show_fields);
    }else if($type.data('type') == "liability" && $type.val() == "Student Loans"){
        $show_fields = ["liability_owner_debtor","liability_lender","liability_balance","liability_monthly_payment","liability_interest_rate"];
        checkFields($type,$show_fields);
    }else if($type.data('type') == "liability" && $type.val() == "Others"){
        $show_fields = ["liability_others","liability_owner_debtor","liability_lender","liability_balance","liability_monthly_payment","liability_interest_rate"];
        checkFields($type,$show_fields);
    }
    else{
        $type.closest('.panel-body').find('.questions').each(function(){
            $(this).hide();
            if($(this).hasClass('questions-default')){
                $(this).show();
            }
        });
    }
    activateInputMask();
};

/**=======================================================================================
 * Show Other Field Function
 * @param $item
 ======================================================================================*/
var al_others_show = function($item){
        $("#"+$item.id).closest(".al-field").siblings(".al-others").each(function(){
            if($("#"+$item.id).val()== "Others") {
                $(this).show('fast');
            }
            else{
                $(this).hide('fast');
            }
        });
    $("#"+$item.id).closest(".al-field").siblings(".questions-rental").each(function(){
        if($("#"+$item.id).val()== "Home") {
            $(this).show('fast');
        }
        else{
            $(this).hide('fast');
        }
    });
    };

/**===================================================================================
 * Input Mask Function
 ==============================================================================**/
$(document).ready(function() {
    //$('.currency').priceFormat({prefix: '$ '});
    ////$('.percentage').priceFormat({prefix: '% '});
    //$('.percentage').mask('%000');
    $('.currency').priceFormat({prefix: '$ ', centsLimit: 0});
    $('.percentage').priceFormat({prefix: '% ', centsLimit: 0});
});


/**========================================
 *
 * Add date picker addon for date inputs
 =========================================*/
var activateInputMask = function(){
    $( ".datepicker" ).datepicker();
    $( ".liability-datepicker" ).datepicker({ dateFormat: 'MM yy' });
    $(".numericOnly").numberOnly();
    //$('.currency').priceFormat({prefix: '$ '});
    ////$('.percentage').priceFormat({prefix: '% '});
    //$('.percentage').mask('%000');
    $('.autocomplete').autocomplete({
        lookup: $investments,
        onSelect: function () {
            $index = $investments.indexOf($(this).val());
            if($index > -1){
                $investments.splice($index, 1);
            }
            $('.autocomplete').autocomplete({
                lookup: $investments});
            /*$('#state').parent().removeClass('invalid');
            $('.fielderrors').hide();*/
        }
    });
    $('.currency').priceFormat({prefix: '$ ', centsLimit: 0});
    $('.percentage').priceFormat({prefix: '% ', centsLimit: 0});
}
    /**=====================================================================
     * executing the function
     ===================================================================*/
    var asset_count = 0;
    var liability_count = 0;
    var expense_count = 0;
    var pension_count = 0;
    var insurance_count = 0;
    $("#asset_add").click(function(){
        al_input("asset",asset_count++)
        activateInputMask();
    });
    liabilityAdd = function($type){
        $liability_count = liability_count;

        if($type != ""){
            if($("option[value="+$type+"]:selected").length == "0"){
                al_input("liability",liability_count++);
            }
            $(".liability-type[data-count="+$liability_count+"]").val($type);
        }else{
            al_input("liability",liability_count++);
        }
        alternateQuestions($(".liability-type[data-count="+$liability_count+"]"));
        activateInputMask();
    };

    $("#liability_add").click(function(){
        liabilityAdd("");
    });

    $("#expense_add").click(function(){
        al_input("expense",expense_count++)
        activateInputMask();
    });
    $("#pension_add").click(function(){
        al_input("pension",pension_count++)
        activateInputMask();
    });


    $('#life_insurance_add').on('click', function(){
        al_input('insurance', insurance_count++);
        activateInputMask();
    });