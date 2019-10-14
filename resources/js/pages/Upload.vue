<style>
    .dropzone-area {
        width: auto;
        height: 200px;
        position: relative;
        border: 2px dashed #1b97a0;
    }

    .dropzone-area:hover {
        border: 2px dashed #0d2ca0;
    }

    .dropzone-area .input-dropzone {
        cursor: pointer;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        opacity: 0;
    }

    .dropzone-text {
        position: relative;
        top: 35%;
        width: 100%;

    }

    .dropzone-title {
        color: #1b97a0;
        position: relative;
        top: 40%;
        text-align: center;
        width: 100%;
        display: block;
        padding-left: 10%;
        padding-right: 10%;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dropzone-info {
        color: #565d63;
        position: relative;
        top: 40%;
        text-align: center;
        width: 100%;
        display: block;
        font-size: 80%;
    }

    .loading {
        position: relative;
        display: block;
        text-align: center;
    }


    .loading-text {
        position: relative;
        display: block;
        padding-left: 40%;
        padding-right: 40%;
        text-align: center;
    }

</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div v-if="canUpload">
                            <span class="text-center">
                            <h1>
                                Hello. You can upload the file!
                            </h1>
                            </span>
                            <form class="form-control-file" method="POST" enctype="multipart/form-data">
                                <div class="dropzone-area form-group">
                                    <div class="dropzone-text" v-if="!(!!this.file)">
                                        <span class="dropzone-title">Drop file here or click at area to select</span>
                                        <span class="dropzone-info">File size should be not more then 100MB</span>
                                    </div>
                                    <div class="dropzone-text" v-else>
                                        <span v-if="!this.loading">
                                            <span class="dropzone-title" v-text="getName"></span>
                                            <span class="dropzone-title" v-text="getSize"></span>
                                            <span class="dropzone-title" v-text="getType"></span>
                                        </span>
                                        <div v-else class="">
                                            <div class="loading">
                                                <circles-to-rhombuses-spinner
                                                    class="mx-auto mb-1"
                                                    :animation-duration="2000"
                                                    :circles-num="3"
                                                    :circles-size="25"
                                                    :color="'#343a40'"
                                                />
                                            </div>
                                            <div class="loading text-center">
                                                <h4>Uploading file.Please wait...</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" name="file"
                                           class="dropzone-area input-dropzone form-control-file mb-3"
                                           @change="onChange">
                                </div>
                            </form>
                            <form method="POST" @submit.prevent="validate">
                                <vue-recaptcha
                                    ref="recaptcha"
                                    size="invisible"
                                    :sitekey="sitekey"
                                    @verify="sendFile"
                                    @expired="onCaptchaExpired"
                                />
                                <div class="text-center" v-if="!this.loading">
                                    <input type="submit" class="btn btn-dark" value="Upload file.">
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <span class="text-center">
                            <h1>
                                Hello. You must be logged in to upload a file.
                            </h1>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueRecaptcha from 'vue-recaptcha'
    import {CirclesToRhombusesSpinner} from 'epic-spinners'

    export default {

        components: {CirclesToRhombusesSpinner, VueRecaptcha},

        computed: {
            canUpload() {
                return window.App.signedIn;
            },

            getName() {
                return 'Name:  ' + `${this.file.name}`;
            },

            getSize() {
                let bytes = this.file.size;
                let units = ['B', 'KB', 'MB', 'GB', 'TB'];
                let i = 0;
                while (bytes >= 1024) {
                    bytes /= 1024;
                    i++;
                }
                i = (units.length < i) ? 4 : i;
                let formatSize = Math.round(bytes) + ' ' + units[i];
                return 'Size:  ' + `~${formatSize}`;
            },

            getType() {
                let type = this.file.type;
                type = type.split('/');
                return 'Type:  ' + `${type[0]}`;
            },
        },

        data() {
            return {
                file: null,
                loading: false,
                submit: false,
                sitekey: '6Lc_Tb0UAAAAAFGzvq6KJGvKgmFrUQYCYbtQT32V',
                sendData: null,
                error: null
            }
        },

        methods: {
            onChange(e) {
                if (!e.target.files.length) return null;
                this.file = e.target.files[0];
                this.submit = !this.submit;
            },

            sendFile(recaptchaToken) {
                this.submit = !this.submit;
                this.loading = !this.loading;
                this.sendData.append('recaptcha_token', recaptchaToken);
                axios.post('/upload', this.sendData)
                   .catch(this.errorFlash)
                    .then(this.success);
            },

            errorFlash(error) {
                if(!!error){
                    !!error.response.data.error ? flash(error.response.data.error, 'error') : flash('Sorry. Something went wrong.','error');
                    this.file = null;
                    this.loading = !this.loading;
                }
            },

            success(response) {
                if (response.status === 200){
                    this.redirect((response.data));
                }
                this.file = null;
                this.loading = !this.loading;
            },

            redirect(url) {
                window.location.replace(url)
                    .finally(() => {
                        this.file = null;
                        this.loading = !this.loading;
                        this.submit = !this.submit;
                    });
            },

            onCaptchaExpired() {
                this.$refs.recaptcha.reset()
            },

            validate() {
                if (!(!!this.file)) return flash('Please select file to upload!', 'error');
                let data = new FormData();
                data.append('file', this.file);
                this.sendData = data;
                this.$refs.recaptcha.execute()
            },
        },
    }
</script>
