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
                  {{api.statistics.total_staffs}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Courses">
                  {{api.statistics.total_courses}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Courses Duration (in hrs)">
                  {{api.statistics.total_course_duration}}
                </Card>
            </div>
            <div class="col-3">
                <Card title="Total Courses Completed(in hrs)">
                  {{api.statistics.total_duration_completed}}
                </Card>
            </div>
            <div class="col-8">
                <Card title="Mandatory Courses Overview">
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
import variables from '@/helpers/constants';

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
                  name: 'Course A',
                  labels: [ 'Completed', 'Remaining'],
                  datasets: [ { data: [10, 90], backgroundColor: [variables.COLOR_SEC_GREEN, variables.COLOR_RED] } ],
                   
                },
                {
                  name: 'Course B',
                  labels: [ 'Completed', 'Remaining'],
                  datasets: [ { data: [20, 80], backgroundColor: [variables.COLOR_SEC_GREEN, variables.COLOR_RED] } ]
                },
                {
                  name: 'Course C',
                  labels: [ 'Completed', 'Remaining'],
                  datasets: [ { data: [30, 70], backgroundColor: [variables.COLOR_SEC_GREEN, variables.COLOR_RED] } ]
                }
              ],
            },
            barChart: {
              height: 200,
              chartOptions: {
                responsive: true,
                indexAxis: 'y',
                maintainAspectRatio: false
              },
              chartDatas: [
                {
                  name: 'Most Popular Courses',
                  labels: [ 'Course A', 'Course B', 'Course C'],
                  datasets: [ { data: [90, 79, 50], backgroundColor: [variables.COLOR_SEC_YELLOW, variables.COLOR_SEC_MAGENTA, variables.COLOR_SEC_PURPLE] } ],
                   
                },
                {
                  name: 'Staffs by Pillar',
                  labels: [ 'Pillar 1', 'Pillar 2', 'Pillar 3', 'Pillar 4'],
                  datasets: [ 
                    { 
                      data: [20, 90, 49, 60],
                      backgroundColor: [variables.COLOR_SEC_YELLOW, variables.COLOR_SEC_MAGENTA, variables.COLOR_SEC_PURPLE, variables.COLOR_SEC_ORANGE]
                    },
                  ]
                },
              ],
            },
            api: {
              loaded: false,
              chartData: null,
              statistics: {
                total_courses: 30,
                total_staffs: 86,
                total_course_duration: 63.2,
                total_duration_completed: 160
              },
              
            }
        }
    },
    components: {
        Card,
        BarChart,
        DoughnutChart,
        Table
    },
}
</script>