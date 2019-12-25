<template>


    <div>

        <!--        <b-modal id="error-modal" title="BootstrapVue">-->
        <!--            <p class="my-4">{{error}}</p>-->

        <!--        </b-modal>-->
        <!--        <div v-if="error" class="alert alert-danger" role="alert">-->
        <!--          <p >{{error}}</p>-->
        <!--        </div>-->


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
                                                    <div>Semester:<strong>{{this.selectedLesson['semester']}}</strong>
                                                    </div>
                                                    <div>Course:<strong>{{this.selectedLesson['course_code']}}</strong>
                                                    </div>
                                                    <div>Lesson
                                                        Type:<strong>{{this.selectedLesson['lesson_type_id']}}</strong>
                                                    </div>
                                                    <div>Group: <strong>{{this.selectedLesson['group']}}</strong></div>
                                                    <div>Venue: <strong>{{this.selectedLesson['venue_id']}}</strong>
                                                    </div>
                                                    <div>Schedule
                                                        Day:<strong>{{this.selectedLesson['schedule_day']}}</strong>
                                                    </div>
                                                    <div>Start Time:<strong>{{this.selectedLesson['starting_date_time']}}</strong>
                                                    </div>
                                                    <div>End Time:
                                                        <strong>{{this.selectedLesson['ending_date_time']}}</strong>
                                                    </div>
                                                </div>

                                            </b-card-text>
                                        </b-card>
                                    </div>
                                </div>
                            </div>
                        </b-card-text>

                        <b-card-text>
                            <div class="col-sm">
                                <button class="btn btn-primary" @click="startNormalAttendance">Start Class</button>
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
                                                    <div>Semester:<strong>{{this.selectedLesson['semester']}}</strong>
                                                    </div>
                                                    <div>Course:<strong>{{this.selectedLesson['course_code']}}</strong>
                                                    </div>
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
                                        <button class="btn btn-primary" @click="onCreateReplacementClass">Create Class
                                        </button>
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
                typeName: ['Lecture', 'Lab', 'Test'],
                startingDateTime: null,
                endingDateTime: null,
                venueID: '',
                lesson_id: null,
                Date: new Date(),
                options: {
                    format: 'YYYY/MM/DD H:mm',
                    // format: 'DD/MM/YYYY hh:mm LT', //AM PM
                    useCurrent: true,
                    // daysOfWeekDisabled: [0, 6],
                    showClear: true,
                    showClose: true,
                },
                error: '',
                success: '',

            }
        },
        methods: {
            onChange() {

            },
            /**request lesson to start class**/
            getLessonCollection() {
                this.lecturer_id = 1;
                axios.get('lesson?lecturer_id=' + this.lecturer_id)
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
            /**pass params lesson_id to get Attendance List **/
            startNormalAttendance() {
                console.log(this.selectedLesson);
                console.log('start Normal');

                this.$session.set('data', this.selectedLesson);

                this.formdata = {'lesson_id': this.selectedLesson['id']};

                axios.post('lesson', this.formdata)
                    .then(res => {
                        console.log(res);
                        if (res['data']['success']) {
                            this.postVenue(this.selectedLesson['venue_id']);

                            this.success = res.data.success.message;
                            this.$bvModal.msgBoxOk(this.success).then(
                                value => {
                                    console.log(value);
                                    this.type = 'n';
                                  //  this.getNormalAttendancelist(this.selectedLesson['id'], this.type);
                                    this.postVenue(this.selectedLesson['venue_id']);
                                    this.$router.push({path: '/attendance', query: {lesson_id: this.selectedLesson['id'], type: this.type}})


                                })
                        }else {
                            if (res['data']['error']) {
                                console.log("alert error");

                                this.error = res.data.error.message;
                                // this.$bvModal.show('error-modal');
                                this.$bvModal.msgBoxOk(this.error).then(
                                    value => {
                                        console.log(value);
                                        this.type = 'n';
                                        this.postVenue(this.selectedLesson['venue_id']);
                                        // this.getNormalAttendancelist(this.selectedLesson['id'], this.type);

                                        this.$router.push({path: '/attendance', query: {lesson_id: this.selectedLesson['id'], type: this.type}})

                                    }
                                );
                                this.type = 'n';
                                this.$session.set('type', this.type);
                                this.try = this.$session.get('type');
                            }
                        }
                        }
                    )
                // axios.put('lesson/' + this.selectedLesson['id'], formData)
                //     .then(res => {
                //         console.log(res);
                //         if (res['data']['success']) {
                //             console.log("alert success");
                //             this.success = res.data.success.message;
                //             this.$bvModal.msgBoxOk(this.success).then(
                //                 value=>{
                //                     console.log(value);
                //                     this.type ='n';
                //                     this.getNormalAttendancelist(this.selectedLesson['id'], this.type);
                //                     this.postVenue(this.selectedLesson['venue_id']);
                //                 }
                //             );
                //
                //
                //         }
                //         if (res['data']['error']) {
                //             console.log("alert error");
                //
                //             this.error = res.data.error.message;
                //             // this.$bvModal.show('error-modal');
                //             this.$bvModal.msgBoxOk(this.error).then(
                //                 value=>{
                //                     console.log(value);
                //                     this.postVenue(this.selectedLesson['venue_id']);
                //                     this.getNormalAttendancelist(this.selectedLesson['id'], this.type);
                //                 }
                //             );
                //             this.type ='n';
                //             this.$session.set('type', this.type);
                //             this.try = this.$session.get('type');
                //
                //         }
                //     })
                //     .catch(error => console.log(error))
            },

            /**pass venue_id to get Sensor Data**/
            postVenue(venue_id) {
                console.log('update venue');
                this.formdata = {'venue_id': venue_id};
                axios.post('getSensorData', this.formdata)
                    .then(res => {
                        console.log(res);
                        if (res['data']['success']) {
                        }
                    })
            },
            // /**get lesson_id and route to attendance page**/
            // getNormalAttendancelist(lesson_id , type) {
            //
            //     this.formdata = {'lesson_id': lesson_id};
            //
            //     axios.post('lesson', this.formdata)
            //         .then(res => {
            //             console.log(res);
            //             if (res['data']['success']) {
            //                 this.$router.push({path: '/attend', query: {lesson_id: lesson_id, type: type}})
            //             }
            //         })
            // },
            getReplaceAttendancelist(lesson_id, type) {
                this.$router.push({path: '/attendance', query: {lesson_id: lesson_id, type: type}})

            },

            /**<---Replacement Class --->**/
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
                console.log('start replace');
                this.$session.set('data', this.selectedLesson);
                this.type = 'r';
                const formData = {
                    user_id: this.user_id,
                    lesson_id: this.selectedLesson.id,
                    venue_id: this.selectedReplacementVenue,
                    schedule_day: this.selectedReplacementDay,
                    starting_date_time: this.startingDateTime,
                    ending_date_time: this.endingDateTime,
                    status: 1,
                    type: this.type
                };
                console.log(formData);

                axios.post('replacement', formData)
                    .then(res => {
                        console.log(res);
                        if (res['data']['success']) {
                            console.log("alert success")
                            this.$session.set('type', this.type);
                            this.getReplaceAttendancelist(this.selectedLesson['id'], this.type);
                        }
                        if (res['data']['error']) {
                            console.log("alert error")
                            // this.getAttendance();
                            // this.$router.push({path: '/attend', query: {lesson_id: this.selectedLesson['id']}})
                        }
                    })
                    .catch(error => console.log(error))
            },
        }
    }
</script>

<style scoped>

</style>
