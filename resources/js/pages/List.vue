<template>
    <div class="container">
        <search-form @searching="fetch"></search-form>
        <paginator :dataSet="dataSet" @changed="fetch"></paginator>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="">
                <tr>
                    <th class="col-6">Name</th>
                    <th class="col-1">Size</th>
                    <th class="col-2">Created at</th>
                    <th class="col-2">Uploaded by</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in this.items">
                    <td><a :href="'/list/'+item.id" v-text="item.name"></a></td>
                    <td v-text="item.size"></td>
                    <td>{{ item.created_at | moment }}</td>
                    <td><a :href="'/profiles/'+item.uploader.id" v-text="item.uploader.name"></a></td>
                    <td class="text-center border-0">
                        <a :href="item.path"
                           class="btn btn-outline-dark"
                           :download="item.name">Download</a></td>
                </tr>
                </tbody>
            </table>
        </div>
        <paginator :dataSet="dataSet" @changed="fetch"></paginator>
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

        methods: {
            fetch(newValue) {
                axios.get(this.url(newValue)).then(this.refresh)
            },

            url(newValue) {
                if (!!newValue) {
                    console.log('UpDATE URL TO');
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
                    console.log(query);
                    history.pushState(null, null, query);
                    return `${location.pathname}${query}`;
                }
                return `${location}`;
            },

            refresh(response) {
                this.dataSet = response.data;
                this.items = response.data.data;
            },

        },

        data() {
            return {
                items: [],
                dataSet: false,

            }
        },
    }
</script>
