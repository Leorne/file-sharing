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
            fetch(newValue) {
                axios.get(this.url(newValue))
                    .then(this.refresh);
            },

            url(newValue) {
                if (!!newValue) {
                    let queryMap = new Map();
                    let query = location.search;
                    //if query is not empty, get query params and set to map
                    if (!!query) {
                        let params = query.replace('?', '').split('&');
                        for (let i = 0; i < params.length; i++) {
                            let buff = params[i].split('=');
                            queryMap.set(buff[0], buff[1]);
                        }
                    }
                    //add new query value to map
                    queryMap.set(newValue[0], newValue[1]);
                    //build query string
                    query = '?';
                    let i = 0;
                    for (let value of queryMap) {
                        query += value[0] + '=' + value[1];
                        (i === (queryMap.size - 1)) ? null : query += '&';
                        i++;
                    }
                    history.pushState(null, null, query);
                    return `${location.pathname + '/reply'}${query}`;
                }
                return `${location.pathname + '/reply'}`;
            },

            refresh(response) {
                console.log('REFRESHED');
                console.log(response);

                this.dataSet = response.data;
                this.items = response.data.data;
            },

            add(reply) {
                let page;
                if(this.items.length >= this.dataSet.per_page){
                    page =['page', this.dataSet.current_page + 1];
                }
                else{
                    page = ['page', this.dataSet.current_page];
                }
                this.fetch(page);
                this.repliesCount++;
            },

            remove(index) {
                let page;
                if (this.dataSet.current_page === 1) {
                    page = ['page', 1];
                } else {
                    if (this.items.length === 1) {
                        page = ['page', this.dataSet.current_page - 1];
                    } else {
                        page = ['page', this.dataSet.current_page];
                    }
                }
                this.fetch(page);
                this.repliesCount--;
                this.items.splice(index,1);
            }
        }
    }
</script>
