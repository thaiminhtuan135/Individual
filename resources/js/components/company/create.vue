<template>
    <CCard>
        <VeeForm as="div" v-slot="{ handleSubmit }" @invalid-submit="onInvalidSubmit">
            <form method="POST"
                  @submit="handleSubmit($event, onSubmit)"
                  :action="data.urlStore"
                  ref="formData"
                  enctype="multipart/form-data"
            >
                <Field type="hidden" :value="csrfToken" name="_token" />
                <CCardHeader class="text-color text">
                    Thêm  công ty
                </CCardHeader>
                <CCardBody>
                    <div class="row mb-3 d-flex justify-content-center">
                        <div class="form-field w-75">
                            <custom-input :label="'name'" :name="'name'" :input-value="model.name" v-model="model.name"/>
                            <ErrorMessage class="error" :name="'name'"/>
                        </div>
                    </div>
                    <div class="row mb-3 d-flex justify-content-center">
                        <div class="form-field w-75">
                            <custom-input :label="'address'" :name="'address'" :input-value="model.address" v-model="model.name"/>
                            <ErrorMessage class="error" :name="'address'"/>
                        </div>
                    </div>
                    <div class="row mb-3 d-flex justify-content-center">
                        <div class="form-field w-75">
                            <custom-input :label="'phone'" :name="'phone'" :input-value="model.name" v-model="model.name"/>
                            <ErrorMessage class="error" :name="'phone'"/>
                        </div>
                    </div>
                </CCardBody>
                <CCardFooter>
                    <div class="d-flex justify-content-center">
                        <button type="submit">Lưu</button>
                    </div>
                </CCardFooter>
            </form>
        </VeeForm>
    </CCard>
    <loader :flag-show="flagShowLoader"></loader>
</template>

<script>
import {
    Form as VeeForm,
    Field,
    ErrorMessage,
    defineRule,
    configure
} from "vee-validate";
import $ from "jquery";
import axios from "axios";
// import Loader from "../common/loader";
// import customInput from "../common/customInput";
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
    created() {
        let messError = {
            en: {
                fields: {
                    name: {
                        required: "Tên không được để trống",
                        max: "Nhập tối đa 128 ký tự",
                    },
                    address: {
                        required: "Địa chỉ không được để trống",
                        max: "Nhập tối đa 128 ký tự",
                    },
                    phone: {
                        required: "Điện thoại không được để trống",
                        max: "Nhập tối đa 128 ký tự",
                    },
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
        setTimeout(() => console.log('1'), 0);
        console.log('2');
        console.log('3');

    },
    props: ["data"],
    components: {
        Field,
        ErrorMessage,
        VeeForm,
    },
    data() {
        return {
            csrfToken: Laravel.csrfToken,
            flagShowLoader: false,
            model: {},
        }
    },
    methods :{
        onInvalidSubmit({ values, errors, results }) {
            let firstInputError = Object.entries(errors)[0][0];
            this.$el.querySelector("input[name=" + firstInputError + "]").focus();
            $("html, body").animate(
                {
                    scrollTop:
                        $("input[name=" + firstInputError + "]").offset().top - 150,
                },
                500
            );
        },
        onSubmit() {
                this.flagShowLoader = true;
                setTimeout(this.submit,2000);
                // this.$refs.formData.submit();
        },
        submit() {
            this.$refs.formData.submit();
        },
    }
}
</script>

<style scoped>
.error {
    color: red;
}
</style>
