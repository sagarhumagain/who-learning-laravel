<template>
    <div class="row">
        <div class="col-12">
            <Card title="User Courses">
                <div class="row">
                    <div class="col-12">
                        <UserTable :columnDefs="columnDefs" :rowData="users"  />
                    </div>
                </div>
            </Card>
        </div>
    </div>

</template>
<script>
import { reactive } from 'vue';
import Card from '@/components/Card';
import UserTable from '@/components/UserTable';


export default {
    name: 'UserCourse',
    props: {
        course: {
        type: Object,
        required: true,
        },
    },
    components: {
        Card,
        UserTable,
    },
    data(){
        return{
            users:[],
            columnDefs: [
                { headerName: "Name", field: "name", sortable: true, filter: true },
                { headerName : 'Email', field: 'email', sortable: true, filter: true},
                { headerName: 'Enrolled Courses', field:'enrolled_courses_count', sortable: true, filter: true},
                { headerName: "Completed Courses", field:'completed_courses_count', sortable: true, filter: true },
                { headerName: "Credit Hours", field: "credit_hours_count", sortable: true, filter: true },
            ],
        }
    },
    methods: {
        async getUsers(){
            const {data}  = await  axios.get("/api/v1/users-stats")
            this.users = data
        },
    },
    created(){
        this.getUsers();
    },
};
</script>
