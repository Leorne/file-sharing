<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li class="page-item" v-show="prevUrl">
            <a class="page-link" href="#" aria-label="Previous" @click.prevent="page--">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <span v-for="n in dataSet.last_page">
            <li :class="classes"><a class="page-link" @click.prevent="page = n" href="#" v-text="n"></a></li>
        </span>
        <li class="page-item" v-show="nextUrl">
            <a class="page-link" href="#" aria-label="Next" @click.prevent="page++">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>

</template>

<script>
    export default {
        props: ['dataSet'],
        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
                location: location.pathname
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

            page() {
                this.broadcast();
            },

        },

        computed: {
            classes() {
                return ['page-item']
            },

            shouldPaginate() {
                return !!(this.prevUrl || this.nextUrl);
            },
        },

        methods: {
            broadcast() {
                let page = ['page', this.page];
                this.$emit('changed', page);
            },
        }
    }
</script>
