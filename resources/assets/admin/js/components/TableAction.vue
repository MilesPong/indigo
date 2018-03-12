<template>
    <a class="btn-floating waves-effect waves-light" @click="linkClick">
        <i class="material-icons">{{ icon }}</i>
    </a>
</template>

<script>
    export default {
        props: {
            link: {
                type: String,
                required: true
            },
            identifier: {
                type: String,
                required: true
            },
            icon: {
                type: String,
                required: true
            },
            isDestroy: {
                type: Boolean,
                default: false
            },
            isRestore: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            url () {
                return this.link.replace(/:id/, this.identifier);
            }
        },
        methods: {
            linkClick (e) {
                e.preventDefault();

                if (this.isDestroy) {
                    this.handleDelete(e.target);
                } else if (this.isRestore) {
                    this.handleRestore(e.target);
                } else {
                    window.location.href = this.url;
                }
            },
            handleDelete (el) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((res) => {
                    if (res.value) {
                        this.performDelete(el);
                    }
                });
            },
            performDelete (el) {
                this.$http.delete(this.url).then(() => {
                    this.removeElement(el.closest('tr'));
                    swal(
                        'Deleted!',
                        'This record has been deleted.',
                        'success'
                    );
                }).catch(err => this.showError(err))
            },
            handleRestore (el) {
                swal({
                    title: 'Are you sure?',
                    text: "You are restoring this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, restore it!'
                }).then((res) => {
                    if (res.value) {
                        this.performRestore(el);
                    }
                });
            },
            performRestore (el) {
                this.$http.post(this.url).then(() => {
                    this.removeElement(el.closest('tr'));
                    swal(
                        'Restored!',
                        'This record has been restored.',
                        'success'
                    );
                }).catch(err => this.showError(err))
            },
            showError (error) {
                swal(
                    'Error!',
                    "Something went wrong.",
                    'error'
                );
            },
            removeElement (el) {
                $(el).hide('slow', () => $(el).remove())
            }
        }
    }
</script>