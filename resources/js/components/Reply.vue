<template>
    <div :id="'reply-'+id" class="card mb-3">
        <div class="card-header">
            <div style="position: relative" class="row">
                    <div class="col-8">
                        <profile-flash :user="data.owner"></profile-flash>
                    </div>
                    <div class="col-4 text-right">
                        <span v-text="ago"></span>
                    </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                <button class="btn btn-danger btn-sm" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div>
            <div class="card-footer level" v-if="canUpdate">
                <button class="btn btn-sm btn-primary mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
            </div>
        </div>

    </div>
</template>


<script>
    import moment from 'moment';

    export default {
        props: ['data'],

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body
            }
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id == window.App.user.id)
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });
                this.editing = false;
                flash('Reply has been updated.');
            },
            destroy() {
                axios.delete('/replies/' + this.data.id).then(this.destroyResult);
            },
            destroyResult(response){
              if(response.status === 200){
                  this.$emit('delete', this.data.id);
                  flash('Reply has been deleted.');
              }
              else{
                  flash('Error', 'error');
              }
            },
        }
    }
</script>
