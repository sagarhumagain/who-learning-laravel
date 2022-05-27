<template>
  <h3>Suggested Courses</h3>
  <div class="col-4" v-for="(suggestedCourse, index) in suggestedCourses" :key="index">
    <div class="who-card">
      <p class="text-center">{{suggestedCourse.name}}</p>
      <p class="text-center">{{suggestedCourse.credit_hours}} hrs</p>
      <a class="btn btn-fill" target="_blank" :href="suggestedCourse.url">Visit</a>
      <button class="btn btn-fill">Enroll</button>
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