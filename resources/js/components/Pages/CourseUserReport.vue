<template>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover m-0">
            <tbody>
                <tr class="bg-light">
                    <th>Course Name</th>
                    <th style='width:40px;' v-for="(item,index)  in data" :key="index">{{index}}</th>
                </tr>
                <tr>
                    <td>Completed</td>
                    <td v-for="users in data" :key="users.id" >
                         <h6 v-for="(user,index) in users" :key="user.id">{{index+1}}{{')'}}{{ user }}</h6>
                    </td>

                </tr>
            </tbody>

        </table>
    </div>

</template>
<script>
import axios from 'axios';
import { values } from 'lodash';
export default {
    name: "course-user-report",
    data(){
        return{
            data:[]
        }
    },
    methods:{
        getData(){
            axios.get('/api/v1/report').then((response) => {
                const result = {};
                response.data.forEach(courseData => {
                    result[courseData.name] = courseData.users.map(user => user.name);
                });
                this.data = result;
            });
        },


    },
    created(){
        this.getData();
    }


}
</script>


