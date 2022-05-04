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
                <Card title="Total Courses">
                  {{api.statistics.total_courses}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total hours">
                  {{api.statistics.total_duration_completed}}/{{api.statistics.total_course_duration}}
                </Card>
            </div>
            <!-- <div class="col-3">
                <Card title="Total Courses Duration (in hrs)">
                  {{api.statistics.total_course_duration}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Courses Completed(in hrs)">
                  {{api.statistics.total_duration_completed}}
                </Card>
            </div> --> 
            <div class="col-8">
              <div class="row">
                <div class="col-4">
                  <Card title="Course Completion">
                    <div class="row">
                      <div class="col-12" v-for="(chartData, index) in mandatoryCourseChart.chartDatas" :key="index">
                        <DoughnutChart :chartData="chartData" :width="mandatoryCourseChart.width" :height="mandatoryCourseChart.height" :chartOptions="mandatoryCourseChart.chartOptions" />
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
                <Card title="Top Learners">
                  <div class="row">
                    <div class="col-12">
                      <Table />
                    </div>
                  </div>
                </Card>
            </div>
            <div class="col-4">
              <div class="row">
                <Card title="Completed Course">
                  <div class="col-12">
                    <Table :columnDefs="completedCourse.columnDefs" :rowData="completedCourse.rowData" />
                  </div>
                </Card>
                <Card title="Yearly Progress">
                  <div class="col-12">
                    <LineChart />
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
import variables from '@/helpers/constants';
import LineChart from '@/components/LineChart';

export default {
    name:"dashboard",
    data(){
        return {
            user:this.$store.state.auth.user,
            isLoaded: false,
            mandatoryCourseChart: {
              height: 200,
              chartOptions: {
                responsive: true,
                maintainAspectRatio: false
              },
              chartDatas: [
                {
                  name: 'Completed Hours',
                  labels: [ 'Completed', 'Remainging'],
                  datasets: [ { data: [92, 8], backgroundColor: [variables.COLOR_SEC_GREEN, variables.COLOR_RED] } ],
                }
              ],
            },
            completedCourse: {
              columnDefs: [
                { headerName: "Name", field: "name", sortable: true, filter: true },
                { headerName: "Course Category", field: "course_category", sortable: true, filter: true },
                { headerName: "Credit Hours", field: "credit_hours", sortable: true, filter: true },
              ],
              rowData: [
                { name: "AMR-competency", course_category: "Antimicrobial Resistance channel", credit_hours: 8 },
                { name: "Anaphylaxis", course_category: "Risk communication", credit_hours: .34 },
                { name: "Cybersecurity Essentials & Preventing Phishing PLUS Cybersecurity Refresher.", course_category: "WHO Mandatory Trainings", credit_hours: 2 },
              ]
            },
            deadlines: {
              columnDefs: [
                { headerName: "Name", field: "name", sortable: true, filter: true },
                { headerName: "Course Category", field: "course_category", sortable: true, filter: true },
                { headerName: "Deadline", field: "due_date", sortable: true, filter: true },
              ],
              rowData: [
                { name: "Infodemic Management", course_category: "Risk communication", due_date: "2022-05-13" },
                { name: "WHO United to Respect (expected to be rolled out soon)", course_category: "WHO Mandatory Trainings", due_date: "2022-05-18" },
                { name: "Free Health Information Management Certificates | POLHN (csod.com)", course_category: "Information Management ", due_date: "2022-05-21" },
              ]
            },
            api: {
              loaded: false,
              chartData: null,
              statistics: {
                total_courses: 30,
                total_staffs: 86,
                total_course_duration: 100,
                total_duration_completed: 92
              },
              
            }
        }
    },
    components: {
        Card,
        BarChart,
        DoughnutChart,
        Table,
        LineChart
    },
}
</script>