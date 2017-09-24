@if(!isset($vitem) || isset($vitem->asset_type))
    <tbody @if(!isset($vitem)) style='display:none;' @endif class='generated ' id='asset-container-{{ $asset_count }}'>
        <tr class='select-row'>
            <td class='asset-type asset-type-column'><a id='asset_{{ $asset_count }}' @if(isset($vitem)) style="display:none" @endif href="javascript:void(0)" onclick='delete_asset($(this))'  class='delete-link delete-asset'><i class='fa fa-times' aria-hidden='true'></i> </a>&nbsp;Type:</td>
            <td id='assets-{{ $asset_count }}-asset_type' class='input input-select asset-type' data-field='assets[{{ $asset_count }}][asset_type]'>

               @if(isset($vitem))
                    <?php $asset_type = isset($vitem->asset_type)?$vitem->asset_type:"None"; ?>
                    {{ ($asset_type == '401k' && $vitem->own == 'spouse') ? '403(b)' : $asset_type  }}
                @else
                    <select required name='assets[{{ $asset_count }}][asset_type]' data-count='{{ $asset_count }}' id='assets-{{ $asset_count }}-asset_type' class='type-dropdown required form-control' onchange='assets_fields(this.value, this.id)'>
                        <option value='0' selected disabled>Select type of asset</option>
                        <option value='IRA'>IRA</option>
                        <option value='Home'>Home</option>
                        <option value='Rental'>Rental Properties</option>
                        <option value='401k'>401(k)</option>
                        <option value='403b'>403(b)</option>
                        <option value='Brokerage'>Brokerage Acct.</option>
                        <option value='Annuity'>Annuity</option>
                        <option value='529Plan'>529 Plan</option>
                        <option value='Coverdell'>Coverdell</option>
                        <option value='UTMA'>UTMA</option>
                        <option value='UGMA'>UGMA</option>
                        <option value='Simple'>Simple</option>
                        <option value='SEP'>SEP</option>
                        <option value='Roth'>Roth</option>
                        <option value='CDs'>CDs</option>
                        <option value='Savings'>Savings</option>
                        <option value='Checking'>Checking</option>
                        <option value='Business'>Business</option>
                    </select>
                @endif
            </td>
        </tr>
        <tr id="asset-{{ $asset_count }}-own">
            <td>Own Asset:</td>
            <td class='input input-radio asset_own' data-field='assets[{{ $asset_count }}][own]' id='assets-{{ $asset_count }}-own'>
                @if(isset($vitem))
                    {{ $vitem->own or '' }}
                   @else
                    <label for='assets-{{ $asset_count }}-mine'><input type='radio' name='assets[{{ $asset_count }}][own]' id='assets-{{ $asset_count }}-mine'  @if(!isset($vitem) || (isset($vitem) && $vitem->own == "mine")) checked @endif value='mine' /> Mine</label>
                    <label for='assets-{{ $asset_count }}-spouse'><input type='radio' name='assets[{{ $asset_count }}][own]' id='assets-{{ $asset_count }}-spouse' value='spouse' @if(isset($vitem) && $vitem->own == "spouse") checked @endif /> Spouse</label>
                @endif
            </td>
        </tr>
        <?php
            $vitem = isset($vitem)?$vitem:null;
            $asset_type = isset($vitem->asset_type)?$vitem->asset_type:null;
            $count_symbols = isset($count_symbols)?$count_symbols:null;
        ?>
        @include("roboplanner.user.client-template.asset_field",["asset_count" => $asset_count,"vitem" => $vitem, "asset_type" => $asset_type, "count_symbols" => $count_symbols])
    </tbody>
@endif