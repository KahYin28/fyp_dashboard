<template>
    <div>
        <div><p>{{now}}</p></div>
        <div class="overflow-auto">
            <div class="container">
                <b-table-simple hover small caption-top responsive
                                :registers="registers"
                                :per-page="perPage"
                                :current-page="currentPage"
                                small>
                    <b-thead head-variant="dark">
                        <b-tr>
                            <b-th>No</b-th>
                            <b-th>Matric No</b-th>
                            <b-th>Name</b-th>
                            <b-th>Programme</b-th>
                            <b-th>Faculty</b-th>
                            <b-th>Attend</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr v-for="(register,index) in registers.data"
                              :key="register.id"
                        >
                            <b-td>{{ index+1 }}</b-td>
                            <router-link :to="{path:'/emotion',query:{id:register.student_id}}">
                                <b-td>{{register.student_id}}</b-td>
                            </router-link>
<!--                            <b-td>{{register.students.name}}</b-td>-->
<!--                            <b-td>{{register.students.programme}}</b-td>-->
<!--                            <b-td>{{register.students.faculty.name}}</b-td>-->
                            <b-td>
                                <label class="form-checkbox">
                                    <input type="checkbox" :value="register.status" v-model="register.status">
                                </label>
                            </b-td>

                        </b-tr>

                    </b-tbody>
                    <b-tfoot>
                        <b-tr>
                            <b-td colspan="7" variant="secondary" class="text-right">
                                Total Students: <b>{{registers.total}}</b>
                            </b-td>
                        </b-tr>
                    </b-tfoot>

                </b-table-simple>
                <pagination :data="registers"
                            @pagination-change-page="getResults">
                </pagination>
            </div> <!--close container-->
        </div>
    </div>
</template>
<script>
    import NavBar from "../components/NavBar.vue";
    import pagination from 'laravel-vue-pagination'

    export default {
        components: {
            'app-navbar': NavBar,
            'pagination': pagination
        },

        data() {
            return {
                registers: {},
                perPage: 5,
                currentPage: 1,
                now: new Date(),
                checkAttend: [],
                error: '',
            }
        },
        mounted() {
            this.getStudentList();
            this.getRealtimeData();
        },

        methods: {
            /**get lesson id from register table to query student list**/
            getStudentList() {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['id']);
                    // this.lesson_id = this.$route.query.lesson_id;
                    axios.get('register?lesson_id=' + this.sessionData['id'])
                        .then(data => {
                            this.registers = data.data;
                            console.log(this.registers)
                        })
                }
            },
            /**pagination for student list result**/
            getResults(page = 1) {
                if (this.$session.exists('data')) {
                    this.sessionData = this.$session.get('data');
                    console.log(this.sessionData['id']);

                    this.lesson_id = this.$route.query.lesson_id;
                    axios.get('register?lesson_id=' + this.sessionData['id'] + '&page=' + page)
                        .then(response => {
                            this.registers = response.data;
                            console.log(this.registers)
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
                        console.log(e.attendance_list);
                        this.registers.data = e.attendance_list;


                    });

            }
        }
    }
</script>
<style scoped>
</style>
