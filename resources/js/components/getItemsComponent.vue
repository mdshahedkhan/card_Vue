<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">#</th>
                    <th scope="col" class="col-md-11">Task Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in items" :key="index">
                    <td><input type="checkbox" :checked="item.status == 'active' ? true:false" @change="ChangeStatus(item.id, item.status)"></td>
                    <th scope="row">{{ index }}</th>
                    <td>{{ item.name }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" @change="ChangeStatus(item.id, item.status)" v-bind:checked="item.status == 'active' ? true:false">
                        </div>
                    </td>
                    <td class="d-flex">
                        <button class="btn btn-info btn-sm" style="margin-right: 5px" data-bs-toggle="modal" @click="setTaskValues(item); modalVisible = true" href="#exampleModalToggle" role="button">Edit</button>
                        <button v-on:click="destroyTask(item.id)" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Button trigger modal -->
        <div class="modal fade" v-if="modalVisible" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form @submit.prevent="storeUpdate" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalToggleLabel">Update Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 col-md-12 m-auto">
                                <label for="task_name" class="form-label">Task Name</label>
                                <input type="text" v-model="taskUpdate.name" class="form-control" id="task_name" placeholder="Enter Your Task Name">
                            </div>
                            <div class="d-flex justify-content-lg-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" v-model="taskUpdate.status" id="active" value="active">
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" v-model="taskUpdate.status" id="inactive" value="inactive">
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" v-on:click="modalVisible = true" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ModalComponent from "./ModalComponent";

export default {
    name: "getItemsComponent",
    components: { ModalComponent },
    props: ['items', 'getData'],
    data() {
        return {
            taskFrom: {
                name: null,
                status: null
            },
            modalVisible: true,
            taskUpdate: {},
            updateTask: {
                name: null
            }
        }
    },
    methods: {
        ChangeStatus: function (id, status) {
            axios.post('http://127.0.0.1:8000/api/items/status/' + id + '/' + status).then((res) => {
                this.$emit('loadItems');
                console.log(res.success)
            });
        },
        setTaskValues(data) {
            this.taskUpdate = data
        },
        modalVisible() {
            this.modalVisible = true
        },
        storeUpdate() {
            axios.patch('http://127.0.0.1:8000/api/items/' + this.taskUpdate.id, this.taskUpdate)
                .then((response) => {
                    Toast.fire({
                        title: "Success",
                        text: response.data.success
                    });
                    this.$emit('loadItems');
                    this.modalVisible = false
                });
            console.log("OK")
        }
        ,
        destroyTask: function (id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('http://127.0.0.1:8000/api/items/' + id)
                        .then((res) => {
                            this.$emit('loadItems');
                            swal.fire(
                                'Deleted!',
                                res.success,
                                'success'
                            )
                        });
                }
            })
        }
    }
}


</script>

<style scoped>

</style>
