<template>
    <div>
        <div class="text-center card p-2 m-2">
            <img :src="avatar" class="img-fluid mx-auto d-block my-4 avatar" width="200px" height="200px">
            <h1 v-text="this.user.name"></h1>
            <status-form class="m-2" :user="this.user"></status-form>
        </div>

        <form v-if="canUpdate" method="POST" class="form-control-file" enctype="multipart/form-data">
            <div class="card p-3 mx-auto">
                <h4 class="text-center">Change your avatar here.</h4>
                <input type="file" name="avatar" class="my-1" accept="image/*" @change="onChange">
            </div>
        </form>

    </div>
</template>

<script>
    import StatusForm from "./StatusForm";
    export default {
        components: { StatusForm },

        props: ['user'],

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
            }
        },

        data() {
            return {
                avatar: this.user.avatar_path,
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
                }

                this.submit(newAvatar);
            },

            submit(newAvatar) {
                let data = new FormData();
                data.append('avatar', newAvatar);

                axios.post(`/profiles/${this.user.id}/avatar`, data)
                    .then(flash('Avatar updated!'));
            },
        }
    }
</script>
