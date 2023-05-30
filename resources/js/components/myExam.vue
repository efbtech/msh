<template>
    <div>
        <section class="wallet">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-secondary ps-4 p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-0 text-white d-flex align-items-center">
                                        <span class="fw-bold ps-md-3">
                                            Screen First Checkup
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center h-100">

                                        <!-- <button class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn"
                                            type="button" v-on:click="screenFirst()">
                                            Screen First
                                        </button> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white mt-4">
                            <div class="py-3 border-bottom">
                                <div class="bg-light pe-3">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="p-3 d-flex align-items-center h-100">
                                                <p class="text-primary mb-0 fw-bold head ps-lg-2">
                                                    Start your test
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6  mx-4 my-4  shadow-lg p-3 mb-5 bg-grey rounded">
                                        <div class="card " >
                                            <div class="card-body ">
                                                <h5 class="card-title">{{ examCard.title ?  examCard.title : "Demo title for Exam" }}</h5>
                                                <p class="card-text">{{ examCard.description ? examCard.description :"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.."}}</p>
                                                <a :href="'/exam-start/'+ examCard.id+'/instructions'" class="btn btn-primary float-right">Start Exam</a>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="head text-primary fw-bold">
                            My Test
                            <span class="text-secondary"> Report</span>

                        </h2>

                        <p class="sub-head mt-3">
                            {{ $t('contact_us_section.paragraph_1') }}

                        </p>

                        <p class="sub-head mt-4">
                            {{ $t('contact_us_section.paragraph_2') }}

                        </p>
                    </div>

                    <div class="col-lg-6">
                        <div class="d-flex justify-content-center align-items-center h-100 mt-lg-0 mt-5">
                            <img src="/assets/images/my-report.jpg" alt="" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    </div>
</template>

<script>
import axios from 'axios';
import { log } from '../utils/utils';
export default {
    props: ["url", "address", "phone", "email_text", "facebook_link", "twitter_link", "linkden_link", "about_company"],
    data() {
        return {
            name: "",
            email: "",
            subject: "",
            message: "",
            errors: {},
            examCard: {},
        };
    },
    mounted() {
        console.log('mount success');
        this.getRandomExam();
    },
    methods: {

        screenFirst: function () {
            let retriveItem = JSON.parse(localStorage.getItem("User"));
            console.log(retriveItem.user_id);

            axios.post('/open-quiktest', { 'userId': retriveItem.user_id })
                .then(function (res) {
                    // console.log(res.data);
                    if (res.data) {
                        //open-redirect
                        window.location.href = "http://qwiktest.test/redirect-qwiktest?email=" + res.data.email
                    }
                })
                .catch()
            console.log("screen first button working");

        },

        getRandomExam: function () {
            console.log("calling.....")
            const obj = this;
            //get loggedin  user detail
            let retriveItem = JSON.parse(localStorage.getItem("User"));

            axios.post('/get-random-exam', { 'userId': retriveItem.user_id })
                .then(function (res) {
                    console.log(res.data.data);
                    if (res.data.data) {
                        obj.examCard = res.data.data

                    }
                })
                .catch(function (error) {
                    console.error(error);
                })

        },
        async sendContactFormData() {
            var self = this;
            var toast = this.$toasted;
            var params = {
                token: 123,
                name: this.name,
                email: this.email,
                message: this.message,
                subject: this.subject,
            };
            this.errors = {};
            const res = await axios
                .post("/api/contactus", params)
                .then((res) => {
                    if (res.data.Status) {
                        toast.success(res.data.msg);
                        this.name = "";
                        this.email = "";
                        this.message = "";
                        this.subject = "";
                    }
                    if (!res.data.Status) {
                        for (const property in res.data.errors) {
                            // toast.error(res.data.errors[property][0]);
                        }
                        this.errors = res.data.errors;
                    }
                });
        },
    },

};
</script>
