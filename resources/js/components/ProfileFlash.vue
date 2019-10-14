<style>
    .name {
        color: black;
    }

    .name:hover {
        color: #1b97a0;
    }

    .user {
        position: relative;
    }

    .user-info {
        position: absolute;
        display:block;
        margin-top: 17px;
        background: #ffffff;
        padding: 10px;
        box-shadow: 0px 0px 15px 2px #222222;
        top: 10px;
        z-index: 9999;
    }
</style>

<template>
        <span>
            <span class="user" @mouseover="hover = true" @mouseleave="hover = false" >
                <img class="m-1"
                     :src="user.avatar_path" width="20px" height="20px"><a
                class="name" :href="this.profilePath" v-text="user.name"></a>
            </span>
            <div class="user-info" v-show="hover">
                <div class="row">
                    <div class="col-6" style="border-right: 1px solid #494949">
                        <img :src="user.avatar_path" class="img-fluid" alt="" width="150" height="150">
                    </div>
                    <div class="col-6 text-center">
                        <a :href="this.profilePath" class="name" v-text="user.name"></a>
                        <p class="text-muted small" v-text="user.status_message"></p>
                        <span style="display: block" class="text-left">
                            <p class="fas fa-comments"></p>
                            {{ user.replies_count }}
                        </span>
                        <span style="display: block" class="text-left">
                            <p class="fas fa-upload"></p>
                            {{ user.uploads_count}}
                        </span>
                    </div>
                </div>
            </div>
        </span>
</template>

<script>
    export default {
        props: ['user'],

        computed: {
        },

        data() {
            return {
                hover: false,
                profilePath: location.origin + '/profiles/' + this.user.id,
            }
        },
    }
</script>
