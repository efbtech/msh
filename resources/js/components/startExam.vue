<template>
    <div>
        <section class="wallet">
            <div class="container">

                <div class="row bg-white ">
                    <div class="col-md-8  border-right">
                        <div class="row mt-2">
                            <div class="col align-self-start">
                                <h4 class="text-gray-900 font-semibold mb-4">
                                    Exam Title
                                </h4>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm">
                                        <i style="font-style: normal; color: green;">total duration</i>
                                        <br>
                                        <i style="font-weight: bold; font-style: normal;">{{ total_duration }} Minutes</i>
                                    </div>

                                    <div class="col-sm">
                                        <i style="font-style: normal; color: green;">No. of Questions</i>
                                        <br>
                                        <i style="font-weight: bold; font-style: normal;">{{total_question}} Questions</i>
                                    </div>

                                    <!-- <div class="col-sm">
                                        <i style="font-style: normal; color: green;">Total Marks</i>
                                        <br>
                                        <i style="font-weight: bold; font-style: normal;">1 mark</i>
                                    </div> -->
                                </div>

                                <div class="row">
                                    <!-- description part -->
                                    <div class="col-md-12  mt-2 mb-2">
                                        Descriptions : Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                        eiusmod temprure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
                                        qui officia deserunt mollit anim id est laborum."
                                    </div>
                                    <hr>
                                    <div class="col-md-12 mt-4">
                                        <h4 class="text-gray-900 font-semibold mb-4">
                                            Exam Instructions
                                        </h4>
                                        <div class="prose text-gray-800 mb-2">
                                            <ul>
                                                <li>Total duration of exam is {{ total_duration }} minutes.</li>
                                                <li>The quiz contains {{ total_question }} questions.</li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div>
                                        <br>
                                        <h4 class="text-gray-900 font-semibold mb-4">
                                            Standard Instructions
                                        </h4>
                                    </div>
                                    <div class="mb-4">
                                        <div class="prose text-gray-800 mb-2">
                                            <ul>
                                                <li>The clock will be set at the server. The countdown timer in the top
                                                    right corner of screen will display the remaining time available for you
                                                    to complete the test. When the timer reaches zero, the test will end by
                                                    itself.</li>
                                                <li>Click on the question number in the Question Palette at the right of
                                                    your screen to go to that numbered question directly. Note that using
                                                    this option does <strong>NOT</strong> save your answer to the current
                                                    question.</li>
                                                <li>Click on <b>Save &amp; Next</b> to save your answer for the current
                                                    question and then go to the next question.</li>
                                                <li>The Question Palette displayed on the right side of screen will show the
                                                    status of each question.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4  border">

                        <div class=" colmd-12 form-group mt-2 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="checked">
                            <label class="form-check-label" for="exampleCheck1">I've read all the instructions carefully and
                                have understood them.</label>
                        </div>

                        <div class="col-md-12  mt-2">
                            <!-- <a class="btn btn-success btn-md btn-block" href="/exam-init/2" role="button">Start Test</a> -->
                            <a v-show="checked" class="btn btn-success btn-md btn-block" v-on:click="initExam()"
                                role="button">Start Test</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
import { log } from '../utils/utils';
export default {
    props: ["url", "address", "phone", "email_text", "facebook_link", "exam_id","total_duration","total_question"],
    data() {
        return {
            name: "",
            email: "",
            subject: "",
            message: "",
            examId: "",
            errors: {},
            examCard: {},
            checked: false,
        };
    },
    mounted() {
        console.log('mount success');
        // this.getRandomExam();
    },
    methods: {

        initExam: function () {
            let obj = this
            let retriveItem = JSON.parse(localStorage.getItem("User"));
            // console.log(retriveItem.user_id);
            axios.post('/exam-init', { 'examId': this.exam_id, 'userId': retriveItem.user_id })
                .then(function (res) {
                    console.log("code", res.data.code);
                    if (res.data) {
                        //redirect to session start
                        var url = "exam-init/" + res.data.exam_id + "/" + res.data.code;
                        window.location.href = "/" + url;
                        // obj.initExamWithSession(url);                       
                    }
                })
                .catch()
        },

        initExamWithSession: function (url) {

            axios.get(url)
                .then(function (res) {
                    // if (res.data) {
                    //     //open-redirect
                    //     window.location.href = "http://qwiktest.test/redirect-qwiktest?email=" + res.data.email
                    // }
                })
                .catch()
        }
    },

};
</script>
