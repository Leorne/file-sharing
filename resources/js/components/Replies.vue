<template>
    <div>
        <div class="card-header" v-text="repliesCount+' Comments:'"></div>
        <div class="card-body">
            <div v-for="(reply, index) in items" :key="reply.id">
                <reply :data="reply" @delete="remove(index)"></reply>
            </div>
            <paginator :dataSet="dataSet" @changed="fetch"></paginator>
        </div>
        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from "./NewReply";

    export default {
        props: ['initialRepliesCount'],
        components: {Reply, NewReply},
        data() {
            return {
                dataSet: false,
                items: [],
                repliesCount: this.initialRepliesCount,
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },

            url(page) {
                if (!page) {
                    let query =  location.search ?location.search.match(/page=(\d+)/): 1;
                    page = (query[1] <= this.dataSet.last_page) ? query[1] : 1;
                }

                return `${location.pathname}/reply?page=${page}`;
            },

            refresh(response) {
                this.dataSet = response.data;
                this.items = response.data.data;
                // window.scrollTo(0,0);
            },

            add(reply) {
                //
                this.repliesCount++;
                this.fetch();
            },

            remove(index) {
                this.items.splice(index, 1);
                this.repliesCount--;
                // this.fetch();
            }
        }
    }
</script>
