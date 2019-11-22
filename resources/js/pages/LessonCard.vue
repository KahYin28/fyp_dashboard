<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: "Lesson",
        data() {
          return {
              lessons:[],
          }
        },
        mounted() {
                axios.get('lesson')
                    .then(response => (
                        console.log(response),
                            this.lessons = response.data.data,
                            console.log(this.lessons)
                    ))
        },
    }
</script>

<style scoped>

</style>
