<template>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Contract Management</h3>

                    <div class="card-tools">
                        <button type="" class="btn btn-fill" @click="newContractModal()"><i class="fa fa-user-plus fa-fw"></i> Add New Contract</button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                            <tr class="bg-light">
                                <th>Start Date </th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="contract in user.contracts" :key="contract.id">
                                <td>{{contract.contract_start}}</td>
                                <td>{{contract.contract_end}}</td>
                                <td>
                                    <a href="#" @click="editContractModal(contract, user.pillars)" class="m-2">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" @click="deleteContract(contract.id)" class="">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
            <!-- /.card -->
        </div>

        <!-- contract modal -->
        <modal :form="form" :modal_data="c_modal_data" :editmode="editmode" :api_url="'v1/contract'">
            <h4 class="modal-header">Contract Information : {{this.form.name}}</h4>

                <div class="form-group col-md-6">
                <label for="contract_start" >Contract Start Date*</label>
                <v-date-picker v-model="form.contract_start"  name="contract_start" placeholder="Contract Start Date" class="form-control" :class="{ 'is-invalid': form.errors.has('contract_start')}"
                :model-config="{
                    type: 'string',
                    mask: 'YYYY-MM-DD',
                }"
                :masks="masks"
                mode="date"
                >
                <template v-slot="{ inputValue, inputEvents }">
                    <input
                    class="custom-datepicker"
                    :value="inputValue"
                    v-on="inputEvents"
                    />
                </template>
                </v-date-picker>
                <error-msg :errors="errors" field="contract_start"></error-msg>
            </div>

            <div class="form-group col-md-6">
                <label for="contract_end" >Contract End Date*</label>
                <v-date-picker v-model="form.contract_end"  name="contract_end" placeholder="Contract End Date" class="form-control" :class="{ 'is-invalid': form.errors.has('contract_end')}"
                :model-config="{
                    type: 'string',
                    mask: 'YYYY-MM-DD',
                }"
                :masks="masks"
                mode="date"
                >
                <template v-slot="{ inputValue, inputEvents }">
                    <input
                    class="custom-datepicker"
                    :value="inputValue"
                    v-on="inputEvents"
                    />
                </template>
                </v-date-picker>
                <error-msg :errors="errors" field="contract_end"></error-msg>
            </div>

            <div class="form-group col-md-6">
                <h6>Staff Type</h6>
                <multiselect v-model="form.staff_type_id"
                    tag-placeholder="Saff Type"
                    placeholder="Select Staff Type"
                    :options="Object.keys(staff_types).map(Number)"
                    :custom-label="opt => staff_types[opt]"
                    :multiple="false"
                    :allow-empty="false"
                    :taggable="true"
                    >
                </multiselect>
                <error-msg :errors="errors" field="staff_type_id"></error-msg>

            </div>

            <div class="form-group col-md-6">
                <h6>Designation</h6>
                <multiselect v-model="form.designation_id"
                    tag-placeholder="Designation"
                    placeholder="Select Designation"
                    :options="Object.keys(designations).map(Number)"
                    :custom-label="opt => designations[opt]"
                    :multiple="false"
                    :allow-empty="false"
                    :taggable="true"
                    >
                </multiselect>
                <error-msg :errors="errors" field="designation_id"></error-msg>
            </div>
            <div class="form-group col-md-6">
                <h6>Contract Type</h6>
                <multiselect v-model="form.contract_type_id"
                    tag-placeholder="Contract Type"
                    placeholder="Select Contract Type"
                    :options="Object.keys(contract_types).map(Number)"
                    :custom-label="opt => contract_types[opt]"
                    :multiple="false"
                    :allow-empty="false"
                    :taggable="true"
                    >
                </multiselect>
                <error-msg :errors="errors" field="contract_type_id"></error-msg>
            </div>
            <div class="form-group col-md-6">
                <h6>Staff Category</h6>
                <multiselect v-model="form.staff_category_id"
                    tag-placeholder="Staff Category"
                    placeholder="Select Staff Category"
                    :options="Object.keys(staff_categories).map(Number)"
                    :custom-label="opt => staff_categories[opt]"
                    :multiple="false"
                    :allow-empty="false"
                    :taggable="true"
                    >
                </multiselect>
                <error-msg :errors="errors" field="staff_category_id"></error-msg>
            </div>
            <div class="form-group col-md-6 ">
                <h6> Contract Status</h6>
                <div class="form-control">
                    <input v-model="form.is_active" true-value="1" false-value="0" type="checkbox" name="is_active"  class="form-check-input mr-2" :class="{ 'is-invalid': form.errors.has('is_active') }">
                    <label class="form-check-label" for="1">
                        Is Active
                    </label>
                    <error-msg :errors="errors" field="is_active"></error-msg>
                </div>
            </div>
            <div class="form-group col-md-6">
                <h6>Unit</h6>
                <multiselect v-model="form.unit_id"
                    tag-placeholder="Unit"
                    placeholder="Unit"
                    :options="Object.keys(units).map(Number)"
                    :custom-label="opt => units[opt]"
                    :multiple="false"
                    :allow-empty="false"
                    :taggable="true"
                    >
                </multiselect>
                <error-msg :errors="errors" field="unit_id"></error-msg>
            </div>
            <div class="form-group col-md-6">
                <h6>Pillars</h6>
                <multiselect v-model="form.pillar_id"
                    tag-placeholder="Pillars"
                    placeholder="Select Pillars"
                    label="name" track-by="id"
                    :options="pillars"
                    :multiple="true"
                    :taggable="true"
                    >
                </multiselect>
            </div>

        </modal>
</template>
<script>
import Multiselect from 'vue-multiselect'
import Form from 'vform'
import PaginationWrapper from '@/components/Pagination/PaginationWrapper.vue';
import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'
import ErrorMsg from '@/components/error-msg';
import {mapActions, mapState} from 'vuex';

import Modal from '@/components/Modal';
import store from '@/store';
export default {
    name: 'contract',
    components: {
        HasError,
        ErrorMsg,
        Multiselect,
        Modal,
        PaginationWrapper,
    },
    props: {
        user: {
            type: Object,
            default: store.state.auth.user,
        },
    },
    data(){
        return {
            c_modal_data:{
                modal_size:'modal-lg',
                modal_name:'addNewContract'
            },
            roles: [],
            pillars:[],
            supervisors:[],
            designations:[],
            staff_categories:[],
            contract_types:[],
            staff_types:[],
            units : [],
            masks: {
                date: 'YYYY-MM-DD',
            },
            api_url: '/api/v1/contract',
            editmode: false,
            form: new Form({
                id: '',
                user_id: '',
                staff_id: '',
                pillar_id: '',
                contract_start: '',
                contract_end: '',
                staff_type_id: '',
                designation_id: '',
                contract_type_id: '',
                staff_category_id: '',
                is_active: '',
                unit_id: '',
            }),
            errors:{},

        }
    },
    methods: {
        ...mapActions({
            signIn:'auth/login',
        }),
        newContractModal() {
            this.editmode = false;
            this.form.reset();
            if(this.user.contracts.slice(-1)[0]){
                //replace start_date with end_date
                this.user.contracts.slice(-1)[0].contract_start = this.user.contracts.slice(-1)[0].contract_end;
                this.user.contracts.slice(-1)[0].contract_end = '';
                this.form.fill(this.user.contracts.slice(-1)[0]);
            }
            this.form.user_id = this.user.id;
            this.form.name = this.user.name;
            $('#addNewContract').modal('show');
        },
        editContractModal(contract, pillar_id){
            this.editmode = true;
            $('#addNewContract').modal('show');
            const updatedContract = {...contract, pillar_id};
            this.emitter.emit('editing', updatedContract);
        },
        deleteContract(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete(this.api_url+'/' + id).then(() => {
                            this.$swal(
                                'Deleted!',
                                'Deleted Successfully.',
                                'success'
                            )
                            this.emitter.emit('AfterCreate');
                        }).catch(() => {
                            this.$swal(
                                'Warning!',
                                'Unauthorized Access to delete.',
                                'warning'
                            )
                        })
                    }

                })
        },
        async loadChoices() {
                try{
                    const {data}  = await  axios.get("/api/v1/get-choices")
                    this.roles = data.roles
                    this.pillars = data.pillars
                    this.supervisors = data.supervisors
                    this.designations =data.designation_types
                    this.staff_categories = data.staff_categories
                    this.contract_types = data.contract_types
                    this.staff_types = data.staff_types,
                    this.units = data.units
                }catch (e) {

                    this.$swal(
                        'Warning!',
                        'Unauthorized Access to load details.',
                        'warning'
                    )
                }
        },
        async loadProfile() {
            await this.signIn();
        },
    },
    computed: {
        user (){
            return this.$store.state.auth.user
        },
    },
    async created() {
        await this.loadChoices();
        this.emitter.on('AfterCreate', () => {
            this.loadProfile();
        });
        this.emitter.on('SetError',(item)=>{
            this.errors = item
        })
    },

}
</script>
