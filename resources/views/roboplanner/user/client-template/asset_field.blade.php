@if($asset_type == 'IRA' || $asset_type == '401k' || $asset_type == '403b' || $asset_type == 'Brokerage' || $asset_type == '529Plan' || $asset_type == 'Coverdell' || $asset_type == 'UTMA' || $asset_type == 'UGMA' || $asset_type == 'Simple' || $asset_type == 'SEP' || $asset_type == 'Roth')
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Company:</td>
        <td class='input' data-field='assets[{{ $asset_count }}][company]'>
            @if(isset($vitem))
                {{ $vitem->company or "" }}
            @else
                <input type='text' class='form-control' name='assets[{{ $asset_count }}][company]'>
            @endif
        </td>
    </tr>
    <tr id='balance-row-{{ $asset_count }}' class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Balance:</td>
        <td class='input currency' id='assets-{{ $asset_count }}-balance' data-field='assets[{{ $asset_count }}][balance]'>
            @if(isset($vitem))
                {{ $vitem->balance or 0 }}
            @else
                <input type='text' class='form-control currency' name='assets[{{ $asset_count }}][balance]'>
            @endif
        </td>
    </tr>
    <tr id='base-symbol-{{ $asset_count }}' class='base-symbol-btn assets-{{ $asset_count }}-asset_type_fields'>
        <td>Symbols:</td>
        <td><a @if(isset($vitem)) style="display:none" @endif id='asset{{ $asset_count }}_add_symbol' class='delete-link btn btn-primary' href='javascript:void(0)' data-type='asset' data-count='0' onclick='addSymbol({{ $asset_count }})'>+</a>
        </td>
    </tr>
    @if(isset($vitem) && isset($vitem->symbols))
        @foreach($vitem->symbols as $k => $v)
            @if(isset($v->share_price) && isset($v->symbol) && isset($v->number_of_shares))
                <?php $count_symbols ++; ?>
                @include("roboplanner.user.client-template.symbol",["v" => $v,"e" => $asset_count, "symbol_count" => $count_symbols ])
            @endif
        @endforeach
    @endif
     <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Additions:</td>
        <td class='input currency' data-field='assets[{{ $asset_count }}][additions]'>
            @if(isset($vitem))
                {{ $vitem->additions or 0 }}
            @else
                <input type='text' class='form-control currency' name='assets[{{ $asset_count }}][additions]'>
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Withdrawals:</td>
        <td class='input currency' data-field='assets[{{ $asset_count }}][withdrawals]'>
            @if(isset($vitem))
                {{ $vitem->withdrawals or 0 }}
            @else
                <input type='text' class='form-control currency' name='assets[{{ $asset_count }}][withdrawals]'>
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Interest Rate:</td>
        <td class='input percentage' data-field='assets[{{ $asset_count }}][interest_rate]'>
            @if(isset($vitem))
                {{ $vitem->interest_rate or 0 }}
            @else
                <input type='text' class='form-control percentage' name='assets[{{ $asset_count }}][interest_rate]'>
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Beneficiary:</td>
        <td class='input' data-field='assets[{{ $asset_count }}][beneficiary]'>
            @if(isset($vitem))
                {{ $vitem->beneficiary or ""  }}
            @else
                <input type='text' class='form-control' name='assets[{{ $asset_count }}][beneficiary]'>
            @endif

        </td>
    </tr>
@elseif($asset_type == 'Rental' || $asset_type == 'Home')
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Do you have a mortgage or lien on the property?</td>
        <td class='input input-radio mortgage' id='asset{{ $asset_count }}_do_you_a_have_mortgage_or_lien_on_the_property' data-field='assets[{{ $asset_count }}][do_you_a_have_mortgage_or_lien_on_the_property]'>
            @if(isset($vitem))
                {{ $vitem->do_you_a_have_mortgage_or_lien_on_the_property or "No" }}
            @else
                <label for='asset{{ $asset_count }}_do_you_a_have_mortgage_or_lien_on_the_property_yes'>
                    <input id='asset{{ $asset_count }}_do_you_a_have_mortgage_or_lien_on_the_property_yes'
                       class='mortgage_choices' name='assets[{{ $asset_count }}][do_you_a_have_mortgage_or_lien_on_the_property]'
                       value='Yes'
                       {{--onclick='liabilityAdd("Mortgage")'--}}
                       type='radio'
                        @if(isset($vitem) && $vitem->do_you_a_have_mortgage_or_lien_on_the_property == "Yes" ) checked @endif
                    > Yes</label>&nbsp;
                <label for='asset{{ $asset_count }}_do_you_a_have_mortgage_or_lien_on_the_property_no'>
                    <input id='asset{{ $asset_count }}_do_you_a_have_mortgage_or_lien_on_the_property_no'
                       class='mortgage_choices'
                       name='assets[{{ $asset_count }}][do_you_a_have_mortgage_or_lien_on_the_property]'
                       value='No'
                       {{--onclick='liabilityAdd("")' --}}
                       type='radio'
                       @if(!isset($vitem) || (isset($vitem) && $vitem->do_you_a_have_mortgage_or_lien_on_the_property == "No" )) checked @endif
                    > No</label>
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for='asset{{ $asset_count }}_value'>Value:</label></td>
        <td class='input' currency data-field='assets[{{ $asset_count }}][value]'>
              @if(isset($vitem))
                {{ $vitem->value or 0 }}
            @else
                <input type='text' id='asset{{ $asset_count }}_value' name='assets[{{ $asset_count }}][value]' class='currency form-control' />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for='asset{{ $asset_count }}_annual_income'>Annual Income:</label></td>
        <td class='input currency' data-field='assets[{{ $asset_count }}][annual_income]'>
            @if(isset($vitem))
                {{ $vitem->annual_income or 0 }}
            @else
                <input type=text id='asset{{ $asset_count }}_annual_income' name='assets[{{ $asset_count }}][annual_income]' class='currency form-control' />
            @endif
        </td>
    </tr>

@elseif($asset_type == 'Annuity')
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset{{ $asset_count }}_company">Company:</label></td>
        <td class="input" data-field="assets[{{ $asset_count }}][company]">
            @if(isset($vitem))
                {{ $vitem->company or ""  }}
            @else
                <input type="text" id="asset{{ $asset_count }}_company" name="assets[{{ $asset_count }}][company]" class="input form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset{{ $asset_count }}_value">Additions Per Year:</label></td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][additions]">
            @if(isset($vitem))
                {{ $vitem->additions or 0 }}
            @else
                <input type="text" id="asset{{ $asset_count }}_additions" name="assets[{{ $asset_count }}][additions]" class="currency form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset{{ $asset_count }}_value">Value:</label></td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][value]">
            @if(isset($vitem))
                {{ $vitem->value or 0 }}
            @else
                <input type="text" id="asset{{ $asset_count }}_value" name="assets[{{ $asset_count }}][value]" class="currency form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset{{ $asset_count }}_annual_premiums">Annual Premiums:</label></td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][annual_premiums]">
            @if(isset($vitem))
                {{ $vitem->annual_premiums or 0  }}
            @else
                <input type="text" id="asset{{ $asset_count }}_annual_premiums" name="assets[{{ $asset_count }}][annual_premiums]" class="currency form-control" />
            @endif
        </td>
    </tr>
@elseif($asset_type == 'Savings' || $asset_type == 'Checking')
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset-{{ $asset_count }}-company">Company:</label></td>
        <td class="input" data-field="assets[{{ $asset_count }}][company]">
            @if(isset($vitem))
                {{ $vitem->company or "" }}
            @else
                <input type="text" id="asset-{{ $asset_count }}-company" name="assets[{{ $asset_count }}][company]" class="input form-control" />
            @endif
        </td>
    </tr>
     <tr id='balance-row-{{ $asset_count }}' class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset-{{ $asset_count }}-balance">Balance:</label></td>
        <td class='input currency' id='assets-{{ $asset_count }}-balance' data-field='assets[{{ $asset_count }}][balance]'>
            @if(isset($vitem))
                {{ $vitem->balance or 0 }}
            @else
                <input type='text' class='form-control currency' name='assets[{{ $asset_count }}][balance]'>
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset-{{ $asset_count }}-value">Additions Per Year:</label></td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][additions]">
            @if(isset($vitem))
                {{ $vitem->additions or 0 }}
            @else
                <input type="text" id="asset-{{ $asset_count }}-additions" name="assets[{{ $asset_count }}][additions]" class="currency form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset-{{ $asset_count }}-withdrawals">Withdrawals Per Year:</label></td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][withdrawals]">
            @if(isset($vitem))
                {{ $vitem->withdrawals or 0 }}
            @else
                <input type="text" id="asset-{{ $asset_count }}-withdrawals" name="assets[{{ $asset_count }}][withdrawals]" class="currency form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset-{{ $asset_count }}-interest_rate">Interest Rate:</label></td>
        <td class="input percentage" data-field="assets[{{ $asset_count }}][interest_rate]">
            @if(isset($vitem))
                {{ $vitem->interest_rate or 0 }}
            @else
                <input type="text" id="asset-{{ $asset_count }}-interest_rate" name="assets[{{ $asset_count }}][interest_rate]" class="currency form-control" />
            @endif
        </td>
    </tr>
@elseif($asset_type == 'CDs')
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Months Remaining:</td>
        <td class="input numericOnly" data-field="assets[{{ $asset_count }}][months_remaining]">
            @if(isset($vitem))
                {{ $vitem->months_remaining or 0  }}
            @else
                <input type="text" id="asset{{ $asset_count }}_months_remaining" name="assets[{{ $asset_count }}][months_remaining]" class="numericOnly form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Value:</td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][value]">
            @if(isset($vitem))
                {{ $vitem->value or 0  }}
            @else
                <input type="text" id="asset{{ $asset_count }}_value" name="assets[{{ $asset_count }}][value]" class="currency form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Interest Rate:</td>
        <td class="input percentage" data-field="assets[{{ $asset_count }}][interest_rate]">
            @if(isset($vitem))
                {{ $vitem->interest_rate or 0 }}
            @else
                <input type="text" id="asset{{ $asset_count }}_interest_rate" name="assets[{{ $asset_count }}][interest_rate]" class="percentage form-control" />
            @endif
        </td>
    </tr>
@elseif($asset_type == 'Business')
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td><label for="asset-{{ $asset_count }}-company">Company:</label></td>
        <td class="input" data-field="assets[{{ $asset_count }}][company]">
            @if(isset($vitem))
                {{ $vitem->company or "" }}
            @else
                <input type="text" id="asset-{{ $asset_count }}-company" name="assets[{{ $asset_count }}][company]" class="input form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Value:</td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][value]">
            @if(isset($vitem))
                {{ $vitem->value or 0  }}
            @else
                <input type="text" id="asset{{ $asset_count }}_value" name="assets[{{ $asset_count }}][value]" class="currency form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Income Generated Per Year:</td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][annual_income]">
            @if(isset($vitem))
                {{ $vitem->annual_income or 0  }}
            @else
                <input type="text" id="asset{{ $asset_count }}_annual_income" name="assets[{{ $asset_count }}][annual_income]" class="currency form-control" />
            @endif
        </td>
    </tr>
    <tr class="assets-{{ $asset_count }}-asset_type_fields">
        <td>Money going Into Business Per Year:</td>
        <td class="input currency" data-field="assets[{{ $asset_count }}][interest_rate]">
            @if(isset($vitem))
                {{ $vitem->interest_rate or 0 }}
            @else
                <input type="text" id="asset{{ $asset_count }}_interest_rate" name="assets[{{ $asset_count }}][interest_rate]" class="currency form-control" />
            @endif
        </td>
    </tr>

@endif