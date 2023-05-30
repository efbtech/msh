<style>
.rightside span {
    padding: 10px;
    margin: 10px;
    display: block;
    color: #FFF;
}

.rightside span i {
    margin: 13px;
}
</style>
<template>
    <div>
        <section>
            <div class="container">
                <div class="row bg-white ">
                    <div class="col-md-8 border border-right">
                        <div class="row mt-2">

                            <div class="col align-self-start">

                                <h4 class="text-gray-900 font-semibold mb-4">
                                    Q. No. {{ questionNo }}
                                </h4>
                            </div>
                            <div class="col align-end">
                                <h3>
                                    Timer : {{ countDownInMinute }} min {{ countDown }} sec
                                </h3>

                            </div>
                            <hr>
                            <div class="col-md-12">

                                <div class="row">
                                    <div col-md-12>
                                        <h4 class="text-gray-900 font-semibold mb-4"> Question :
                                        </h4>
                                        <p>{{ originalQuestion }}</p>

                                    </div>

                                </div>

                                <hr>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="text-gray-900 font-semibold mb-4"> Select Options From Below :-
                                        </h4>
                                        <p><input type="checkbox" value="option1" v-model="given_answers"> {{
                                            sessionQuestionOptions.opt1 }}</p>
                                        <p><input type="checkbox" value="option2" v-model="given_answers"> {{
                                            sessionQuestionOptions.opt2 }}</p>
                                        <p><input type="checkbox" value="option3" v-model="given_answers">{{
                                            sessionQuestionOptions.opt3 }}</p>
                                        <p><input type="checkbox" value="option4" v-model="given_answers"> {{
                                            sessionQuestionOptions.opt4 }}</p>

                                        <!-- Tru False-->
                                        <!-- <p><input type="radio" name="givenanswer" value="1" style="border: 1px solid red; width: 20px; height: 20px; opacity: unset; position: relative; top: 5px;"> True | <input name="givenanswer" type="radio" value="0" style="border: 1px solid red; width: 20px; height: 20px; opacity: unset; position: relative; top: 5px;"> False</p> -->

                                        <hr>
                                        <p style="text-align: right;"><input class="btn btn-success" type="button"
                                                @click="nextQuestion()" value="Next" :disabled='examCompleted'></p>


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4  border rightside">
                        <span style="background: rgb(2, 67, 2);"><i>{{ answered }}</i>Answered</span>
                        <span style="background:rgba(140, 7, 7, 0.662)"><i>{{ notAnswered }}</i>Not Answered</span>
                        <span style="background: rgb(158, 158, 6);"><i>{{ notVisitedAnswere }}</i>Not visited</span>
                        <span style="background: rgb(19, 88, 114);"><i>{{ totalQuestionCount }}</i>Total Questions</span>
                        <div style="text-align: center;">
                            <hr> <a type="button" :href="'/exam-finish/' + session_code + '/thanks-you'" value="Finish Test"
                                class="btn btn-lg btn-danger" style="width:100%;" :disabled='isDisabledFinishButton'>Finish
                                Test</a>
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
    props: ["url", "address", "phone", "email_text", "facebook_link", "twitter_link", "linkden_link", "about_company", "session_code"],
    data() {
        return {
            questionNo: 1,
            originalQuestion: "Ip lorem Contrary to popular belief",
            sessionQuestionOptions: {},
            given_answers: [],
            answered: 0,
            notAnswered: 0,
            notVisitedAnswere: 0,
            isDisabledFinishButton: true,
            totalQuestionCount: 0,
            examCompleted: false,
            countDown: 60,
            countDownInMinute: 0,
        };
    },
    created() {
        this.countDownTimer()
    },
    mounted() {
        console.log(' initExamSession mount success');
        console.log('session_code', this.session_code);
        this.getExamSessionQuestion();

    },
    methods: {
        countDownTimer() {
            if (this.countDown > 0) {
                setTimeout(() => {
                    this.countDown -= 1
                    this.countDownTimer()
                }, 1000)
            } else {
                var countMin = this.countDownInMinute - 1
                if (countMin >= 0) {
                    this.countDownInMinute -= 1
                    this.countDown = 60
                    this.countDownTimer()
                }

            }
        },


        getExamSessionQuestion: function () {
            console.log("question no .")
            const obj = this;
            // get loggedin  user detail
            let retriveItem = JSON.parse(localStorage.getItem("User"));
            let sessionCode = obj.session_code;
            axios.post('/fetch-exam-session-question', { 'userId': retriveItem.user_id, 'sessionCode': sessionCode, 'questionNo': this.questionNo })
                .then(function (res) {
                    if (res.data.code == 200 && res.data.error == false) {
                        // set exam info
                        obj.answered = res.data.examInfo.answered
                        obj.notAnswered = res.data.examInfo.notAnswered
                        obj.notVisitedAnswere = res.data.examInfo.notVisted
                        obj.totalQuestionCount = res.data.examInfo.totalQuestionCount

                        //set question detail 
                        obj.questionNo = res.data.fetchQuestion.questionSn
                        obj.originalQuestion = res.data.fetchQuestion.originalQuestion
                        obj.sessionQuestionOptions = res.data.fetchQuestion.options
                        obj.countDownInMinute = res.data.exam_time -1


                    }
                })
                .catch(function (error) {
                    console.error(error);
                })

        },

        nextQuestion: function () {

            console.log("next question clicked");
            const obj = this;
            // get loggedin  user detail
            let retriveItem = JSON.parse(localStorage.getItem("User"));
            let sessionCode = obj.session_code;
            let answered = obj.given_answers;
            axios.post('/fetch-exam-session-next-question', { 'userId': retriveItem.user_id, 'sessionCode': sessionCode, 'questionNo': this.questionNo, 'answered': answered })
                .then(function (res) {
                    if (res.data.code == 200 && res.data.error == false && res.data.examCompleted == false) {

                        //clear previous answere
                        obj.given_answers = []
                        // set exam info
                        obj.answered = res.data.examInfo.answered
                        obj.notAnswered = res.data.examInfo.notAnswered
                        obj.notVisitedAnswere = res.data.examInfo.notVisted
                        obj.totalQuestionCount = res.data.examInfo.totalQuestionCount

                        //set question detail 
                        obj.questionNo = res.data.fetchQuestion.questionSn
                        obj.originalQuestion = res.data.fetchQuestion.originalQuestion
                        obj.sessionQuestionOptions = res.data.fetchQuestion.options
                        
                    }

                    if (res.data.code == 200 && res.data.error == false && res.data.examCompleted == true) {
                        // set exam info
                        obj.answered = res.data.examInfo.answered
                        obj.notAnswered = res.data.examInfo.notAnswered
                        obj.notVisitedAnswere = res.data.examInfo.notVisted
                        obj.totalQuestionCount = res.data.examInfo.totalQuestionCount

                        //set exam complete
                        obj.examCompleted = res.data.examCompleted
                        obj.isDisabledFinishButton = false

                        //stop timer
                        obj.countDownInMinute = -1
                        obj.countDown = 1

                    }
                })
                .catch(function (error) {
                    console.error(error);
                })
        }
    },

};
</script>
