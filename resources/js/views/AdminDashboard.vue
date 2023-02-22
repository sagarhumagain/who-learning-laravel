<template>
    <div class="container">
        <div class="row">

            <DashboardFilter :filterRecords="filterRecords" :loadUserDashboard="loadUserDashboard" :form="form" />

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
                    <Card title="Total Staffs">
                    {{counts.total_staffs}}
                    </Card>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <Card title="Total Courses">
                    {{counts.total_courses}}
                    </Card>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <Card title="Total Courses Duration">
                    {{counts.total_course_duration}} hrs
                    </Card>
                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <Card title="Total Courses Completed">
                    {{counts.total_duration_completed}} hrs
                    </Card>
                </div>


            <div class="col-md-8 col-sm-12 col-12">
                <!-- <Card title="Mandatory Courses Overview">
                  <div class="row">
                    <div class="col-4" v-for="(chartData, index) in mandatoryCourseChart.chartDatas" :key="index">
                      <DoughnutChart :chartData="chartData" :width="mandatoryCourseChart.width" :height="mandatoryCourseChart.height" :chartOptions="mandatoryCourseChart.chartOptions" />
                      <p class="text-center">{{chartData.name}}</p>
                    </div>
                  </div>
                </Card>
                <Card title="Top Learners">
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
            <div class="col-md-4 col-sm-12 col-12">
              <div class="row">
                <Card :title="chartData.name" v-for="(chartData, index) in barChart.chartDatas" :key="index">
                  <div class="col-12">
                    <BarChart :chartData="chartData" :width="barChart.width" :height="barChart.height" :chartOptions="barChart.chartOptions"/>
                  </div>
                </Card>
              </div>
            </div>

        </div>

        <div class="col-md-12 text-left">
            <user-course/>
        </div>


    </div>
</template>

<script>

import Card from '@/components/Card'
import BarChart from '@/components/BarChart'
import DoughnutChart from '@/components/DoughnutChart'
import Table from '@/components/Table'
import Form from 'vform'
import DashboardFilter from '@/components/DashboardFilter'
import UserCourse from '@/components/UserCourse.vue'
import moment from 'moment'


export default {
    name:"admin-dashboard",
    data(){
        return {

            form: new Form({
                year: new Date().getFullYear(),
                start_date: moment().startOf('year').format('YYYY-MM-DD'),
                //today's date
                end_date: moment().format('YYYY-MM-DD'),
            }),

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
        Table,
        DashboardFilter,
        UserCourse
    },
    methods: {

        async filterRecords(){
            let response = await this.$api.statistics.filterMostPopularCourses(this.form.start_date, this.form.end_date);
            //replace previous chart data
            this.barChart.chartDatas[0] = response.data;

            response = await this.$api.statistics.filterAdminDashboardStats(this.form.start_date, this.form.end_date);
            this.counts = {
                ...this.counts,
                ...response.data
            }

        },
        async loadUserDashboard() {

            // let response = await this.$api.statistics.fetchMandatoryCourses();
            // this.mandatoryCourseChart = {
            //     ...this.mandatoryCourseChart,
            //     chartDatas: response.data
            // };
            let response = await this.$api.statistics.fetchMostPopularCourses();
            this.barChart.chartDatas[0] = response.data;

            response = await this.$api.statistics.fetchStaffByPillar();
            this.barChart.chartDatas[1] = response.data;

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
            this.exceededDeadlines = {
                ...this.exceededDeadlines,
                rowData: response.data
            };

        }
    },
    async created() {
        this.loadUserDashboard();
    },



}
</script>
