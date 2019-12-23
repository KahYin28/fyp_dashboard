<template>
    <div>
        <!-- ON/OFF all interior AC  START -->
        <b-card
            title="Temperature"
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
            title="Current Temperature"
            style="max-width: 25rem;"
            class="mb-3"
        >
            <hr class="my-0">
            <b-card-text>
                <h1>24 &#8451;</h1>
            </b-card-text>
            <b-card-text>
                71 &#8457;
            </b-card-text>

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
    // // Create a client instance
    // client = new Paho.MQTT.Client("192.168.137.2", Number(1883), "");
    //
    // // set callback handlers
    // client.onConnectionLost = onConnectionLost;
    // client.onMessageArrived = onMessageArrived;
    //
    // // connect the client
    // client.connect({onSuccess:onConnect});
    //
    //
    // // called when the client connects
    // function onConnect() {
    //     // Once a connection has been made, make a subscription and send a message.
    //     console.log("onConnect");
    //     message = new Paho.MQTT.Message("Hello");
    //     message.destinationName = 'temperature';
    //     client.subscribe("temperature");
    //     client.send(message);
    // }
    //
    // // called when the client loses its connection
    // function onConnectionLost(responseObject) {
    //     if (responseObject.errorCode !== 0) {
    //         console.log("onConnectionLost:"+responseObject.errorMessage);
    //     }
    // }
    //
    // // called when a message arrives
    // function onMessageArrived(message) {
    //     console.log("onMessageArrived:"+message.payloadString);
    // }


    import Chart from "./../chart.js";

    export default {
        components: {
            Chart,

        },
        // data() {
        //
        // },




    }


</script>

<style scoped>
    .btn-outline-primary{
        padding: 5px 30px;
        margin: auto
    }
</style>
