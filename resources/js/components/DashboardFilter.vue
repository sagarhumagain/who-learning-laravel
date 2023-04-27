<template>
    <div class="col-md-12">
        <h5 >Filter</h5>
    </div>
    <div class="form-group col-md-5">
        <label for="start_date" >Start Date</label>
        <v-date-picker v-model="form.start_date"  @dayclick="filterRecords()"  name="start_date" placeholder="Start Date" class="form-control" :class="{ 'is-invalid': form.errors.has('start_date')}"
            :model-config="{
            type: 'string',
            mask: 'YYYY-MM-DD',
            }"
            :masks="masks"
            mode="date"
        >
            <template v-slot="{ inputValue, inputEvents }">
            <input
            readonly
                class="custom-datepicker"
                :value="inputValue"
                v-on="inputEvents"
            />
            </template>

        </v-date-picker>
    </div>

    <div class="form-group col-md-5">
        <label for="end_date" >End Date</label>
        <v-date-picker v-model="form.end_date" :min-date="form.start_date" @dayclick="filterRecords()" name="end_date" placeholder="End Date" class="form-control" :class="{ 'is-invalid': form.errors.has('end_date')}"
            :model-config="{
            type: 'string',
            mask: 'YYYY-MM-DD',
            }"
            :rules="[validateDate]"
            :masks="masks"
            mode="date"
        >
            <template v-slot="{ inputValue, inputEvents }">
            <input
                class="custom-datepicker"
                readonly
                :disabled="!form.start_date"
                :value="inputValue"
                v-on="inputEvents"
            />
            </template>
        </v-date-picker>
    </div>
    <div class="form-group col-md-2 ">
        <button class="btn btn-primary mt-4" @click="loadUserDashboard(),clearForm()">Reset</button>
    </div>
</template>
<script>
import Form from 'vform'

export default {

    props:{
        filterRecords: {
            type: Function,
            required: true
        },
        loadUserDashboard: {
            type: Function,
            required: true
        },
        form: {
            type: Object,
            required: true
        },

    },
    data(){
        return{
            masks: {
                input: 'YYYY-MM-DD',
            },

        }
    },
    methods:{
        clearForm(){
            this.form.reset();
        },





    }

}
</script>
