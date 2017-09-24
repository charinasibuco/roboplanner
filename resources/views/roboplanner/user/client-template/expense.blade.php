 <tbody id='expenses-{{ $expense_count }}-tbody' style='display:none;' class='generated'>
     <tr class='select-row'>
          <td class='expense-type expense-type-column'><a id='expense_{{ $expense_count }}' href='javascript:delete_expense({{ $expense_count }});' class='delete-link delete-expense'><i class='fa fa-times' aria-hidden='true'></i> </a>&nbsp;Type:</td>
          <td id='expenses-{{ $expense_count }}-type' class='input input-select expense-type'>
               <select name='expenses[{{ $expense_count }}][expense_type]' id='expenses[{{ $expense_count }}][expense_type]' class='type-dropdown required form-control'>
                    <option value='0' selected disabled>Select type of expense</option>
                    <option value='Home'>Home</option>
                    <option value='Home Remodel'>Home Remodel</option>
                    <option value='Car'>Car</option>
                    <option value='Vacation'>Vacation</option>
                    <option value='Second Home'>Second Home</option>
                    <option value='Others'>Others</option>
               </select>
          </td>
     </tr>
     <tr class='others-row'>
          <td>Name:</td>
          <td class='input' id='expenses-{{ $expense_count }}-others' data-field='expenses[{{ $expense_count }}][others]'><input type='text' class='form-control' name='expenses[{{ $expense_count }}][others]'></td>
     </tr>
     <tr>
          <td>Expense Amount:</td>
          <td class='input' id='expenses-{{ $expense_count }}-expense_amount' data-field='expenses[{{ $expense_count }}][expenses_amount]'><input type='text' class='form-control currency' name='expenses[{{ $expense_count }}][expense_amount]'></td>
     </tr>
     <tr>
          <td>Timeframe (Start):</td>
          <td class='input currency' id='expenses-{{ $expense_count }}-timeframe_start' data-field='expenses[{{ $expense_count }}][timeframe_start]'><input type='text' class='form-control datepicker' name='expenses[{{ $expense_count }}][timeframe_start]'></td>
     </tr>
     <tr>
          <td>Timeframe (End):</td>
          <td class='input currency' id='expenses-{{ $expense_count }}-timeframe_end' data-field='expenses[{{ $expense_count }}][timeframe_end]'><input type='text' class='form-control datepicker' name='expenses[{{ $expense_count }}][timeframe_end]'></td>
     </tr>
</tbody>