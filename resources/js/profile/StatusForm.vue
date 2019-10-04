<template>
    <div>
        <div v-if="editing">
            <div class="col-3 mx-auto">
                <input class="form-control form-control-sm text-center" type="text" v-model="status_message" @keyup.enter="update" maxlength="20">
            </div>
        </div>
        <div v-else>
            <h6 @click="editing = true" v-text="status_message"></h6>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                status_message: this.user.status_message,
                editing: false,
            }
        },

        methods: {
            update() {
                axios.post('/profiles/' + this.user.id + '/status', {
                    status_message: this.status_message
                });

                this.editing = false;
                flash('Your status has been updated.')
            },
        }
    }
</script>
