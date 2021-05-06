<template>
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
            <tr v-for="(item, index) in items" :key="index" >
                <td><input type="checkbox" :checked="item.status == 'active' ? true:false" @change="ChangeStatus(item.id, item.status)"></td>
                <th scope="row">{{ index }}</th>
                <td>{{ item.name }}</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" @change="ChangeStatus(item.id, item.status)" v-bind:checked="item.status == 'active' ? true:false">
                    </div>
                </td>
                <td class="d-flex">
                    <a href="" class="btn btn-info btn-sm" style="margin-right: 5px">Edit</a>
                    <a href="javascript:" v-on:click="destroyTask(item.id)" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "getItemsComponent",
    props: ['items', 'getData'],
    methods: {
        ChangeStatus: function (id, status) {
            axios.post('http://127.0.0.1:8000/api/items/status/' + id + '/' + status).then((res) => {
                this.$emit('loadItems');
                console.log(res.success)
            });
        },
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
