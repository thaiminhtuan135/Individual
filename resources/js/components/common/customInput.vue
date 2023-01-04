<template>
    <div class="form-field mt-5">
        <Field class="text text-color form-input form-control input" rules="required" placeholder=" " name="name"/>
        <label for="name" class="form-label">Tuan</label>
    </div>
</template>

<script>
import {Field, ErrorMessage, defineRule, configure} from "vee-validate";
import * as rules from "@vee-validate/rules";
import {localize} from "@vee-validate/i18n";

export default {
    setup() {
        Object.keys(rules).forEach((rule) => {
            if (rule != "default") {
                defineRule(rule, rules[rule]);
            }
        });
        return {};
    },
    // created() {
    //     let messError = {
    //         en: {
    //             fields: {
    //                 name: {
    //                     required: "Không được để trống",
    //                     max: "Nhập tối đa 128 ký tự",
    //                 },
    //             },
    //         },
    //     };
    //     configure({
    //         generateMessage: localize(messError),
    //     });
    // },
    // data(){
    //     return {
    //         username : ""
    //     }
    // },
    props: ["name", "label"],
    components: {
        Field,
        ErrorMessage,
    },
}
</script>

<style scoped>
.input {
    border-color: #6a5af9;
}

.error {
    color: red;
}
</style>
