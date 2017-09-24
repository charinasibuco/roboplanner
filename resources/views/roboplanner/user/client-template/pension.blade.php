<tbody @if(!isset($pension)) style="display:none;" @endif id='pensions-{{ $pension_count }}-tbody' class='pension generated'>
    <tr>
        <td class='pension-type pension-type-column'>
            <a @if(isset($pension)) style="display:none;" @endif id='pension_{{ $pension_count }}' onclick='delete_pension({{ $pension_count }})' class='delete-pension delete-link' href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i></a>
            &nbsp;Type:
        </td>
        <td class='input input-radio type' id='pensions-{{ $pension_count }}-type' data-field='pension[{{ $pension_count }}][type]'>
            @if(isset($pension))
                {{ $pension->type or "" }}
            @else
                <label for='pensions-{{ $pension_count }}-type_public'><input id='pensions-{{ $pension_count }}-type_public' name='pension[{{ $pension_count }}][type]' type='radio' value='Public'> Public</label>&nbsp;
                <label for='pensions-{{ $pension_count }}-type_private'><input id='pensions-{{ $pension_count }}-type_private' name='pension[{{ $pension_count }}][type]' type='radio' value='Private'> Private</label>
            @endif
        </td>
    </tr>



     <tr>
        <td>Owner:</td>
        <td class='input input-radio pension_own' id='pensions-{{ $pension_count }}-own' data-field='pension[{{ $pension_count }}][own]'>
            @if(isset($pension))
                {{ $pension->own or "mine" }}
            @else
                <label for='pensions-{{ $pension_count }}-own_mine'><input name='pension[{{ $pension_count }}][own]' id='pensions-{{ $pension_count }}-own_mine' type='radio' value='mine' checked> Mine</label>&nbsp;
                <label for='pensions-{{ $pension_count }}-own_spouse'><input name='pension[{{ $pension_count }}][own]' id='pensions-{{ $pension_count }}-own_spouse' type='radio' value='spouse'> Spouse</label>
            @endif
        </td>
    </tr>



    <tr>
        <td>Does it have a cost of living adjustment?</td>
        <td class='input input-radio' id='pensions-{{ $pension_count }}-does_it_have_a_cost_of_living_adjustment' data-field='pension[{{ $pension_count }}][does_it_have_a_cost_of_living_adjustment]'>
            @if(isset($pension))
                {{ $pension->does_it_have_a_cost_of_living_adjustment or "No" }}
            @else
                <label for='pensions-{{ $pension_count }}-does_it_have_a_cost_of_living_adjustment_yes'><input name='pension[{{ $pension_count }}][does_it_have_a_cost_of_living_adjustment]' id='pensions-{{ $pension_count }}-does_it_have_a_cost_of_living_adjustment_yes' type='radio' value='Yes'> Yes</label>&nbsp;
                <label for='pensions-{{ $pension_count }}-does_it_have_a_cost_of_living_adjustment_no'><input name='pension[{{ $pension_count }}][does_it_have_a_cost_of_living_adjustment]' id='pensions-{{ $pension_count }}-does_it_have_a_cost_of_living_adjustment_no' type='radio' value='No'> No</label>
            @endif
        </td>
    </tr>
    <tr>
        <td>Projected monthly pension benefit:</td>
        <td class='input currency' id='pensions-{{ $pension_count }}-projected_monthly_pension_benefit' data-field='pension[{{ $pension_count }}][projected_monthly_pension_benefit]'>
            @if(isset($pension))
                {{ $pension->projected_monthly_pension_benefit or "" }}
            @else
                <input type='text' class='form-control currency' name='pension[{{ $pension_count }}][projected_monthly_pension_benefit]'>
            @endif
        </td>
    </tr>
    {{--<tbody>--}}
    <tr class="radio-row" data-hidden="survivor_benefit_{{ $pension_count }}">
        <td>Survivor Benefit?</td>
        <td class='input input-radio' id='pensions-{{ $pension_count }}-survivor_benefit' data-field='pension[{{ $pension_count }}][survivor_benefit]'>
            @if(isset($pension))
                {{ $pension->survivor_benefit or "No" }}
            @else
                <label for='pensions-{{ $pension_count }}-survivor_benefit_yes'><input name='pension[{{ $pension_count }}][survivor_benefit]' id='pensions-{{ $pension_count }}-survivor_benefit_yes' type='radio' value='Yes' checked> Yes</label>&nbsp;
                <label for='pensions-{{ $pension_count }}-survivor_benefit_no'><input name='pension[{{ $pension_count }}][survivor_benefit]' id='pensions-{{ $pension_count }}-survivor_benefit_no' type='radio' value='No'> No</label>
            @endif
        </td>
    </tr>

    <tr class="hidden-row" data-hidden="survivor_benefit_{{ $pension_count }}">
        <td>What % gets passed on?</td>
        <td class='input percentage' id='pensions-{{ $pension_count }}-what_percent_gets_passed_on' data-field='pension[{{ $pension_count }}][what_percent_gets_passed_on]'>
            @if(isset($pension))
                {{ $pension->what_percent_gets_passed_on or 0 }}
            @else
                <input type="text" id="pensions-{{ $pension_count }}-what_percent_gets_passed_on" name="pension[{{ $pension_count }}][what_percent_gets_passed_on]" class="form-control percentage">
            @endif
        </td>
    </tr>
</tbody>