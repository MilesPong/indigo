<template>
    <form class="" :action="formAction" method="post" ref="form" @submit.prevent="onSubmit">

        <slot></slot>

        <div class="row right-align">
            <button class="btn waves-effect waves-light" type="submit">Submit
                <i class="material-icons right">send</i>
            </button>
        </div>

    </form>
</template>

<script>
    export default {
        props: {
            formAction: {
                type: String,
                required: true
            },
            redirectUrl: {
                type: String
            }
        },
        methods: {
            onSubmit () {
                let form = this.$refs['form']; // reference to form element
                let fd = new FormData(form);

                // for (let [key, val] of fd.entries()) {
                //     console.log(`{ [${key}]: ${val} }`)
                // }

                this.$http.post(form.action, fd).then(this.successHandler).catch(this.errorHandler);
            },
            successHandler (response) {
                let vue = this;
                swal(
                    'Done!',
                    'Operation is successful.',
                    'success'
                ).then(result => {
                    if (vue.redirectUrl) {
                        window.location.href = vue.redirectUrl;
                    }
                })
            },
            errorHandler (error) {
                // TODO only handle 422 error now
                if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    // console.log(error.response.data);
                    // console.log(error.response.status);
                    // console.log(error.response.headers);

                    // Validation error
                    if (error.response.status === 422) {
                        this.showValidationError(error.response.data)
                    }
                } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    console.log(error.request);
                } else {
                    // Something happened in setting up the request that triggered an Error
                    console.log('Error', error.message);
                }
                // console.log(error.config);
            },
            showValidationError (obj) {
                swal({
                    title: obj.message,
                    html: this.convertToHtml(obj.errors),
                    type: 'error'
                })
            },
            convertToHtml (errors) {
                let msg = '<div>';
                Object.values(errors).forEach(itemArr => {
                    itemArr.forEach(errorMsg => {
                        msg += `<li>${errorMsg}</li>`
                    })
                });
                return msg + '</div>';
            }
        }
    }
</script>