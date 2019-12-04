<template>
    <div>
        <!-- ON/OFF all interior lights  START -->
        <b-card
            title="Interior Lights"
            style="max-width: 30rem;"
            class="mb-3"
        >
            <hr class="my-0">

            <div class="mt-3" data-controls="switch-lights-in">
                <b-button data-action="all-on"  @click="switchOnLight" type="button" class="btn btn-primary">All <strong>ON</strong></b-button>
                <b-button data-action="all-off" @click="switchOffLight"type="button" class="btn btn-secondary">All <strong>OFF</strong>
                </b-button>
            </div>
        </b-card>
        <!-- ON/OFF all interior lights  END -->

        <!-- ON/OFF each interior lights  START -->
        <b-card
            title="Lights A"
            style="max-width: 30rem;"
            class="mb-3-float-left"
        >
         <div>
                <toggle-button class="float-right-lg" @change="onChange" v-model="checked" :labels="true"/>
                <!--            <toggle-button-->
                <!--                :value="false" :color="color" :sync="true"   :labels="true"-->
                <!--            />-->
                <!--            <toggle-button-->
                <!--                :value="true" :labels="{checked: 'Active', uncheked: 'What now?'}"-->
                <!--            />-->

            </div>

            <hr class="my-0">

            <div class="mt-3">
                <!-- light details START -->
                <b-list-group flush>
                    <b-list-group-item>
                        <p class="specs float-left">Connection</p>
                        <p class="ml-auto mb-0 text-success float-right">OK</p>
                    </b-list-group-item>
                    <b-list-group-item>
                        <p class="specs float-left">Power Consumption</p>
                        <p class="ml-auto mb-0 float-right">24W</p>
                    </b-list-group-item>

                </b-list-group>
                <!-- light details END -->
            </div>
        </b-card>
        <!-- ON/OFF each interior lights  END -->

    </div>
</template>

<script>

    export default {
        name: "Lights",
        props: {
            defaultChecked: {
                type: Boolean, default: false
            }
        },
        data() {
            return {
                checked: this.defaultChecked
            }
        },

        methods: {
            onChange() {
                this.$emit('input', this.checked)
            },
            switchOnLight(){
                axios.get('http://192.168.31.92/api/lightControl?on=Turn On')
                    .then(res=>{
                        console.log(res);
                    });
            },
            switchOffLight(){
                axios.get('http://192.168.31.92/api/lightControl?off=Turn On')
                    .then(res=>{
                        console.log(res);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
