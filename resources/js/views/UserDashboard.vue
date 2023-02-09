<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 >Filter</h5>
            </div>
            <div class="form-group col-md-5">
                <label for="start_date" >Start Date</label>
                <v-date-picker v-model="form.start_date"  name="start_date" placeholder="Start Date" class="form-control" :class="{ 'is-invalid': form.errors.has('start_date')}"
                    :model-config="{
                    type: 'string',
                    mask: 'YYYY-MM-DD',
                    }"
                    :masks="masks"
                    mode="date"
                >
                    <template v-slot="{ inputValue, inputEvents }">
                    <input
                        class="custom-datepicker"
                        :value="inputValue"
                        v-on="inputEvents"
                    />
                    </template>
                </v-date-picker>
            </div>

            <div class="form-group col-md-5">
                <label for="end_date" >End Date</label>
                <v-date-picker v-model="form.end_date" :min-date="form.start_date" @dayclick="filterRecords()" name="end_date" placeholder="End Date" class="form-control" :class="{ 'is-invalid': form.errors.has('end_date')}"
                    :model-config="{
                    type: 'string',
                    mask: 'YYYY-MM-DD',
                    }"
                    :masks="masks"
                    mode="date"
                >
                    <template v-slot="{ inputValue, inputEvents }">
                    <input
                        class="custom-datepicker"
                        :disabled="!form.start_date"
                        :value="inputValue"
                        v-on="inputEvents"
                    />
                    </template>
                </v-date-picker>
            </div>
            <div class="form-group col-md-2 ">
                <button class="btn btn-primary mt-4" @click="loadUserDashboard(),clearForm()">Reset</button>
            </div>


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
import Form from 'vform'

export default {
    name:"user-dashboard",
    data(){
        return {
            year: new Date().getFullYear(),
            form: new Form({
                year: new Date().getFullYear(),
                //current year start date
                start_date: new Date(new Date().getFullYear(), 0, 1).toISOString().slice(0,10),
                end_date: new Date().toISOString().slice(0,10),
            }),
            masks: {
                input: 'YYYY-MM-DD',
            },
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
        clearForm(){
            this.form.reset();
        },
      async fetchSuggestedCourse () {
        let response = await this.$api.courses.listSuggestedCourse();
        this.suggestedCourses = response.data.filter(item=>{
            return item.random_courses.length >= 1
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
      },
      async filterRecords(){
        let response;
        response = await this.$api.statistics.filterUserDashboardStats(this.form.start_date, this.form.end_date);
        this.counts = {
            ...this.counts,
            ...response.data
        };
        let remainingRequiredHour = this.counts.course_duration_required - this.counts.course_duration_completed;
        if(Math.sign(remainingRequiredHour)==-1){
            remainingRequiredHour = 0
        }
        this.courseProgressChart.chartDatas[0].datasets[0].data = [this.counts.course_duration_completed, remainingRequiredHour];
        response = await this.$api.statistics.filterUserUpcomingDeadlines(this.form.start_date, this.form.end_date);
        this.deadlines = {
            ...this.deadlines,
            rowData: response.data
        };
        response = await this.$api.statistics.filterUserCompletedCourse(this.form.start_date, this.form.end_date);
        this.completedCourse = {
            ...this.completedCourse,
            rowData: response.data
        };

      },
      async loadUserDashboard(){
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
      }

    },
    created() {
      this.loadUserDashboard();
    },


}
</script>
