
<tr class="symbol-row-{{ $e }}-{{ $symbol_count }}">
    <td><a @if(isset($v)) style="display:none" @endif id="{{ $symbol_count }}-delete-symbol" class="delete-symbol delete-link" onClick="deleteSymbol({{ $e }},{{ $symbol_count }})" href="javascript:void(0)">X</a> &nbsp;Symbol:</td>
    <td class="input symbols required" data-field="assets[{{ $e }}][symbols][{{ $symbol_count }}][symbol]">
        @if(isset($v))
            {{ $v->symbol or "" }}
        @else
            <input type="text" name="assets[{{ $e }}][symbols][{{ $symbol_count }}][symbol]" id="assets-{{ $e }}-symbols-{{ $symbol_count }}-symbol" class="symbols form-control" required />
        @endif
    </td>
</tr>
<tr class="symbol-row-{{ $e }}-{{ $symbol_count }}">
    <td>Share Price:</td>
    <td class="input currency" data-field="assets[{{ $e }}][symbols][{{ $symbol_count }}][share_price]">
        @if(isset($v))
            {{ $v->share_price or 0 }}
        @else
            <input type="text" name="assets[{{ $e }}][symbols][{{ $symbol_count }}][share_price]" id="assets-{{ $e }}-symbols-{{ $symbol_count }}-share_price" class="currency form-control share-price" />
        @endif
    </td>
</tr>
<tr class="symbol-row-{{ $e }}-{{ $symbol_count }}">
    <td>Number of Shares:</td>
    <td class="input numericOnly" data-field="assets[{{ $e }}][symbols][{{ $symbol_count }}][number_of_shares]">
        @if(isset($v))
            {{ $v->number_of_shares or 0 }}
        @else
            <input type="text" name="assets[{{ $e }}][symbols][{{ $symbol_count }}][number_of_shares]" id="assets-{{ $e }}-symbols-{{ $symbol_count }}-number_of_shares" class="numericOnly form-control" />
        @endif
    </td>
</tr>

