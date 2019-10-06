<template>
    <div>
        <form action="">
            <input type="text" name="searchText" id="searchText" v-model="searchText">
            <input type="button" class="btn btn-dark" value="Search" @click="search">
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                searchText: null,
            }
        },

        methods: {
            search(){
                let searching = ['searching', this.searchText];
                this.$emit('searching', searching);
            },
        },
    }
</script>
