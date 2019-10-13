<template>
    <div>
        <div class="form-group" v-if="signedIn">
            <label for="body">Reply:</label>
            <textarea name="body"
                      id="body"
                      class="form-control mb-2"
                      rows="4"
                      v-model="body">
            </textarea>
            <button type="submit" :disabled="this.canSubmit" class="btn btn-dark" @click="addReply">Post</button>
        </div>
        <div v-else>
            <p class="text-center">
                Please <a href="/login">sign in</a> to participate in this discussion
            </p>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: '',
                loading: false,
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            },

            canSubmit () {
                return ((this.loading) || (this.body === ''));
            }
        },

        methods: {
            addReply() {
                this.loading = !this.loading;
                axios.post(location.pathname + '/reply', {body: this.body})
                    .then(({data}) => {
                        this.loading = !this.loading;
                        this.body = '';
                        flash('Your reply has been posted');
                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
