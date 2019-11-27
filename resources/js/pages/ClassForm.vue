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
                                        <select v-model="selectedLesson" name="lesson" class="form-control"
                                                @change="onChange($event)">
                                            <option :value="null" disabled>-- Please select an option --</option>
                                            <option v-for="lesson in lessonCollection"
                                                    :value="lesson.id">
                                                Course Code: {{ lesson.course_code }} ;
                                                Group{{lesson.group}} ;
                                                Day: {{lesson.schedule_day}} ;
                                                Start: {{lesson.starting_date_time }} ;
                                                End: {{lesson.ending_date_time }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>Selected: <strong>{{this.selectedLesson }}</strong></div>

<!--                            <b-card title="Class" sub-title="Card subtitle">-->
<!--                                <b-card-text>-->
<!--                                    <b-card-text>Course : {{this.selected}}</b-card-text>-->
<!--                                    <b-card-text>Time : {{}}</b-card-text>-->
<!--                                </b-card-text>-->
<!--                            </b-card>-->
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
                                        <label>Lesson:</label>
                                        <div class="col-sm-10">
                                    <select v-model="selectedLesson" name="lesson" class="form-control"
                                            @change="onChange($event)">
                                        <option :value="null" disabled>-- Please select an lesson --</option>
                                        <option v-for="lesson in lessonCollection"
                                                :value="lesson.id">
                                            Semester : {{lesson.semester}} ;
                                            Course Code: {{ lesson.course_code }} ;
                                            Group{{lesson.group}} ;

                                        </option>
                                    </select>
                                    </div>
                                    </div>

                                    <!-- input for venue-->
                                    <div class="form-group row">
                                        <label>Venue:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control"  v-model="selectedVenue">
                                                <option v-for="venue in venueCollection"
                                                        :value="venue.id">
                                                    {{ venue.name }}
                                                </option>
                                            </select>
                                            <p>
                                                Venue: {{selectedVenue}}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- input for days-->
                                    <div class="form-group row">
                                        <label>Day:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control"  v-model="selectedDay">
                                                <option v-for="day in days"
                                                        :value="day">
                                                    {{ day }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <!-- input for Start Time-->
                                    <div class="form-group row">
                                        <label>Start Time:</label>
                                        <div class="col-sm-10">
                                            <date-picker v-model="startingDateTime" :config="options"></date-picker>
                                            <p>
                                                Start Time: {{startingDateTime}}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- input for End Time-->
                                    <div class="form-group row">
                                        <label>End Time:</label>
                                        <div class="col-sm-10">
                                            <date-picker v-model="endingDateTime" :config="options"></date-picker>
                                            <p>
                                                End Time: {{endingDateTime}}
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
            this.getVenue();
        },

        data() {
            return {
                selectedLesson: '',
                selectedSemester: '',
                selectedCourse: '',

                selectedType: '',
                selectedVenue:'bk1',
                selectedDay: 'Monday',
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                typeName:['Lecture','Lab'],
                lessonCollection: null,
                venueCollection:null,
                startingDateTime:null,
                endingDateTime:null,

                lesson_id:null,

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
            /**request lesson to start class**/
            requestLesson() {
                this.user_id = 1;
                axios.get('lesson?user_id=' + this.user_id)
                // ,{
                //     headers:{
                //             'Accept':'application/json'
                //     }
                // }
                    .then(response => {
                        this.lessonCollection = response.data.data;
                        console.log(response.data.data[0]);
                        this.selectedLesson = "1";
                        //Need to do condition check current time match to data lesson time
                    });
            },

            /** get venue for replacement class.**/
            getVenue(){
                axios.get('venue')
                    .then(res=>{
                        this.venueCollection = res.data.data;
                        console.log(this.venueCollection);
                    })
            },
            /**pass params lesson_id to get Student Register List **/
            getAttendance() {
                this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson}});
            },

            getReplacementAttendance() {

            },
            /**create replacement class**/
            onCreateClass(){
                this.user_id = 1;
                axios.get('lesson?user_id=' + this.user_id)
                    .then(response => {
                        this.lessonCollection = response.data.data;
                        console.log(response.data.data[0])
                        this.selectedLesson = "1";

                        const formData = {
                            user_id: this.user_id,
                            lesson_id:this.selectedLesson,
                            venue_id:this.selectedVenue,
                            schedule_day:this.selectedDay,
                            starting_date_time:this.startingDateTime,
                            ending_date_time:this.endingDateTime,
                            status:1
                        };
                        console.log(formData);
                        axios.post('replacement', formData)
                            .then(res => {
                                    console.log(res);

                                    // if(res['data']['success']){
                                    //     console.log("alert success")
                                    // }
                                    //
                                    // if(res['data']['error']){
                                    //     console.log("alert error")
                                    // }
                                    //  this.$router.push({path: '/register', query: {lesson_id: this.selected}})
                                }
                            )
                            .catch(error => console.log(error))


                    });
                this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson}});
            },
        }
    }
</script>

<style scoped>

</style>
