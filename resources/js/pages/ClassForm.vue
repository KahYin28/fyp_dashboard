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
                                                @change="onChange()">
                                            <option :value="null" disabled>-- Please select an option --</option>
                                            <option v-for="lesson in lessonCollection"
                                                    :value="lesson">
                                                Course Code:{{ lesson.course_code }};
                                                Group{{lesson.group}};
                                                Day: {{lesson.schedule_day}};
                                                Start: {{lesson.starting_date_time}};
                                                End: {{lesson.ending_date_time }} ;

                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <b-card-text>
                            <div>Course Code : <strong>{{this.selectedLesson['course_code']}}</strong></div>
                            <div>Schedule Day : <strong>{{this.selectedLesson['schedule_day']}}</strong></div>
                            <div> Start : <strong>{{this.selectedLesson['starting_date_time']}}</strong></div>
                                <div> Start : <strong>{{this.selectedLesson['starting_date_time']}}</strong></div>

<!--                            <div>Selected: <strong>{{this.selectedLesson }}</strong></div>-->
                            </b-card-text>
                        </b-card-text>

                        <b-card-text>
                            <div class="col-sm">

<!--                                <router-link :to="{path: '/register', query: {lesson_id: this.selectedLesson}-->
<!--                                                     path:'/temperature', query: {venue_id: this.venueID}}" >-->
<!--                                    <button class="btn btn-primary">Start</button>-->
<!--                                </router-link>-->
                                <button class="btn btn-primary" @click="getAttendance">Start Class</button>

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
                                            Group{{lesson.group}};
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
            this.requestLessonCollection();
            this.getVenue();
            console.log('1');
        },
        data() {
            console.log('2');
            return {
                selectedLesson: '',
                selectedSemester: '',
                selectedCourse: '',
                venueID:'',

                selectedType: '',
                selectedVenue:'',
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
            onChange() {
               // console.log(this.selectedLesson['id'] );
               // console.log(this.selectedLesson['venue_id'] );
               // console.log('noob');
            },
            /**request lesson to start class**/
            requestLessonCollection() {
                this.user_id = 1;
                axios.get('lesson?user_id=' + this.user_id)
                // ,{
                //     headers:{
                //             'Accept':'application/json'
                //     }
                // }
                    .then(response => {
                        this.lessonCollection = response.data.data;
                        console.log(response.data.data);
                        // this.selectedLesson = "1";

                    });
            },

            getVenueID() {

                this.user_id = 1;
                axios.get('lesson?user_id=' + this.user_id + '&id=' + this.selectedLesson)
                    .then(response => {
                        this.lessonCollection = response.data.data;
                        console.log(response.data.data);
                        for (let i = 0; i < this.lessonCollection.length; i++) {
                            this.venueID = this.lessonCollection[i]['venue_id'];
                        }
                      console.log(this.venueID)
                    });

            },

            /**pass params lesson_id to get Student Register List **/
            getAttendance() {
                console.log(this.selectedLesson);
                 console.log(this.selectedLesson['id'] );
                 console.log(this.selectedLesson['venue_id'] );
                 console.log('noob');
                this.$session.set('noob', this.selectedLesson);

                this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson['id']}});
               //  this.$router.push({path: '/dashboard', query: {venue_id: this.venueID}});

            },





            /** get venue for replacement class.**/
            getVenue(){
                axios.get('venue')
                    .then(res=>{
                        this.venueCollection = res.data.data;
                        console.log(this.venueCollection);
                    })
            },
            /**create replacement class**/
            onCreateClass(){
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
                // this.update();
                axios.post('replacement', formData)
                    .then(res => {
                            console.log(res);
                            if(res['data']['success']){
                                console.log("alert success")
                                this.getAttendance();
                                this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson}})
                            }
                            if(res['data']['error']){
                                console.log("alert error")
                            }
                        })
                    .catch(error => console.log(error))


            },
        }
    }
</script>

<style scoped>

</style>
