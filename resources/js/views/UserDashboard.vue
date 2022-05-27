<template>
    <div class="container">
      <h3>Dashboard.</h3>

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
            <div class="col-3">
                <Card title="Total Enrolled Courses">
                  {{counts.total_enrolled_courses}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Completed Courses">
                  {{counts.total_completed_courses}}
                </Card>
            </div> 
            <div class="col-3">
                <Card title="Required Learning Hours">
                  {{counts.course_duration_required}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Completed Learning Hours">
                  {{counts.course_duration_completed}}
                </Card>
            </div>
            <div class="col-8">
              <div class="row">
                <div class="col-4">
                  <Card title="Course Completion">
                    <div class="row">
                      <div class="col-12" v-for="(chartData, index) in courseProgressChart.chartDatas" :key="index">
                        <DoughnutChart :chartData="chartData" :width="courseProgressChart.width" :height="courseProgressChart.height" :chartOptions="courseProgressChart.chartOptions" />
                        <!-- <p class="text-center">{{chartData.name}}</p> -->
                      </div>
                    </div>
                  </Card>
                </div>
                <div class="col-8">
                  <Card title="Upcoming Deadlines">
                    <div class="row">
                      <div class="col-12">
                        <Table :columnDefs="deadlines.columnDefs" :rowData="deadlines.rowData" />
                      </div>
                    </div>
                  </Card>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="row">
                <Card title="Completed Course">
                  <div class="col-12">
                    <Table :columnDefs="completedCourse.columnDefs" :rowData="completedCourse.rowData" />
                  </div>
                </Card>
              </div>
            </div>
            <div class="col-12">
              <div class="row">
                <Card title="Yearly Progress">
                    <div class="col-12">
                      <LineChart :chartData="yearlyProgress" />
                    </div>
                </Card>
              </div>
            </div>
            <SuggestedCourse />
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


export default {
    name:"dashboard",
    data(){
        return {
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
                { headerName: "Credit Hours", field: "credit_hours", sortable: true, filter: true },
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
        SuggestedCourse
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
      response = await this.$api.statistics.fetchUserYearlyProgress();
      this.yearlyProgress.datasets[0].data = [
        ...response.data
      ];
    },
}
</script>