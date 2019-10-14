<template>
    <div class="form-group mb-2">
        <input type="text" class="" name="searchText" placeholder="Search..." id="searchText" @keyup.enter="search" v-model="searchText">
        <input type="button" class="btn btn-dark" value="Search" @click="search">
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
            search() {
                let searching = ['searching', this.searchText, 1];
                this.$emit('searching', searching);
            },
        },
    }
</script>
