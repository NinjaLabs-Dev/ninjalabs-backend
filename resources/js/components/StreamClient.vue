<template>
    <div class="outer-container w-100 min-vh-100 d-flex justify-content-center align-items-center" :class="{ 'bg-dark': disabled }">
        <div class="pre-stream flex justify-content-center align-items-center flex-column" v-show="show.connect">
            <el-alert
                :title="disabledMessage"
                type="error"
                v-show="disabled"
                class="mb-4"
                show-icon
            ></el-alert>
            <el-button size="medium" :disabled="disabled" @click="showStream">Connect to Stream</el-button>
        </div>
        <div class="stream-container" v-show="show.stream"></div>
    </div>
</template>

<script>
import OT from '@opentok/client';

export default {
    name: "StreamClient",
    mounted() {
        // Check if browser can support RTC
        if(!OT.checkSystemRequirements()) {
            this.disabled = true;
            this.disabledMessage = 'This browser doesn\'t support RTC Streaming.';
            return;
        }

        this.session = OT.initSession(this.details.apiKey, this.details.sessionId);

        //console.log(session.streams);
    },
    methods: {
        showStream() {
            this.show.connect = false;
            this.show.stream = true;
            this.initStream();
        },
        initStream() {
            this.session.on('streamCreated', (event) => {
                console.log(event)
                //this.session.subscribe()
            })
        }
    },
    data() {
        return {
            disabled: false,
            disabledMessage: '',
            details: {
                apiKey: '45828062',
                sessionId: '1_MX40NTgyODA2Mn5-MTYyMDk0NTQwMDY2NX42cjhTdFZzRVFGenYwVzA3L0srYlo0WEp-UH4',
                apiToken: 'T1==cGFydG5lcl9pZD00NTgyODA2MiZzaWc9MzE4ZGU4ODJhZjEzZjE4MWExYzY4ZmE1YzRmZDdiYmNhNmM0YWFmZTpzZXNzaW9uX2lkPTFfTVg0ME5UZ3lPREEyTW41LU1UWXlNRGswTlRRd01EWTJOWDQyY2poVGRGWnpSVkZHZW5Zd1Z6QTNMMHNyWWxvMFdFcC1VSDQmY3JlYXRlX3RpbWU9MTYyMDk0NTQzMiZub25jZT0wLjMzNDI4NjA4MzYzMzU3NDM3JnJvbGU9cHVibGlzaGVyJmV4cGlyZV90aW1lPTE2MjEwMzE4MzI=',
            },
            show: {
                connect: true,
                stream: false
            },
            session: null
        }
    }
}
</script>

<style scoped>


</style>
