@if(auth()->user()->customer->plan != null)
<div class="fixed-plugin" id="softphone" style="display: none;">
    <div
        class="dropdown show-dropdown"
        v-bind:class="{show: isActive}"
    >

        <a v-on:click="showSoftphone">
            <i class="fa fa-phone fa-3x"> </i>
        </a>
        <ul
            class="dropdown-menu"
            v-bind:class="{show: isActive}"
        >
            <li class="header-title"> {{ __('Ramal') }}</li>
            <li style="width: 100%;">
                <?php $i = 1; ?>
                <table style="">
                    <tr>
                        <td colspan="3">
                            <input class="form-control" id="softphoneDisplay" name="softphoneDisplay" />
                        </td>
                    </tr>
                    <tr class="softphoneNumbers">
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(1)">{{$i++}}</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(2)">{{$i++}}</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(3)">{{$i++}}</button></td>
                    </tr>
                    <tr class="softphoneNumbers">
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(4)">{{$i++}}</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(5)">{{$i++}}</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(6)">{{$i++}}</button></td>
                    </tr>
                    <tr class="softphoneNumbers">
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(7)">{{$i++}}</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(8)">{{$i++}}</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(9)">{{$i++}}</button></td>
                    </tr>
                    <tr class="softphoneNumbers">
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf('#')">#</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf(0)">0</button></td>
                        <td class="softphoneNumbers"><button class="softphone" v-on:click="dtmf('*')">*</button></td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>
</div>
@endif
