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
                            <b-th>Attend</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody >
                        <b-tr v-for="(register,index) in registers.data"
                              :key="register.id"
                           >
                            <b-td >{{ index+1 }}</b-td>
                            <router-link :to="{path:'/emotion',query:{id:register.student_id}}">
                            <b-td>{{register.student_id}}</b-td>
                            </router-link>
                            <b-td>{{register.students.name}}</b-td>
                            <b-td >{{register.students.programme}}</b-td>
                            <b-td>
                                <label class="form-checkbox">
                                    <input type="checkbox" :value="register.student" v-model="checkAttend">
                                </label>
                            </b-td>

                        </b-tr>

                    </b-tbody>
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
                // lesson_id:null,
                // loading:false,
                error:'',
                lesson_id : this.$route.query.lesson_id
            }
        },
        mounted() {
            this.getStudentList();
        },
        watch:{
            '$route'(to,from){
                to.query.lesson_id;
            }
        },
        methods: {
            getStudentList() {
                //get lesson id from register table to query student list
                // this.lesson_id = this.$route.query.lesson_id;
                console.log(this.lesson_id);
                axios.get('register?lesson_id=' + this.lesson_id)
                    .then(data => {
                        console.log(data)
                        this.registers = data.data;
                        console.log(this.registers)
                        // console.log(this.registers.data[0].students.programme)
                    })
            },
            getResults(page = 1) {
                this.lesson_id = this.$route.query.lesson_id;
                axios.get('register?lesson_id=' + this.lesson_id + '&page=' + page)
                    .then(response => {
                        this.registers = response.data;
                        console.log("asd" + this.registers)
                    })
                    .catch(err => {
                        this.loading = false;
                        this.error = err;
                    });
            },
        },

    }
</script>
<style scoped>
</style>
