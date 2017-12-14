<template>
    <a class="btn-floating waves-effect waves-light" :href="url">
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
            }
        },
        computed: {
            url () {
                return this.link.replace(/:id/, this.identifier)
            }
        }
    }
</script>