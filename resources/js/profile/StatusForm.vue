<style>
    .light{
       color: #5f5f5f;
    }
</style>

<template>
    <div>
        <div v-if="editing">
            <div class="col-3 mx-auto">
                <input class="form-control form-control-sm text-center" type="text" v-model="status_message"
                       @keyup.enter="update" @keyup.esc="editing = false" maxlength="20">
            </div>
        </div>
        <div v-else>
            <div v-if="canUpdate">
                <span v-if="this.status_message === ''">
                    <h6 class="light" @click="editing = true" v-text="'Click to update your status'"></h6>
                </span>
                <span v-else>
                    <h6 @click="editing = true" v-text="status_message"></h6>
                </span>
            </div>
            <div v-else>
                <span v-if="this.status_message === ''">
                    <h6 class="light" v-text="'The user has nothing to say.'"></h6>
                </span>
                <span v-else>
                    <h6 v-text="status_message"></h6>
                </span>
            </div>
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


        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
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
