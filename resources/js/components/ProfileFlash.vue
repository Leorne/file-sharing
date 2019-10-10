<style>
    a{
        color: black;
    }
    a:hover {
        color: #1b97a0;
    }

    .poster{
        /*display: inline;*/
        position:relative;
    }
    .descr{
        display:none;
        margin-top:17px;
        background: #ffffff;
        padding: 10px;
        box-shadow: 0px 0px 15px 2px #222222;
    }
    .poster:hover .descr{
        display:block;
        position:absolute;
        top:10px;
        z-index: 9999;
        /*width: auto;*/
    }
</style>

<template>
    <span>
        <div class="poster">
            <img class="m-1"
                 :src="user.avatar_path" width="20px" height="20px"><a
            :href="this.profilePath" v-text="user.name"></a>
            <div class="descr">
                <div class="row justify-content-between">
                    <div class="col-6" style="border-right: 1px solid #494949">
                        <img :src="user.avatar_path" class="img-fluid" alt="" width="150" height="150">
                    </div>
                    <div class="col-6 text-center">
                        <a :href="this.profilePath" class="" v-text="user.name"></a>
                        <p class="text-muted small" v-text="user.status_message"></p>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    export default{
        props: ['user'],

        data() {
            return {
                profilePath: location.origin + '/profiles/' + this.user.id,
            }
        },
    }
</script>
