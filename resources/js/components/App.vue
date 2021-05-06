<template>
    <div class="col-md-6 m-auto border-danger">
        <div class="card-body">
            <form @submit.prevent="storeData">
                <div class="mb-3 col-md-12 m-auto">
                    <label for="task_name" class="form-label">Task Name</label>
                    <input type="text" v-model="taskFrom.name" @change="errorTrue" class="form-control" @click="checkValue" :class="errors == true ? 'is-invalid':''" id="task_name" placeholder="Enter Your Task Name">
                </div>
                <div class="d-flex justify-content-lg-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" v-model="taskFrom.status" :checked="taskFrom.status ? false:true" id="active" value="active">
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" v-model="taskFrom.status" id="inactive" value="inactive">
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </div>
                </div>
                <div class="float-sm-end">
                    <button type="submit" v-bind:disabled="taskFrom.name ? false:true" class="btn btn-success btn-mm">
                        <span v-if="buttonSpanner">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</span>
                        <span v-else>Submit</span>
                    </button>
                    <div></div>
                </div>
            </form>
        </div>
        <br>
        <br>
        <get-items-component :items="items" v-on:loadItems="getData"></get-items-component>
    </div>
</template>

<script>
import getItemsComponent from "./getItemsComponent";

export default {
    name: "App",
    data() {
        return {
            taskFrom: {
                name: null,
                status: null
            },
            errors: false,
            items: [],
            buttonSpanner: false
        }
    },
    components: {
        getItemsComponent
    },
    created() {
        this.getData();
    },
    methods: {
        checkValue: function () {
            if (this.taskFrom.name) {
                return this.errors = false
            } else {
                return this.errors = true
            }
        },
        errorTrue: function () {
            if (this.taskFrom.name == null) {
                return this.errors = true
            } else {
                return this.errors = false
            }
        },
        getData: function () {
            axios.get('http://127.0.0.1:8000/api/items').then((res) => {
                this.items = res.data;
            });
        },
        storeData: function () {
            this.buttonSpanner = true
            axios.post('http://127.0.0.1:8000/api/items', this.taskFrom)
                .then((res) => {
                    this.getData();
                    this.buttonSpanner = false
                    this.taskFrom.name = null
                    Toast.fire({
                        icon: 'success',
                        title: res.data.success
                    })
                }).catch((error) => {
            });
        }
    }
}
</script>

<style scoped>
.btn-mm {
    margin-left: 25px;
}
</style>
