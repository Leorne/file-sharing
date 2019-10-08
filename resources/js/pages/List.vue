<template>
    <div class="container">
        <search-form @searching="fetch"></search-form>
        <paginator :dataSet="dataSet" @changed="fetch"></paginator>
        <div class="container">
            <div class="card-group">
                <div v-for="item in this.items" class="col-lg-4 col-sm-12 col-md-6 my-2">
                    <div class="card">
                        <div class="card-header">
                            <a :href="'/list/'+item.id" v-text="item.name"></a>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Uploader: <a :href="'/profiles/'+item.uploader.id" v-text="item.uploader.name"></a>
                            </p>
                            <p class="card-text" v-text="'Size: ' + item.size"></p>
                            <p class="card-text">
                                Uploaded at {{ item.created_at | moment }}
                            </p>
                        </div>
                        <div class="card-footer text-muted">
                            <p class="card-text" v-text="'Last activity was ' + item.updated_at"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SearchForm from "../components/SearchForm";
    import Paginator from "../components/Paginator";
    import moment from 'moment';

    export default {
        components: {Paginator, SearchForm},

        created() {
            this.fetch();
        },

        filters: {
            moment: function (date) {
                return moment(date).format('YY/M/D hh:mm');
            }
        },

        watch: {
            locate() {
                this.fetch()
            },
        },

        data() {
            return {
                items: [],
                dataSet: false,
                locate: location.href,
            }
        },

        methods: {
            fetch(newValue) {
                axios.get(this.url(newValue)).then(this.refresh)
            },

            url(newValue) {
                console.log('URL UPDATE');
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
                    //return page 1, when user use search filter
                    if (!!newValue[2]) {
                        queryMap.set('page', newValue[2]);
                    }
                    //build query string
                    query = '?';
                    let i = 0;
                    for (let value of queryMap) {
                        query += value[0] + '=' + value[1];
                        (i === (queryMap.size - 1)) ? null : query += '&';
                        i++;
                    }
                    history.pushState(null, null, query);
                    return `${location.pathname}/get/files${query}`;
                }
                return `${location.href}/get/files`;
            },

            refresh(response) {
                this.dataSet = response.data;
                this.items = response.data.data;
            },

        },

    }
</script>
