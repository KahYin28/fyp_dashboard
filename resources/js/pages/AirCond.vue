<template>
    <div>
        <!-- ON/OFF all interior AC  START -->
        <b-card
            title="Air Conditioners"
            style="max-width: 30rem;"
            class="mb-3"
        >
            <hr class="my-0">

            <div class="mt-3" data-controls="switch-lights-in">
                <b-button data-action="all-on" type="button" class="btn btn-primary">All <strong>ON</strong></b-button>
                <b-button data-action="all-off" type="button" class="btn btn-secondary">All <strong>OFF</strong>
                </b-button>
            </div>
        </b-card>
        <!-- ON/OFF all interior AC  END -->

        <!-- ON/OFF each interior AC  START -->
        <b-card
            title="Air Conditioner A"
            style="max-width: 25rem;"
            class="mb-3"
        >
            <hr class="my-0">
            <b-card-text>
               Desired Temperature
            </b-card-text>
            <b-card-text>
                24 &#8451;
            </b-card-text>
            <b-card-text>
                71 &#8457;
            </b-card-text>

            <VueSlideBar
                v-model="sliderValue"
                class="demo-demo"
                :min="16"
                :max="31"
                :showTooltip="true"
                :lineHeight="13"
                :tooltipStyles="{ backgroundColor: 'blue', borderColor: 'blue' }"
            />

            <div>
                <h6>Degree: {{ sliderValue }}</h6>
                <div class="center">

                    <b-button variant="outline-primary"  @click="sliderValue--"><b> - </b></b-button>
                    <b-button variant="outline-primary"  @click="sliderValue++"><b> + </b></b-button>

                </div>
            </div>
            <div>

            </div>

        </b-card>
        <!-- ON/OFF each interior AC  END -->


        <div style="width: 300px">
<!--            <chart v-if="loaded"-->
<!--                   :chart-data="dataCollection">-->

<!--            </chart>-->
        </div>
    </div>
</template>

<script>
    import VueSlideBar from 'vue-slide-bar'
    import Chart from "./../chart.js";

    export default {
        components: {
            Chart,
            VueSlideBar

        },
        data() {
            return {
                sliderValue: 24
            };
        },



    }

</script>

<style scoped>
    .btn-outline-primary{
        padding: 5px 30px;
        margin: auto
    }
</style>
