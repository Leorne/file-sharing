<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>

<template>
    <div v-if="this.type === 'success'" class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
    <div v-else-if="this.type === 'error'" class="alert alert-danger alert-flash" role="alert" v-show="show">
        <strong>Error!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message', 'typeMessage'],
        methods: {
            flash(message, typeMessage) {
                this.body = message;
                this.type = !!typeMessage ? typeMessage : 'success';
                this.show = true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        },

        data() {
            return {
                type: '',
                body: '',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message, this.typeMessage);
            }
            window.events.$on('flash', (message,typeMessage) => this.flash(message, typeMessage));
        },
    }
</script>

