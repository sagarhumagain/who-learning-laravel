<template>
  <h3>Suggested Courses</h3>
  <div class="col-md-6" v-for="(suggestedCourse, index) in suggestedCourses" :key="index">
    <div class="who-card"  >
      <p class="text-center">{{suggestedCourse.name}}</p>
      <div class="who-card table-responsive" v-for="(item, index) in suggestedCourse.courses" :key="item.id">
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
      <button class="btn btn-fill">Enroll</button></td>
            </tr>
        </table>


      </div>
    </div>
  </div>
</template>

<script>

export default {
    name: "suggested-course",
    methods: {
      async fetchSuggestedCourse () {
        let response = await this.$api.courses.listSuggestedCourse();
        this.suggestedCourses = response.data;
      },
    },
    created(){
        this.fetchSuggestedCourse();

    },
    data(){
        return {
            suggestedCourses:[],
        }
    }
}
</script>
<style scoped>
.btn-action{
    border: 2px solid ;
}
tr,td,th{
    vertical-align: middle !important;
    border: 1px solid #ccc;
}
</style>
