<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="fas fa-star" aria-hidden="true"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['file'],

        data() {
            return {
                count: this.file.favorites_count,
                isFavorited: this.file.isFavorited
            }
        },

        computed: {
            classes() {
                return ['btn mb-3', this.isFavorited ? 'btn-dark' : 'btn-light'];
            },

            endpoint() {
                return '/main/list/' + this.file.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                return this.isFavorited ? this.destroy() : this.create();
            },

            create() {
                axios.post(this.endpoint);
                this.isFavorited = true;
                this.count++
            },

            destroy(){
                axios.delete(this.endpoint);
                this.isFavorited = false;
                this.count--
            }
        }
    }
</script>
