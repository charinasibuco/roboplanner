<tbody id='children-{{ $children_count }}-tbody' style='display:none;' class='generated'>
<tr>
    <td class='child-name'><a id='child_{{ $children_count }}' onclick='delete_child({{ $children_count }});' class='delete-child delete-link'><i class='fa fa-times' aria-hidden='true'></i> </a>&nbsp;Name:</td>
    <td class='input' id='children-{{ $children_count }}-name'><input class='form-control' type='text' name='children[{{ $children_count }}][name]'></td>
    </tr>
<tr>
    <td>Age:</td>
    <td class='input numericOnly' id='children-{{ $children_count }}-age'><input class='form-control numericOnly' type='text' name='children[{{ $children_count }}][age]'></td>
    </tr>
<tr>
    <td>Do you want a College Plan (below 18 yrs)?</td>
    <td class='input input-radio' id='children-{{ $children_count }}-child_college_plan' data-field='children[{{ $children_count }}][child_college_plan]'>
        <label for='children-{{ $children_count }}-child_college_plan_yes'><input name='children[{{ $children_count }}][child_college_plan]' id='children-{{ $children_count }}-child_college_plan_yes' type='radio' value='Yes'> Yes</label>&nbsp;
        <label for='children-{{ $children_count }}-child_college_plan_no'><input name='children[{{ $children_count }}][child_college_plan]' id='children-{{ $children_count }}-child_college_plan_no' type='radio' value='No'> No</label>
        </td>
    </tr>
</tbody>