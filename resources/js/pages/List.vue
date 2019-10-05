<template>
    <div class="container">
        <search-form @searched="fetch"></search-form>
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
            fetch(page) {
                axios.get(this.url(page)).then(this.refresh)
            },

            url(page) {
                if (!page) {
                    let query =  location.search ?location.search.match(/page=(\d+)/): 1;
                    page = (query[1] <= this.dataSet.last_page) ? query[1] : 1;
                }

                return `${location.pathname}?page=${page}`;
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
