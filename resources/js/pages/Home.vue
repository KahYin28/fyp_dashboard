<template>
    <div>
        <app-class-form></app-class-form>
    </div>

</template>

<script>
    import ClassForm from "./ClassForm.vue";
    export default {
        name: "Home",

        components:{
            "app-class-form": ClassForm,
        }
    }
</script>

<style scoped>

</style>
