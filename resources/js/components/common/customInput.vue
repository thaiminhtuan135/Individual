<template>
    <div class="form-field mt-5">
        <Field class="text text-color form-input form-control input" rules="required" placeholder=" " :name="name"/>
        <label for="name" class="form-label">{{ label }}</label>
    </div>
</template>

<script>
import {Field} from "vee-validate";

export default {
    data(){
        return {
            model : {}
        }
    },
    props: ["name", "inputValue", "label"],
    components: {
        Field,
    },
}
</script>

<style scoped>
.input {
    border-color: #6a5af9;
}
</style>
