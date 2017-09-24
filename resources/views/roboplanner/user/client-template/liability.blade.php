<tbody style='display:none;' class='generated' id="liability-container-{{ $liability_count }}">
        <tr class='select-row'>
            <td class='liability-type-column'><a id='liability_{{ $liability_count }}' href='javascript:delete_liability({{ $liability_count }});' class='delete-link delete-liability'><i class='fa fa-times' aria-hidden='true'></i></a>&nbsp;Type:</td>
            <td class='input input-select liability-type'>
                <select name='liabilities[{{ $liability_count }}][liability_type]' id='liabilities-{{ $liability_count }}-liability_type' class='type-dropdown required form-control'>
                        <option value='0' selected disabled>Select type of liability</option>
                        @foreach($selection as $option)
                                <option value='{{ $option }}'>
                                        {{ $option }}
                                </option>
                        @endforeach
                </select>
            </td>
        </tr>
        <tr class='others-row'>
                <td>Name:</td>
                <td class='input' id='liabilities-{{ $liability_count }}-others' data-field='liabilities[{{ $liability_count }}][others]'><input type='text' class='form-control' name='liabilities[{{ $liability_count }}][others]'></td>
        </tr>
        <tr>
                <td>Owner/Debtor:</td>
                <td class='input' id='assets-{{ $liability_count }}-owner_debtor' data-field='liabilities[{{ $liability_count }}][owner_debtor]'><input type='text' class='form-control'  name='liabilities[{{ $liability_count }}][owner_debtor]'></td>
        </tr>
        <tr>
                <td>Bank:</td>
                <td class='input' id='assets-{{ $liability_count }}-bank' data-field='liabilities[{{ $liability_count }}][bank]'><input type='text' class='form-control' name='liabilities[{{ $liability_count }}][bank]'></td>
        </tr>
        <tr>
                <td>Balance:</td>
                <td class='input currency' id='assets-{{ $liability_count }}-balance' data-field='liabilities[{{ $liability_count }}][balance]'><input type='text' class='form-control currency' name='liabilities[{{ $liability_count }}][balance]'></td>
        </tr>
        <tr>
                <td>Monthly Payment:</td>
                <td class='input currency' id='assets-{{ $liability_count }}-monthly_payment' data-field='liabilities[{{ $liability_count }}][monthly_payment]'><input type='text' class='form-control currency' name='liabilities[{{ $liability_count }}][monthly_payment]'></td>
        </tr>
        <tr>
                <td>Interest Rate:</td>
                <td class='input' id='assets-{{ $liability_count }}-interest_rate' data-field='liabilities[{{ $liability_count }}][interest_rate]'><input type='text' class='form-control currency' name='liabilities[{{ $liability_count }}][interest_rate]'></td>
        </tr>
        <tr>
                <td>Loan Term (Start):</td>
                <td class='input' id='assets-{{ $liability_count }}-loan_term_start' data-field='liabilities[{{ $liability_count }}][loan_term_start]'><input type='text' class='form-control datepicker' name='liabilities[{{ $liability_count }}][loan_term_start]'></td>
        </tr>
        <tr>
                <td>Loan Term ( End):</td>
                <td class='input' id='assets-{{ $liability_count }}-loan_term_end' data-field='liabilities[{{ $liability_count }}][loan_term_end]'><input type='text' class='form-control datepicker' name='liabilities[{{ $liability_count }}][loan_term_end]'></td>
        </tr>
</tbody>