<template>
    <div class="container">

        <div class="row">

            <!-- <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">You are logged in as <b>{{user.email}}</b></p>
                    </div>
                </div>
            </div> -->
            <div class="col-md-3 col-sm-6 col-12">
                <Card title="Total Enrolled Courses">
                  {{counts.total_enrolled_courses}}
                </Card>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <Card title="Total Completed Courses">
                  {{counts.total_completed_courses}}
                </Card>
            </div>
            <div class="col-md-3 col-sm-6 col-12 ">
                <Card title="Required Learning Hours">
                  {{counts.course_duration_required}}
                </Card>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <Card title="Completed Learning Hours">
                  {{ Number(counts.course_duration_completed).toFixed(2)}}
                </Card>
            </div>
                <div class="col-md-4 col-12">
                    <Card title="Course Completion">
                    <div class="row">
                        <div class="col-12" v-for="(chartData, index) in courseProgressChart.chartDatas" :key="index">
                        <DoughnutChart :chartData="chartData" :width="courseProgressChart.width" :height="courseProgressChart.height" :chartOptions="courseProgressChart.chartOptions" />
                        <!-- <p class="text-center">{{chartData.name}}</p> -->
                        </div>
                    </div>
                    </Card>
                </div>
                <div class="col-md-8 col-12">
                    <Card title="Upcoming Deadlines">
                    <div class="row">
                        <div class="col-12">
                        <Table :columnDefs="deadlines.columnDefs" :rowData="deadlines.rowData" />
                        </div>
                    </div>
                    </Card>
                </div>
            <Card title="Completed Course">
                <div class="col-12">
                <Table :columnDefs="completedCourse.columnDefs" :rowData="completedCourse.rowData" />
                </div>
            </Card>

              <div class="row">
                  <h2>Year Filter Calendar </h2>
                  <div class="col-md-4">
                  <label for="cars">Choose a year:</label>

                  <select v-model="year" @change="getUserYearlyProgress">
                    <option v-for="year in years" :value="year.value" :key="year.vlaue" :selected="year.selected">
                      {{ year.label }}
                    </option>
                  </select>


                  </div>

              </div>
              <div class="row">
                <Card :title="'Yearly Progress ('+ this.year + ')'">
                    <div class="col-12">
                      <LineChart :chartData="yearlyProgress" />
                    </div>
                </Card>
              </div>
            <Slider :data="suggestedCourses" :title="'Suggested Courses'" />

        </div>

    </div>
</template>

<script>

import Card from '@/components/Card'
import BarChart from '@/components/BarChart'
import DoughnutChart from '@/components/DoughnutChart'
import Table from '@/components/Table'
import variables from '@/helpers/constants';
import LineChart from '@/components/LineChart';
import SuggestedCourse from '@/components/SuggestedCourse';
import Slider from '@/components/slider';
export default {
    name:"user-dashboard",
    data(){
        return {
            year: new Date().getFullYear(),
            years: [

            ],
            suggestedCourses:[],
            user:this.$store.state.auth.user,
            isLoaded: false,
            courseProgressChart: {
              height: 200,
              chartOptions: {
                responsive: true,
                maintainAspectRatio: false
              },
              chartDatas: [
                {
                  name: 'Completed Hours',
                  labels: [ 'Completed', 'Remaining'],
                  datasets: [ { data: [], backgroundColor: [variables.COLOR_SEC_GREEN, variables.COLOR_RED] } ],
                }
              ],
            },
            completedCourse: {
              columnDefs: [
                { headerName: "Name", field: "name", sortable: true, filter: true },
                // { headerName: "Course Category", field: "course_category", sortable: true, filter: true },
                { headerName: "Credit Hours", field: "credit_hours", sortable: true, filter: true },
              ],
              rowData: []
            },
            deadlines: {
              columnDefs: [
                { headerName: "Name", field: "name", sortable: true, filter: true },
                // { headerName: "Credit Hours", field: "credit_hours", sortable: true, filter: true },
                { headerName: "Deadline", field: "due_date", sortable: true, filter: true },
              ],
              rowData: []
            },
            counts: {
                total_enrolled_courses: '-',
                course_duration_required: '-',
                course_duration_completed: '-',
                total_completed_courses: '-'
            },
            yearlyProgress: {
              labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
              datasets: [
                {
                  label: 'Courses',
                  backgroundColor: '#f87979',
                  data: []
                }
              ]
            }
        }
    },
    components: {
        Card,
        BarChart,
        DoughnutChart,
        Table,
        LineChart,
        SuggestedCourse,
        Slider
    },
    methods:{
      async fetchSuggestedCourse () {
        let response = await this.$api.courses.listSuggestedCourse();
        this.suggestedCourses = response.data.filter(item=>{
            return item.courses.length >= 1
        })

      },
      async fetchUserYearlyProgress(year){
          let response;
          response = await this.$api.statistics.fetchUserYearlyProgress(year);
          this.yearlyProgress.datasets[0].data = [
            ...response.data
          ];
      },
      getUserYearlyProgress(){
            this.fetchUserYearlyProgress(this.year);
      }


    },
    async created() {
      let response;
      response = await this.$api.statistics.fetchUserDashboardStats();
      this.counts = {
        ...this.counts,
        ...response.data
      };
      let remainingRequiredHour = this.counts.course_duration_required - this.counts.course_duration_completed;
      if(Math.sign(remainingRequiredHour)==-1){
        remainingRequiredHour = 0
      }
      this.courseProgressChart.chartDatas[0].datasets[0].data = [this.counts.course_duration_completed, remainingRequiredHour];
      response = await this.$api.statistics.fetchUserUpcomingDeadlines();
      this.deadlines = {
        ...this.deadlines,
        rowData: response.data
      };
      response = await this.$api.statistics.fetchUserCompletedCourse();
      this.completedCourse = {
        ...this.completedCourse,
        rowData: response.data
      };
      this.fetchUserYearlyProgress(new Date().getFullYear());
      this.fetchSuggestedCourse();

      let years = [

      ];
      let currentYear = new Date().getFullYear();
      for(let i = 0; i < 4; i++){
          let year = currentYear - i;
          years.push({
              value: year,
              label: year,
              selected: year == currentYear
          })
      }

      this.years = years;
    },


}
</script>
