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
                <div class="py-6 " style="margin-bottom: 100px;">
                    <div class="flex flex-col items-center " style="background-color: rgb(60, 132, 60);border-radius: 1%;">
                        <div class="w-full">
                            <div class="w-full rounded shadow-lg p-8 bg-gradient-to-tl from-green-600 to-green-700">
                                <h1 class="text-2xl font-semibold leading-relaxed text-white" style="text-align: center;">
                                    Time's up! Thank You for attempting 
                                </h1>
                                <h1 class="text-2xl font-semibold leading-relaxed text-white" style="text-align: center;">
                                   {{ title_name }}
                                </h1>

                                <div class="row">

                                    <!-- <div class="col-md-4 mt-2" style="color: azure;text-align: center;">
                                        <h4>Hello</h4>
                                        <span ><p>Hello</p></span>
                                    </div>
                                    <div class="col-md-4 mt-2" style="color: azure;text-align: center;">
                                        <h4>Hello</h4>
                                        <span ><p>Hello</p></span>
                                    </div>
                                    <div class="col-md-4 mt-2" style="color: azure;text-align: center;">
                                        <h4>Hello</h4>
                                        <span ><p>Hello</p></span>
                                    </div> -->

                                    <div class="col-md-8 mt-4">
                                       
                                        <div class="col-md-4 mt-2 mb-2 float-end">
                                            <a type="button" class="btn btn-success" :href="'/exam/'+session_code+'/report'">View Report</a>
                                        </div>

                                    </div>

                                </div>

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
    props: ["url", "address", "phone", "email_text", "facebook_link", "twitter_link", "linkden_link", "about_company", "session_code","title_name"],
    data() {
        return {
            name: ''
        };
    },
    mounted() {
        console.log('thank you pages mounted');
    },
    methods: {

    },

};
</script>
