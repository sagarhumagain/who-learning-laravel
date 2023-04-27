<template>
    <div class="container" v-role:any="'super-admin|supervisor'">
        <div class="row pt-5" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>User Management</h3>

                        <div class="card-tools">
                            <button type="" class="btn btn-fill" @click="newModal()"><i class="fa fa-user-plus fa-fw"></i> Add New User</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr class="bg-light">
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                                <th>Contract History </th>
                                <th>Courses</th>

                            </tr>
                            <tr v-for="(user, index) in users.data" :key="user.id">

                                <td>{{index + 1}}</td>
                                <td>{{user.name}}
                                </td>
                                <td>{{user.email}}</td>

                                <td>
                                    <a href="#" @click="editUserModal(user)" class="m-2 color-sec-blue">
                                        <i class="fa fa-edit" title="Edit User"></i>
                                    </a>
                                     <a href="#" @click="editUserProfile(user)" class="">
                                        <i class="fa fa-user"></i>
                                    </a>
                                    <a href="#" @click="deleteUser(user.id)" class="m-2 color-red">
                                        <i class="fa fa-trash" title="Delete User"></i>
                                    </a>
                                    <a v-if="user.is_first_time_login" href="#" @click="approveUser(user)" class="m-2 color-green">
                                        <i class="fa fa-thumbs-up" title="Approve User"></i>
                                    </a>

                                </td>
                                <td>
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item rounded-0">
                                            <button data-bs-toggle="collapse" :data-bs-target="'#history'+user.id" class="accordion-button rounded-0" type="button">
                                                <a href="#" data-bs-toggle="collapse" :data-bs-target="'#history'+user.id" aria-expanded="true" aria-controls="collapseOne">Contract History</a>
                                                <a href="#" type="" class="btn " @click="newContractModal(user.id,user.name)"><i class="fa fa-plus fa-fw"></i> Add New</a>
                                            </button>
                                            <div :id="'history'+user.id" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
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

                                                            <a href="#" @click="deleteUser(contract.id)" class="">
                                                                <i class="fa fa-trash"></i>
                                                            </a>

                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>


                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item rounded-0">
                                            <button data-bs-toggle="collapse" :data-bs-target="'#course'+user.id" class="accordion-button rounded-0" type="button">
                                                <a href="#" data-bs-toggle="collapse" :data-bs-target="'#course'+user.id" aria-expanded="true" aria-controls="collapseOne">Enrolled Courses</a>
                                                <a href="#" type="" class="btn"><i class="fa fa-plus fa-fw"></i></a>

                                            </button>
                                            <div :id="'course'+user.id" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <table class="table table-hover">
                                                    <tbody>
                                                    <tr class="bg-light">
                                                        <th>Course Name </th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    <tr v-for="course in user.courses" :key="course.id">
                                                        <td>{{course.name}}</td>
                                                        <td>
                                                            <a href="#" @click="viewCertificate(course.pivot)" class="">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>


                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody></table>
                    </div>

                    <div class="card-footer">
                        <pagination-wrapper class="mt-3" :data="this.users" :has_param="false" :api_url="api_url" pagination_title="Users"></pagination-wrapper>
                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>

<!-- user info modal  -->
        <modal :form="form" :modal_data="modal_data" :editmode="editmode" :api_url="'v1/user'  ">

            <div class="form-group col-md-6">
                <label for="first_name" >Name *</label>
                    <input type="text" v-model="form.name" class="form-control"  placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
            </div>


            <div class="form-group col-md-6">
                <label for="" >Email *</label>
                    <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
            </div>

            <div class="form-group col-md-6">
                <h6>Roles</h6>
                <multiselect v-model="form.roles"
                    tag-placeholder="Roles"
                    placeholder="Select Roles"
                    label="name" track-by="name"
                    :options="roles"
                    :multiple="true"
                    :taggable="true"
                    >
                </multiselect>
            </div>

            <div class="form-group col-md-6">
                <label for="password" >Password *</label>

                    <input type="password" v-model="form.password"  @input="check" class="form-control" :class="{ 'is-invalid': isActive, 'is-equal':fc}"  id="password" placeholder="Password">
                    <has-error :form="form" field="password"></has-error>
            </div>
            <div class="form-group col-md-6">
                <label for="confirmpassword">Confirm password *</label>
                    <input type="password" v-model="form.confirmpassword" @input="check" class="form-control" :class="{ 'is-invalid': isActive, 'is-equal':fc}" id="confirmpassword" placeholder="Password">
                    <has-error :form="form" field="confirmpassword"></has-error>
            </div>
        </modal>

<!-- supervisor -->
        <modal :form="pform" :modal_data="p_modal_data" :editmode="true" :api_url="'v1/profile'">
            <div class="form-group col-md-12">
                <h6>Supervisor</h6>
                <multiselect v-model="pform.supervisor_user_id"
                    tag-placeholder="Select Supervisor"
                    placeholder="Select Supervisor"
                    label = "name"
                    track_by = "id"
                    :options="Object.keys(supervisors).map(Number)"
                    :custom-label="opt => supervisors[opt]"
                    :multiple="false"
                    :allow-empty="false"
                    :taggable="true">
                </multiselect>
            </div>
        </modal>

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
            <div class="form-group col-md-6 ">
                <h6> Contract Status</h6>
                <div class="form-control">
                    <input v-model="form.is_active" :true-value="1" :false-value="0" type="checkbox" name="is_active"  class="form-check-input mr-2" :class="{ 'is-invalid': form.errors.has('is_active') }">
                    <label class="form-check-label" for="1">
                        Is Active
                    </label>
                    <error-msg :errors="errors" field="is_active"></error-msg>
                </div>
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

    </div>


</template>
<script>
  import Multiselect from 'vue-multiselect'
    import Form from 'vform'
    import PageNotFound from "./../../components/PageNotFound.vue"
    import PaginationWrapper from '@/components/Pagination/PaginationWrapper.vue';
    import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'
    import ErrorMsg from '@/components/error-msg';
    import Modal from '@/components/Modal';
    export default {
        components: {
            HasError,
            Multiselect,
            Modal,
            PageNotFound,
            PaginationWrapper,
            ErrorMsg
        },
        data() {

            return {
                masks: {
                input: 'YYYY-MM-DD'
                },
                editmode: false,
                totaluser: 0,
                users: {},
                roles: [],
                pillars:[],
                supervisors:[],
                designations:[],
                staff_categories:[],
                contract_types:[],
                staff_types:[],
                units : [],

                modal_data:{
                    modal_size:'modal-lg',
                    modal_name:'addNewUser'
                },
                c_modal_data:{
                    modal_size:'modal-lg',
                    modal_name:'addNewContract'
                },
                p_modal_data:{
                    modal_size:'',
                    modal_name:'addProfile'
                },
                isActive: true,
                fc: false,

                form: new Form({
                    id: null,
                    name: null,
                    email: null,
                    password: null,
                    confirmpassword: null,
                    roles: null,
                    is_first_time_login: null,
                    pillar_id: null,
                    supervisor_user_id:null,
                    user_id:null,
                    contract_type_id:null,
                    contract_start:null,
                    contract_end:null,
                    is_active: null,
                    staff_type_id:null,
                    designation_id:null,
                    staff_category_id:null,
                    contract_type_id:null,
                    unit_id:null,
                }),
                pform: new Form({
                    id: null,
                    user_id:null,
                    supervisor_user_id:null,
                }),
                errors:{},
                api_url: '/api/v1/user',

            }
        },
        methods: {
            viewCertificate(val){
                this.$router.push({name:'courses-edit',params:{id:val.course_id}});
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNewUser').modal('show');
            },
            newContractModal(id,name) {


                this.editmode = false;
                this.form.reset();
                this.form.user_id = id;
                this.form.name = name

                const matchingUser = this.users.data.find(user => user.id === id);
                const lastContract = matchingUser.contracts?.slice(-1)?.[0];
                this.form.supervisor_user_id = lastContract?.supervisor_user_id ?? null;
                this.form.unit_id = lastContract?.unit_id ?? null;
                this.form.staff_category_id = lastContract?.staff_category_id ?? null;
                this.form.staff_type_id = lastContract?.staff_type_id ?? null;
                this.form.designation_id = lastContract?.designation_id ?? null;
                this.form.contract_type_id = lastContract?.contract_type_id ?? null;
                this.form.contract_start = lastContract?.contract_start ?? null;
                $('#addNewContract').modal('show');
            },
            editUserModal(user){
                this.form.reset();
                this.editmode = true;
                const user_data = user
                user_data.supervisor_user_id = user.contracts.slice(-1)[0] ? user.contracts.slice(-1)[0].supervisor_user_id : null;
                console.log(user_data)
                $('#addNewUser').modal('show');
                this.emitter.emit('editing', user_data);
            },
            editUserProfile(user){
                this.form.reset();
                const user_data = user
                user_data.user_id = user.id
                if(user_data.contracts.slice(-1)[0]){
                    user_data.supervisor_user_id = user.contracts.slice(-1)[0].supervisor_user_id
                    user_data.id = user_data.contracts.slice(-1)[0].id
                }else{
                    user_data.id = null
                }
                this.editmode = true;
                $('#addProfile').modal('show');
                this.emitter.emit('editing', user_data);
            },
            editContractModal(contract,pillar_id){
                this.editmode = true;
                contract.is_active = contract.is_active == true ? 1 : 0;
                const updatedContract = {...contract,pillar_id};
                $('#addNewContract').modal('show');
                this.emitter.emit('editing', updatedContract);
            },

            deleteUser(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('/api/v1/user/' + id).then(() => {
                            this.$swal(
                                'Deleted!',
                                'Your file has been deleted.',
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
            approveUser(user) {

                if(!user.contracts.length || !user.contracts.slice(-1)[0]){
                    this.$swal(
                        'Warning!',
                        'Please assign supervisor and update the contract details.',
                        'warning'
                    )
                    return;
                }
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, verify it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.reset();
                        this.form.fill(user)
                        this.form.is_first_time_login = 0;
                        this.form.put('/api/v1/user/'+user.id).then(() => {
                            this.$swal(
                                'Updated!',
                                'User has been verified.',
                                'success'
                            )
                            this.emitter.emit('AfterCreate');
                        }).catch(() => {
                            this.$swal(
                                'Warning!',
                                'Unauthorized Access to verify.',
                                'warning'
                            )
                        })
                    }

                })
            },
            check() {
                if (this.form.password == this.form.confirmpassword) {
                    this.isActive = false;
                    this.fc = true;
                } else {
                    this.isActive = true;
                    this.fc = false;
                }
            },
            async loadUsers() {
                try{
                    const {data}  = await  axios.get("/api/v1/user")
                    this.users = data
                }catch (e) {
                    this.$swal(
                        'Warning!',
                        'Unauthorized Access to load users.',
                        'warning'
                    )
                }
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
                    this.staff_types = data.staff_types
                    this.units = data.units

                }catch (e) {
                    this.$swal(
                        'Warning!',
                        'Unauthorized Access to load details.',
                        'warning'
                    )
                }
            },
        },
        created() {
            this.loadUsers();
            this.loadChoices();
            this.emitter.on("AfterCreate", () => {
                this.loadUsers();
            })
            this.emitter.on('paginating',(item)=>{
                this.users = item
            })
        }

    }
</script>


<style scoped>
.is-equal{

box-shadow: 0 0 0 0.2rem rgb(73 231 25 / 25%) !important;
}

</style>



