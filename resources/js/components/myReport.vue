
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
                                            Attamempt your AI based screening
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center h-100">
                                        <!-- <button class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn"
                                            v-if="this.User.role == 'Mentor'" type="button" id="withdraw"
                                            :disabled="current_balance == 0" data-bs-toggle="modal"
                                            data-bs-target="#withdrawModel">
                                            {{
                                                $t(
                                                    "wallet_log.btn_label_withdraw"
                                                )
                                            }}
                                        </button>

                                        <button class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn"
                                            v-else data-bs-toggle="modal" data-bs-target="#topUpModel">
                                            {{
                                                $t("wallet_log.btn_label_topup")
                                            }}
                                        </button> -->
                                        <a class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn" href="/my-exam">
                                            Start Screening
                                        </a>

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
                                                    Last 5  Screening report 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <tbody class="text-dark">
                                        <tr>
                                            <td class="py-3 ps-4">
                                                Date
                                            </td>
                                            <td class="py-3">
                                                Test Code
                                            </td>
                                            <td class="py-3">
                                                Download
                                            </td>
                                            <td class="py-3">
                                                Status
                                            </td>
                                        </tr>
                                        <tr v-for="rp in reportLogList">
                                            <td class="ps-4">{{ rp['completed_at'] }}</td>
                                            <td class="text-uppercase">
                                                {{ rp['code'] }}
                                            </td>
                                            <td>
                                               
                                                 <!-- <a href="http://qwiktest.test/exam/mutiple-choice/download-report/" class="btn btn-primary" role="button" aria-disabled="true">Primary link</a> -->
                                                <a :href="'/exam/'+ rp['code']+'/download'" class="btn btn-primary"><i  class="fa fa-download"></i> Download</a>
                                            </td>
                                            
                                            <td>
                                                <i class="fa-solid fa-check pe-2 text-success"></i>Report ready
                                            </td>

                                        </tr>
                                        <!-- <tr v-for="t in transactions" :key="t.id">
                                            <td class="ps-4">{{ t.date }}</td>
                                            <td class="text-uppercase">
                                                {{ t.time }}
                                            </td>
                                            <td> {{ currency_symbol }} {{ t.amount }}</td>
                                            <td class="text-success">
                                                {{ t.type }}
                                            </td>
                                            <td v-if="t.confirmed">
                                                <i class="fa-solid fa-check pe-2 text-success"></i>{{
                                                    $t(
                                                        "wallet_log.button.success"
                                                    )
                                                }}
                                            </td>
                                            <td v-else>
                                                <i class="fa-solid fa-times pe-2 text-danger"></i>{{
                                                    $t(
                                                        "wallet_log.button.decline"
                                                    )
                                                }}
                                            </td>

                                        </tr> -->

                                        <tr v-if="reportLogList.length < 1">
                                            <td colspan="5" class="text-center">
                                                No record found 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
    props: ["url", "address", "phone", "email_text", "facebook_link", "twitter_link", "linkden_link", "about_company"],
    data() {
        return {
            name: "",
            email: "",
            subject: "",
            message: "",
            errors: {},
            reportLogList :[],
        };
    },
    mounted(){
        this.reportLog();
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
                         window.location.href = "http://qwiktest.test/redirect-qwiktest?email="+res.data.email
                    }
                })
                .catch()
            console.log("screen first button working");

        },

        reportLog:function(){
            const obj  = this ;
            //get loggedin  user detail
            let retriveItem = JSON.parse(localStorage.getItem("User"));
         
            axios.post('/exam/get-report-logs',{ 'userId': retriveItem.user_id })
            .then(function(res){
                console.log(res.data);
                if(res.data){
                    obj.reportLogList =res.data

                }
            })
            .catch(function(error){
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
