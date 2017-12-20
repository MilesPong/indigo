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

                if (!this.isDestroy) {
                    window.location.href = this.url;
                } else {
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                    }).then((res) => {
                        if (res.value) {
                            this.handleDelete(e.target);
                        }
                    });
                }
            },
            handleDelete (el) {
                this.$http.delete(this.url).then(() => {
                    this.removeElement(el.closest('tr'));
                    swal(
                        'Deleted!',
                        'This record has been deleted.',
                        'success'
                    );
                }).catch(err => {
                    swal(
                        'Error!',
                        "Something went wrong.",
                        'error'
                    );
                })
            },
            removeElement (el) {
                $(el).hide('slow', () => $(el).remove())
            }
        }
    }
</script>