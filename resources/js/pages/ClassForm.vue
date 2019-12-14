<template>
    <div>
        <div role="tablist">
            <!-- Class Tab -->
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
                                        <!-- Dropdown to select lesson -->
                                        <div class="form-group row">
                                            <label class="col-sm-6 col-form-label">
                                                Course and Group:
                                            </label>
                                            <div class="col-sm-8">
                                                <select v-model="selectedLesson" name="lesson" class="form-control"
                                                        @change="onChange()">
                                                    <option :value="null" disabled>-- Please select an option --
                                                    </option>
                                                    <option v-for="lesson in lessonCollection"
                                                            :value="lesson">
                                                        {{ lesson.course_code }}
                                                        ( Group {{lesson.group}} )
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Display selected lesson details -->
                                    <div class="mt-3">
                                        <b-card>
                                            <b-card-text>
                                                <div class="container">
                                                    <div>Semester:<strong>{{this.selectedLesson['semester']}}</strong></div>
                                                    <div>Course:<strong>{{this.selectedLesson['course_code']}}</strong></div>
                                                    <div>Lesson Type:<strong>{{this.selectedLesson['lesson_type_id']}}</strong></div>
                                                    <div>Group: <strong>{{this.selectedLesson['group']}}</strong></div>
                                                    <div>Venue: <strong>{{this.selectedLesson['venue_id']}}</strong></div>
                                                    <div>Schedule Day:<strong>{{this.selectedLesson['schedule_day']}}</strong></div>
                                                    <div>Start Time:<strong>{{this.selectedLesson['starting_date_time']}}</strong></div>
                                                    <div>End Time: <strong>{{this.selectedLesson['ending_date_time']}}</strong></div>
                                                </div>

                                            </b-card-text>
                                        </b-card>
                                    </div>
                                </div>
                            </div>
                        </b-card-text>

                        <b-card-text>
                            <div class="col-sm">
                                <button class="btn btn-primary" @click="getAttendance">Start Class</button>
                            </div>
                        </b-card-text>
                    </b-card-body>
                </b-collapse>
            </b-card>

            <!-- Replacement Class Tab -->
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
                                        <!-- Dropdown for Replacement Class -->
                                        <label>Lesson:</label>
                                        <div class="col-sm-10">
                                            <select v-model="selectedLesson" name="lesson" class="form-control"
                                                    @change="onChange($event)">
                                                <option :value="null" disabled>-- Please select an lesson --</option>
                                                <option v-for="lesson in lessonCollection"
                                                        :value="lesson">
                                                    Course Code: {{ lesson.course_code }}
                                                    ( Group {{lesson.group}} )
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- input for venue-->
                                    <div class="form-group row">
                                        <label>Venue:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" v-model="selectedReplacementVenue">
                                                <option v-for="venue in venueCollection"
                                                        :value="venue.id">
                                                    {{ venue.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- input for days-->
                                    <div class="form-group row">
                                        <label>Day:</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" v-model="selectedReplacementDay">
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
                                        </div>
                                    </div>
                                    <!-- input for End Time-->
                                    <div class="form-group row">
                                        <label>End Time:</label>
                                        <div class="col-sm-10">
                                            <date-picker v-model="endingDateTime" :config="options"></date-picker>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <b-card>
                                            <b-card-text>
                                                <div class="container">
                                                    <div>Semester:<strong>{{this.selectedLesson['semester']}}</strong></div>
                                                    <div>Course:<strong>{{this.selectedLesson['course_code']}}</strong></div>
                                                    <div>Group: <strong>{{this.selectedLesson['group']}}</strong></div>
<!--                                                    <div>Lesson Type: <strong>{{this.selectedLesson['group']}}</strong></div>-->
                                                    <div>Venue :<strong>{{selectedReplacementVenue}}</strong></div>
                                                    <div>Day :<strong>{{selectedReplacementDay}}</strong></div>
                                                    <div>Start Time :<strong>{{startingDateTime}}</strong></div>
                                                    <div>End Time :<strong>{{endingDateTime}}</strong></div>
                                                </div>
                                            </b-card-text>
                                        </b-card>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary" @click="onCreateReplacementClass">Create Class</button>
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
            this.getLessonCollection();
            this.getVenue();
        },
        data() {
            return {
                lessonCollection: null,
                venueCollection: null,
                selectedLesson: '',
                selectedSemester: '',
                selectedCourse: '',
                selectedType: '',

                selectedReplacementVenue: '',
                selectedReplacementDay: '',
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                typeName: ['Lecture', 'Lab','Test'],
                startingDateTime: null,
                endingDateTime: null,
                venueID: '',
                lesson_id: null,
                Date: new Date(),
                options: {
                    format: 'YYYY/MM/DD H:mm',
                    // format: 'DD/MM/YYYY hh:mm LT', //AM PM
                    useCurrent: true,
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
            },
            /**request lesson to start class**/
            getLessonCollection() {
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
                    })
            },
            /**pass params lesson_id to get Student Register List **/
            getAttendance() {
                console.log(this.selectedLesson);
                console.log(this.selectedLesson['id']);
                console.log(this.selectedLesson['venue_id']);
                this.$session.set('data', this.selectedLesson);

                const formData = {
                    status: 1
                };
                console.log(formData);
                axios.put('lesson/' + this.selectedLesson['id'], formData)
                    .then(res => {
                        console.log(res);
                        if (res['data']['success']) {
                            console.log("alert success");
                            this.createAttendancelist(this.selectedLesson['id']);
                            // this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson['id']}})
                        }
                        if (res['data']['error']) {
                            console.log("alert error")
                           // this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson['id']}})
                        }
                    })
                    .catch(error => console.log(error))
            },
            createAttendancelist(lesson_id) {
                console.log('updata_a');
                this.formdata = {'lesson_id': lesson_id};
                axios.post('lesson', this.formdata)
                    .then(res => {
                        console.log(res);
                        if (res['data']['success']) {
                            this.$router.push({path: '/register', query: {lesson_id: lesson_id}})
                        }
                    })

            },
            /** get venue for replacement class.**/
            getVenue() {
                axios.get('venue')
                    .then(res => {
                        this.venueCollection = res.data.data;
                        console.log(this.venueCollection);
                    })
            },
            /**create replacement class**/
            onCreateReplacementClass() {
                const formData = {
                    user_id: this.user_id,
                    lesson_id: this.selectedLesson.id,
                    venue_id: this.selectedReplacementVenue,
                    schedule_day: this.selectedReplacementDay,
                    starting_date_time: this.startingDateTime,
                    ending_date_time: this.endingDateTime,
                    status: 1
                };
                console.log(formData);

                axios.post('replacement', formData)
                    .then(res => {
                        console.log(res);
                        if (res['data']['success']) {
                            console.log("alert success")
                            this.getAttendance();
                            this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson['id']}})
                        }
                        if (res['data']['error']) {
                            console.log("alert error")
                            this.getAttendance();
                            this.$router.push({path: '/register', query: {lesson_id: this.selectedLesson['id']}})
                        }
                    })
                    .catch(error => console.log(error))
            },
        }
    }
</script>

<style scoped>

</style>
