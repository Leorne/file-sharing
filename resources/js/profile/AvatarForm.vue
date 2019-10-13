<style>

</style>

<template>
    <div>
        <div class="text-center card p-2 m-2">
            <img :src="avatar" class="img-fluid mx-auto d-block my-4 avatar rounded-circle" width="200px" height="200px">
            <h1 v-text="this.user.name"></h1>
            <status-form class="m-2" :user="this.user"></status-form>
        </div>
        <div v-if="canUpdate">
            <input type="button" class="btn btn-dark" @click="toggleShow" value="Click here to change profile photo.">
            <my-upload field="avatar"
                       :lang-type="'en'"
                       @crop-success="cropSuccess"
                       @crop-upload-success="cropUploadSuccess"
                       @crop-upload-fail="cropUploadFail"
                       v-model="show"
                       :width="300"
                       :height="300"
                       :url="this.url"
                       :params="params"
                       :headers="headers"
                       img-format="png"></my-upload>
        </div>

    </div>
</template>

<script>
    import StatusForm from "./StatusForm";
    import myUpload from 'vue-image-crop-upload'

    export default {
        components: {StatusForm, myUpload},

        props: ['user'],


        data() {
            return {
                avatar: this.user.avatar_path,
                newAvatar: null,
                show: false,
                params: {
                    name: 'avatar',
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                url: `/profiles/${this.user.id}/avatar`,
            }
        },


        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
            }
        },


        methods: {
            toggleShow() {
              this.show = !this.show;
            },

            cropSuccess(newAvatar) {
                this.newAvatar = newAvatar;
                this.avatar = newAvatar;
            },

            cropUploadSuccess() {
                this.avatar = this.newAvatar;
                this.newAvatar = null;
                flash('Profile photo has been changed.');
            },

            cropUploadFail() {
                // this.toggleShow();
                flash('Please, try one more time or later.', 'error');
            },
        }
    }
</script>
