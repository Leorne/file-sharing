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
                                        <span class="dropzone-title" v-text="getName"></span>
                                        <span class="dropzone-title" v-text="getSize"></span>
                                        <span class="dropzone-title" v-text="getType"></span>
                                    </div>
                                    <input type="file" name="file"
                                           class="dropzone-area input-dropzone form-control-file mb-3"
                                           @change="onChange">
                                </div>
                            </form>
                            <div class="text-center">
                                <input type="button" class="btn btn-primary" @click="submit" value="Upload file.">
                            </div>
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
    export default {

        computed: {
            canUpload() {
                return window.App.signedIn;
            },

            getName() {
                return 'Name:  ' + `'${this.file.name}'`;
            },

            getSize() {
              return 'Size:  ' + `${this.file.size}`;
            },

            getType() {
                return 'Type:  ' + `${this.file.type}`;
            },
        },

        watch: {
          file() {
            console.log(this.file);

          },
        },

        data() {
            return {
                file: null,
            }
        },

        methods: {
            onChange(e) {
                if (!e.target.files.length) return null;
                this.file = e.target.files[0];
            },

            submit() {
                let data = new FormData();
                if (!(!!this.file)) return flash('Please select file to upload!', 'error');
                data.append('file', this.file);
                axios.post('/upload', data)
                    .then(this.success).finally(() => {
                        this.file = null
                });
            },

            success(response) {
                let data = (response.status === 200) ? response.data : null;
                data ? this.redirect(data) : flash('Error, try again', 'error');
            },

            redirect(url) {
                window.location.replace(url);
            },
        },


    }
</script>
