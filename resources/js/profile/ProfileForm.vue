<template>
    <div>
        <avatar-form :user="this.user"></avatar-form>
    </div>
</template>

<script>
    import AvatarForm from "./AvatarForm.vue";
    import StatusForm from "./StatusForm.vue";

    export default {
        components: {AvatarForm, StatusForm},

        props: ['user'],
    }
</script>
