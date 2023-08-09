<template>
    <div class="row">
        <div class="col">
            <input type="button" @click="logout()" value="logout" class="m-1" />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <select v-model="from" class="m-1">
                <option
                    v-for="option in options"
                    class="w-100"
                >
                    {{ option }}
                </option>
            </select>
            <input type="text" v-model="value" class="w-100 m-1" />
        </div>
        <div class="col-sm-6">
            <select v-model="to" class="m-1">
                <option
                    v-for="option in options"
                    class="w-100"
                >
                    {{ option }}
                </option>
            </select>
            <input type="text" v-model="convertedValue" class="w-100 m-1" disabled />
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="button" @click="convert()" value="convert" class="m-1" />
        </div>
    </div>
</template>

<script>
import Overview from "./Home/Overview.vue";
import Register from "./Login/Register.vue";
import Menu from "./Partials/Menu.vue";
export default {
    components: {
        Overview,
        Register,
        Menu
    },
    data () {
        return {
            selected: '',
            from: 'EUR',
            to: 'AWG',
            value: 0,
            convertedValue: 0,
            options: [
                'AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BDT','BGN','BHD','BIF','BMD','BND','BOB','BRL','BSD','BTC','BTN','BWP','BYN','BYR','BZD','CAD','CDF','CHF','CLF','CLP','CNY','COP','CRC','CUC','CUP','CVE','CZK','DJF','DKK','DOP','DZD','EGP','ERN','ETB','EUR','FJD','FKP','GBP','GEL','GGP','GHS','GIP','GMD','GNF','GTQ','GYD','HKD','HNL','HRK','HTG','HUF','IDR','ILS','IMP','INR','IQD','IRR','ISK','JEP','JMD','JOD','JPY','KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD','KZT','LAK','LBP','LKR','LRD','LSL','LTL','LVL','LYD','MAD','MDL','MGA','MKD','MMK','MNT','MOP','MRO','MUR','MVR','MWK','MXN','MYR','MZN','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB','RWF','SAR','SBD','SCR','SDG','SEK','SGD','SHP','SLE','SLL','SOS','SSP','SRD','STD','SYP','SZL','THB','TJS','TMT','TND','TOP','TRY','TTD','TWD','TZS','UAH','UGX','USD','UYU','UZS','VEF','VES','VND','VUV','WST','XAF','XCD','XDR','XOF','XPF','YER','ZAR','ZMK','ZMW','ZWL'
            ],
        }
    },
    methods: {
        convert() {
            axios.get('/api/conversions?from=' + this.from +  '&to=' + this.to).then(response => {
                this.convertedValue = this.value * response.data
            });
        },
        logout() {
            axios.post('/logout').then(() => {
                location.reload()
            });
        }
    }
}
</script>
