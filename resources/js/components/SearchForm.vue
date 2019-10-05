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
                this.updateUrl();
                this.$emit('searched', this.searchText);
                // this.searchText = null;
                l
            },

            updateUrl(){
                let newUrl = new URL(location);
                newUrl.searchParams.append('foo', 'bar');
                // newUrl.searchParams.append('foo', 'bar');
                // newUrl.searchParams.append('foo', 'bar');
            },
        },
    }
</script>
