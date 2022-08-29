<template>

<h3>
{{title}}
</h3>
    <div class="card-body shadow-0  ">
            <carousel :items-to-show="2">
                <slide v-for="item in data" :key="item.id" >
                    <div class="who-card shadow-0"  >
                        <h4 class="text-center">{{item.name}}</h4>
                        <div class="who-card  shadow-0 table-responsive" v-for="item in item.courses" :key="item.id">
                            <table class="w-100 text-center">
                                <tr>
                                    <th>Name</th>
                                    <th>Duration</th>
                                    <th>Actions</th>
                                </tr>
                                <tr>
                                    <td>{{item.name}}</td>
                                    <td>{{item.credit_hours}}</td>
                                    <td> <a class="btn btn-fill" target="_blank" :href="item.url">Visit</a>
                                    <button class="btn btn-fill"  @click="enrollCourse(item.id)">Enroll</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
              </slide>
                <template #addons>
                <navigation />
                <pagination />
                </template>
            </carousel>
          </div>
</template>
<script>
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';

export default {
    props:['data','title'],
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    data(){
        return{

        }
    },
    methods:{
        enrollCourse(id) {
        this.$swal({
            title: 'Are you sure to enroll to this course?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, enroll!'
        }).then(async (result) => {
            if (result.value) {
                try {
                  let response = await this.$api.courses.enrollToCourse({course_id: id});
                  this.$swal(
                        'Enrolled!',
                        'You have successfully enrolled to the course.',
                        'success'
                    );
                    this.emitter.emit('AfterEnrolledCreate')
                } catch(e) {
                  this.$swal(
                      'Warning!',
                      'Could not enroll to course.',
                      'warning'
                  )
                }
            }

        })
    }


    },

}
</script>
<style scoped>

th{
    font-weight: bold;
}
tr,td,th{
    vertical-align: middle !important;
    border: 1px solid #ccc;
    padding: 5px;
}
</style>


