<template>
    <div class="container">
      <h3>Dashboard</h3>

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
                <Card title="Total Staffs">
                  {{counts.total_staffs}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Courses">
                  {{counts.total_courses}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Courses Duration (in hrs)">
                  {{counts.total_course_duration}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Courses Completed(in hrs)">
                  {{counts.total_duration_completed}}
                </Card>
            </div>
            <div class="col-8">
                <!-- <Card title="Mandatory Courses Overview">
                  <div class="row">
                    <div class="col-4" v-for="(chartData, index) in mandatoryCourseChart.chartDatas" :key="index">
                      <DoughnutChart :chartData="chartData" :width="mandatoryCourseChart.width" :height="mandatoryCourseChart.height" :chartOptions="mandatoryCourseChart.chartOptions" />
                      <p class="text-center">{{chartData.name}}</p>
                    </div>
                  </div>
                </Card> -->
                <!-- <Card title="Top Learners">
                  <div class="row">
                    <div class="col-12">
                      <Table />
                    </div>
                  </div>
                </Card> -->
                <Card title="Pending Approvals">
                  <div class="row">
                    <div class="col-12">
                      <Table :columnDefs="approvals.columnDefs" :rowData="approvals.rowData" />
                    </div>
                  </div>
                </Card>
                <Card title="Exceeded Deadlines">
                  <div class="row">
                    <div class="col-12">
                      <Table :columnDefs="exceededDeadlines.columnDefs" :rowData="exceededDeadlines.rowData" />
                    </div>
                  </div>
                </Card>
            </div>
            <div class="col-4">
              <div class="row">
                <Card :title="chartData.name" v-for="(chartData, index) in barChart.chartDatas" :key="index">
                  <div class="col-12">
                    <BarChart :chartData="chartData" :width="barChart.width" :height="barChart.height" :chartOptions="barChart.chartOptions"/>
                  </div>
                </Card>
              </div>
            </div>

        </div>
    </div>
</template>

<script>

import Card from '@/components/Card'
import BarChart from '@/components/BarChart'
import DoughnutChart from '@/components/DoughnutChart'
import Table from '@/components/Table'

export default {
    name:"dashboard",
    data(){
        return {
            user:this.$store.state.auth.user,
            isLoaded: false,
            approvals: {
              columnDefs: [
                { headerName: "Name", field: "name", sortable: true, filter: true },
                // { headerName: "Credit Hours", field: "credit_hours", sortable: true, filter: true },
                { headerName: "User", field: "email", sortable: true, filter: true },
                { headerName: "Completed Date", field: "completed_date", sortable: true, filter: true },
              ],
              rowData: []
            },
            exceededDeadlines: {
              columnDefs: [
                { headerName: "Name", field: "name", sortable: true, filter: true },
                // { headerName: "Credit Hours", field: "credit_hours", sortable: true, filter: true },
                { headerName: "User", field: "email", sortable: true, filter: true },
                { headerName: "Deadline", field: "due_date", sortable: true, filter: true },
              ],
              rowData: []
            },
            mandatoryCourseChart: {
              height: 200,
              chartOptions: {
                responsive: true,
                maintainAspectRatio: false
              },
              chartDatas: [],
            },
            barChart: {
              height: 200,
              chartOptions: {
                responsive: true,
                indexAxis: 'y',
                maintainAspectRatio: false
              },
              chartDatas: [],
            },
            counts: {
                total_courses: '-',
                total_staffs: '-',
                total_course_duration: '-',
                total_duration_completed: '-'
            },
        }
    },
    components: {
        Card,
        BarChart,
        DoughnutChart,
        Table
    },
    async created() {
      let response = await this.$api.statistics.fetchMandatoryCourses();
      this.mandatoryCourseChart = {
        ...this.mandatoryCourseChart,
        chartDatas: response.data
      };
      response = await this.$api.statistics.fetchMostPopularCourses();
      this.barChart = {
        ...this.barChart,
        chartDatas: [
          ...this.barChart.chartDatas,
          response.data
        ]
      };
      response = await this.$api.statistics.fetchStaffByPillar();
      this.barChart = {
        ...this.barChart,
        chartDatas: [
          ...this.barChart.chartDatas,
          response.data
        ]
      };
      response = await this.$api.statistics.fetchAdminDashboardStats();
      this.counts = {
        ...this.counts,
        ...response.data
      }
      response = await this.$api.courses.listUnapprovedCourse();
      this.approvals = {
        ...this.approvals,
        rowData: response.data.data
      };
      response = await this.$api.courses.getExceededDeadlines();
      console.log(response);
      this.exceededDeadlines = {
        ...this.exceededDeadlines,
        rowData: response.data
      };
  },


}
</script>
