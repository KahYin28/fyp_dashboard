<template>
    <div>
    <b-table-simple hover small caption-top responsive
                    :attends = "attends"
                    :per-page="perPage"
                    :current-page="currentPage"
                    small>
        <b-thead head-variant="dark">
            <b-tr>
                <b-th>No</b-th>
                <b-th>Matric No</b-th>
<!--                <b-th>Name</b-th>-->
                <b-th>Last Update</b-th>
                <b-th>Attend</b-th>

<!--                <b-th>Programme</b-th>-->
<!--                <b-th>Faculty</b-th>-->
            </b-tr>
        </b-thead>
        <b-tbody>
            <b-tr v-for="(attend,index) in attends.data"
                  :key="attend.id"
            >
                <b-td>{{ index+1 }}</b-td>

                    <b-td>
                        <router-link :to="{path:'/emotion',query:{ id:attend.student_id }}">
                        {{attend.student_id}}
                        </router-link>
                    </b-td>

<!--                <b-td v-if="attend.students.name !== null" >{{attend.students.name}}</b-td>-->
<!--                <b-td>{{attend.students.programme}}</b-td>-->
                <!--<b-td>{{register.students.faculty.name}}</b-td>-->

                <b-td>{{attend.updated_at}}</b-td>
                <b-td>
                    <label class="form-checkbox" >
                        <div class="dot" v-bind:class="{'grey' : attend.status == '0' , 'green':attend.status =='1', 'red': attend.status == '2' }"></div>
<!--                        <input type="checkbox" :value="attend.status" v-model="attend.status">-->
                    </label>
                </b-td>
            </b-tr>
        </b-tbody>
        <b-tfoot>
            <b-tr>
                <b-td colspan="7" variant="secondary" class="text-right">
                    Total Students: <b>{{attends.total}}</b>
                </b-td>
            </b-tr>
        </b-tfoot>

    </b-table-simple>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination'
    export default {
        name: "StudentAttendanceList",
        components: {
            'pagination': pagination
        },
        data() {
            return {
                attends: {},
                perPage: 5,
                currentPage: 1,
                now: new Date(),
                error: '',
            }
        },
        mounted() {
            this.getStudentList();
            this.getRealtimeData();
        },
        methods: {
            /**get lesson id from attendance table to query student list**/
            getStudentList() {
                this.type = this.$route.query.type;
                if(!this.type) {
                    this.type = this.$session.get('type');
                    console.log(this.type);
                }
                console.log(this.type);

                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['data']);
                        axios.get('attendance?lesson_id=' + this.sessionData['id'] + '&type=' + this.type)
                            .then(data => {
                                this.attends = data.data;
                                console.log(this.attends)
                            })

                }
            },
            /**pagination for student list result**/
            getResults(page = 1) {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['id']);

                    // this.lesson_id = this.$route.query.lesson_id;
                    axios.get('attendance?lesson_id=' + this.sessionData['id'] + '&page=' + page)
                        .then(response => {
                            this.attends = response.data;
                            console.log(this.attends)
                        })
                        .catch(err => {
                            this.loading = false;
                            this.error = err;
                        });
                }

            },
            getRealtimeData() {
                window.Echo.channel('AttendanceChannel')
                    .listen('AttendanceUpdateEvent', (e) => {
                      //  console.log(e);
                        this.attends.data = e.attendance_list;
                        console.log(this.attends)
                        // this.$session.set('data', this.sessionData['id']);

                    });

            }
        }
    }
</script>

<style scoped>
    .dot {
        height: 30px;
        width: 30px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
    }
</style>
