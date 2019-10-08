<style>
    .page-link {
        border: 1px solid #343a40;
        background-color: transparent;
        color: #343a40;
    }

    .page-link.page-current {
        background-color: #343a40;
        color: #fff;
    }

    .page-link:hover {
        background-color: #343a40;
        color: #fff;
    }
</style>

<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li class="page-item" v-show="prevUrl">
            <a class="page-link ml-1" href="#" aria-label="Previous" @click.prevent="page--">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <span v-for="n in dataSet.last_page">
            <li class="page-item"><a class="page-link ml-1" :class="(n === page) ? 'page-current' : ''" @click.prevent="page = n" href="#" v-text="n"></a></li>
        </span>
        <li class="page-item" v-show="nextUrl">
            <a class="page-link ml-1" href="#" aria-label="Next" @click.prevent="page++">
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
