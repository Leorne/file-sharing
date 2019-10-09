<style>
    .avatar-input {
        cursor: pointer;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .avatar-text {
        color: #fff;
    }

    .avatar-form {
        background-color: #343a40;
    }
</style>

<template>
    <div>
        <div class="text-center card p-2 m-2">
            <img :src="avatar" class="img-fluid mx-auto d-block my-4 avatar" width="200px" height="200px">
            <h1 v-text="this.user.name"></h1>
            <status-form class="m-2" :user="this.user"></status-form>
        </div>

        <!--        <form v-if="canUpdate" method="POST" class="form-control-file" enctype="multipart/form-data">-->
        <!--            <div class="card mx-auto avatar-form">-->
        <!--                <h4 class="text-center avatar-text my-auto">Click here to change your avatar.</h4>-->
        <!--                <input type="file" name="avatar" class="avatar-input" accept="image/*" @change="onChange">-->
        <!--            </div>-->
        <!--        </form>-->
        <div id="">
            <a class="btn btn-primary" @click="toggleShow">set avatar</a>
            <my-upload field="img"
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
            <img :src="imgDataUrl">
        </div>

    </div>
</template>

<script>
    import StatusForm from "./StatusForm";
    import myUpload from 'vue-image-crop-upload'

    export default {
        components: {StatusForm, myUpload},

        props: ['user'],


        created() {
        },

        data() {
            return {
                avatar: this.user.avatar_path,
                show: false,
                params: {
                    name: 'avatar',
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                imgDataUrl: '',
                url: `/profiles/${this.user.id}/avatar`,
            }
        },


        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
            }
        },


        methods: {
            onChange(e) {
                if (!e.target.files.length) return null;
                let newAvatar = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(newAvatar);

                reader.onload = e => {
                    this.avatar = e.target.result;
                };

                this.submit(newAvatar);
            },

            submit(newAvatar) {
                let data = new FormData();
                data.append('avatar', newAvatar);

                axios.post(`/profiles/${this.user.id}/avatar`, data)
                    .then(flash('Avatar updated!'));
            },

            toggleShow() {
              this.show = !this.show;
            },

            cropSuccess(imageDataUrl, field) {
                flash('Crop success.');
                this.imgDataUrl = imageDataUrl;
            },

            cropUploadSuccess(jsonData, field) {
                flash('Crop upload success');
                console.log(jsonData);
                console.log('field: ' + field);
            },

            cropUploadFail(status, field) {
                flash('Upload fail', 'error');
                console.log(status);
                console.log('field: ' + field);
            },
        }
    }
</script>
