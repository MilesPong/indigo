<template>
    <div>
        <select :name="showName" :id="elemId" :multiple="isMultiple">
            <option disabled>Please choose</option>

            <slot></slot>

        </select>
        <label :for="elemId">{{ label }}</label>
    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true
            },
            isMultiple: {
                type: Boolean,
                default: false
            },
            label: {
                type: String,
                required: true
            },
            selected: {
                type: String,
                default: () => '[]'
            }
        },
        computed: {
            showName () {
                return this.isMultiple ? `${this.name}[]` : this.name
            },
            elemId () {
                return this.name
            }
        },
        mounted () {
            this.setDefaultSelected()
            new M.Select(document.querySelector(`#${this.elemId}`))
        },
        methods: {
            setDefaultSelected () {
                JSON.parse(this.selected).forEach(val => {
                    $(`#${this.elemId}`).find(`option[value='${val}']`).prop('selected', true)
                })
            }
        }
    }
</script>