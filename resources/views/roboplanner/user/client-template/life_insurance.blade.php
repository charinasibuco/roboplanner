<tbody @if(!isset($insurance)) style="display:none;" @endif class="generated" id="life-insurance-container-{{ $insurance_count }}">
    <tr> 
        <td class="life_insurance-type-column">
            
                <a @if(isset($insurance)) style="display:none;" @endif id="insurance_{{ $insurance_count }}" onclick="delete_insurance($(this));" class="delete-insurance delete-link" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i></a>
            
            Type:</td> 
        <td class="input input-radio benefit_type" data-field="benefit_type"> 
            @if(isset($insurance))
                {{ $insurance->benefit_type or "" }}
            @else
                <label for="benefit_type_{{ $insurance_count }}_p"><input type="radio" onclick="insuranceTerm(this)" name="life_insurance[{{ $insurance_count }}][benefit_type]" id="benefit_type_{{ $insurance_count }}_p" class="insurance_  $insurance_count  _type_choices" value="Permanent" /> Permanent</label> &nbsp;
                <label for="benefit_type_{{ $insurance_count }}_t"><input type="radio" onclick="insuranceTerm(this)" name="life_insurance[{{ $insurance_count }}][benefit_type]" id="benefit_type_{{ $insurance_count }}_t" class="insurance_  $insurance_count  _type_choices" value="Term" checked /> Term</label>
            @endif
        </td> 
    </tr> 
    <tr> 
        <td>Loans:</td> 
        <td class="input input-checkbox" data-field="loans" data-count = "{{ $insurance_count }}">
            @if(isset($insurance))
                {{ $insurance->loans or "" }}
            @else
                <label for="loans_{{ $insurance_count }}"><input type="checkbox" id="loans_{{ $insurance_count }}" name="life_insurance[{{ $insurance_count }}][loans]" value="Yes" /> Loans?</label>
            @endif
        </td>
    </tr> 
    <tr> 
        <td>Death Benefit:</td> 
        <td class="input percentage" data-field="death_benefit">
            @if(isset($insurance))
                {{ $insurance->death_benefit or 0 }}
            @else
                <input class="form-control percentage" type="text" name="life_insurance[{{ $insurance_count }}][death_benefit]" />
            @endif
        </td>
    </tr>
    <tr class="hidden-row insurance-duration" id="duration_{{ $insurance_count }}" data-hidden="benefit_type">
        <td>Duration in Months</td> 
        <td class="input numericOnly" data-field="duration_in_months">
            @if(isset($insurance))
                {{ $insurance->duration_in_months or 0 }}
            @else
                <input type="text" class="form-control" name="life_insurance[{{ $insurance_count }}][duration_in_months]" />
            @endif
        </td> 
    </tr>
    <tr>
        <td>Annual Premium</td>
        <td class="input currency" data-field="yearly_premium">
            @if(isset($insurance))
                {{ $insurance->yearly_premium or 0 }}
            @else
                <input type="text" class="form-control currency" name="life_insurance[{{ $insurance_count }}][yearly_premium]" />
            @endif
        </td> 
    </tr>
    <tr>
        <td>Cash Value:</td>
        <td class="input currency" data-field="cash_value">
            @if(isset($insurance))
                {{ $insurance->cash_value or 0 }}
            @else
                <input type="text" name="life_insurance[{{ $insurance_count }}][cash_value]" class="form-control currency" />
            @endif
        </td>
    </tr>
    <tr> 
        <td>Beneficiary:</td>
        <td class="input" data-field="beneficiary">
            @if(isset($insurance))
                {{ $insurance->beneficiary or "" }}
            @else
                <input type="text" class="form-control" name="life_insurance[{{ $insurance_count }}][beneficiary]" />
            @endif
        </td>
    </tr>
</tbody>