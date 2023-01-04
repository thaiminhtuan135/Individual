<template>
        <div class="loading">
            <div style="--value : 1"></div>
            <div style="--value : 2"></div>
            <div style="--value : 3"></div>
            <div style="--value : 4"></div>
            <div style="--value : 5"></div>
            <div style="--value : 6"></div>
            <div style="--value : 7"></div>
            <div style="--value : 8"></div>
        </div>
</template>

<script>
export default {
    mounted() {
    },
    name: "loader",
    props : {
        flagShow :{
            type : String
        }
    },
    methods: {},

}
</script>

<style>

</style>
