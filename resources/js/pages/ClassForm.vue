<template>
    <div>
        <div role="tablist">
            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block href="#" v-b-toggle.accordion-1 variant="info">Class</b-button>
                </b-card-header>
                <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <b-card-text>
                            <div class="mb-3">
                                <div class="container">
                                    <div class="col-sm">
                                        <h4>Lessons</h4>
                                        <select v-model="selected" name="lesson" class="form-control"
                                                @change="onChange($event)">
                                            <option :value="null" disabled>-- Please select an option --</option>
                                            <option v-for="lesson in lessonCollection"
                                                    :value="lesson.id">
                                                Course Code: {{ lesson.course_code }};
                                                Day: {{lesson.schedule_day}};
                                                Time: {{lesson.schedule_time}};
                                                Group{{lesson.group}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>Selected: <strong>{{this.selected }}</strong></div>
                            <b-card title="Class" sub-title="Card subtitle">
                                <b-card-text>
                                    <b-card-text>Course : {{this.selected }}</b-card-text>
<!--                                    <b-card-text>Day : {{this.selected }}</b-card-text>-->
<!--                                    <b-card-text>Time : {{}}</b-card-text>-->
                                </b-card-text>
                            </b-card>
                        </b-card-text>

                        <b-card-text>
                            <div class="col-sm">
                                <!--  <router-link :to="{path:'/attend',query:{id:user_id}}">-->
                                <button class="btn btn-primary" @click="getAttendance">Start Class</button>
                                <!--   </router-link>-->
                            </div>
                        </b-card-text>
                    </b-card-body>
                </b-collapse>
            </b-card>

            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block href="#" v-b-toggle.accordion-2 variant="info">Replacement Class</b-button>
                </b-card-header>
                <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <b-card-text>
                            <div class="container">
                                <form>
                                    <div class="form-group row">
                                        <!-- input for semester-->
                                        <label for="semester">Semesters:</label>
                                        <div class="col-sm-10">
                                            <select id="semester" class="form-control" v-model="selectedSemester">
                                                <option v-for="lesson in lessonCollection"
                                                        :value="lesson.semester">
                                                    {{ lesson.semester }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <p>{{selectedSemester}}</p>
                                    <!-- input for Course Name and Code-->
                                    <div class="form-group row">
                                        <label for="course_code">Course:</label>
                                        <div class="col-sm-10">
                                            <select id="course_code" class="form-control" v-model="selectedCourse">
                                                <option v-for="lesson in lessonCollection"
                                                        :value="lesson.course_code">
                                                    {{ lesson.course_code }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <p>{{selectedCourse}}</p>
                                    <!-- input for Course Type-->
                                    <div class="form-group row">
                                        <label>Type:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control"  v-model="selectedType">
                                                <option v-for="lesson in lessonCollection"
                                                        :value="lesson.id">

                                                    {{ lesson.lesson_type.id }}
                                                    <!--                                                use predefined input-->
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- input for Start Time-->
                                    <div class="form-group row">
                                        <label>Start:</label>
                                        <div class="col-sm-10">
                                            <date-picker v-model="startingDateTime" :config="options"></date-picker>
                                        </div>
                                    </div>
                                    <!-- input for End Time-->
                                    <div class="form-group row">
                                        <label>End:</label>
                                        <div class="col-sm-10">
                                            <date-picker v-model="endingDateTime" :config="options">

                                            </date-picker>
                                            <p>
                                                v-model: {{endingDateTime}}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group">

<!--                                        <input type="button" value="Create Class" class="btn btn-info" @click="onCreateClass">-->
                                  <button class="btn btn-primary" @click="onCreateClass">Create Class</button>
                                    </div>
                                </form>
                            </div>
                        </b-card-text>
                    </b-card-body>

                </b-collapse>
            </b-card>

        </div>
    </div>

</template>

<script>
    import datePicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import axios from 'axios';


    export default {
        components: {
            'datePicker': datePicker,
        },
        mounted() {
            this.requestLesson();
        },

        data() {
            return {
                selected: '',
                selectedSemester: '',
                selectedCourse: '',
                selectedType: '',
                selectedDay: 'Monday',
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                typeName:['Lecture','Lab'],
                lessonCollection: null,
                startingDateTime:null,
                endingDateTime:null,

                Date: new Date(),
                options: {
                    format: 'YYYY/MM/DD hh:mm',
                    // format: 'DD/MM/YYYY hh:mm LT', //AM PM
                    useCurrent: false,
                    daysOfWeekDisabled: [0, 6],
                    showClear: true,
                    showClose: true,

                },

            }
        },
        methods: {
            onChange(event) {
                console.log(event.target.value)
            },
            requestLesson() {
                this.user_id = 1;
                axios.get('lesson?user_id=' + this.user_id)
                // ,{
                //     headers:{
                //             'Accept':'application/json'
                //
                //     }
                // }
                    .then(response => {
                        this.lessonCollection = response.data.data;
                        console.log(response.data.data[0])
                        this.selected = "1";
                        //Need to do condition check current time match to data lesson time
                    });
            },
            getAttendance() {
                this.$router.push({path: '/register', query: {lesson_id: this.selected}});

            },

            onCreateClass(){
                const formData = {
                    semester: this.selectedSemester,
                    course_code: this.selectedCourse,
                    starting_date_time:this.startingDateTime,
                    ending_date_time:this.endingDateTime,
                    lesson_type_id:this.selectedType,
                    // user_id:1,
                    // hobbies: this.hobbyInputs.map(hobby => hobby.value),
                }
             //  console.log(formData);
                // this.user_id = 1;
                axios.post('lesson', formData)
                    .then(res => {
                        console.log(res);
                                if(res['data']['success']){
                                    console.log("alert success")
                                }

                        if(res['data']['error']){
                            console.log("alert error")
                        }
                      //  this.$router.push({path: '/register', query: {lesson_id: this.selected}})
                        }
                    )
                    .catch(error => console.log(error))


            },




        }

    }
</script>

<style scoped>

</style>
