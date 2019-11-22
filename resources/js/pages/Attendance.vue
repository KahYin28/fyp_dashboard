<template>
    <div>
        <div><p>{{now}}</p></div>
        <div class="overflow-auto">
            <div class="container">
                <b-table-simple hover small caption-top responsive
                                :students="students"
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
                        <b-tr v-for="(student , index) in students.data"
                              :key="student.student_id">
                            <b-td>{{ index+1 }}</b-td>
                            <b-td>{{ student.student_id }}</b-td>
                          <router-link :to="{path:'/emotion',query:{id:student.student_id}}"> <b-td>{{ student.name }}</b-td></router-link>
                            <b-td>{{student.programme}}</b-td>
                            <b-td>{{student.faculty.name}}</b-td>
                            <b-td>
                                <label class="form-checkbox">
                                    <input type="checkbox" :value="student.register" v-model="checkAttend">
                                </label>
                            </b-td>
                        </b-tr>
                    </b-tbody>
<!--                    <b-tfoot>-->
<!--                        <b-tr>-->
<!--                            <b-td colspan="7" variant="secondary" class="text-right">-->
<!--                                Total Rows: <b>{{students.length}}</b>-->
<!--                            </b-td>-->
<!--                        </b-tr>-->
<!--                    </b-tfoot>-->
                </b-table-simple>
                <pagination :data="students"
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
            'pagination':pagination
        },
        data() {
            return {
                students: {},
                perPage: 5,
                currentPage: 1,
                now: new Date(),
                checkAttend: [],
            }
        },
        mounted() {
            this.getStudentList();
            this.getPageResults();
        },
        methods:{
          getStudentList() {
              this.lesson_id = this.$route.query.lesson_id;
              console.log(this.lesson_id);
              axios.get('student')
                  // .then(( {data}) => (this.students = data));
                  //          console.log(this.students)
                  .then(data => {
                      this.students = data.data;

                      //compare lesson id from student table

              })
          },

            // getStudentList() {
            //     axios.get('student')
            //         .then(response => (
            //             console.log(response),
            //                 this.std = response.data,
            //                 console.log(this.students)
            //         ))
            // },

            getPageResults(page = 1) {
                axios.get('/student?page=' + page)
                    .then(response => {
                        this.students = response.data;
                    //    console.log("asd" + this.students)

                    });
            }

        },
        computed: {
            rows() {
                return this.students.length
            },


        },
    }

</script>

<style scoped>

</style>
