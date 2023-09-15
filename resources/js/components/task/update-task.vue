<template>
    <div>
        <!-- Button to trigger the modal -->


    <div class="row justify-content-md-center mt-4">
        
        <div class="col-sm-5">
            <form  @submit.prevent="submit">
                <div class="form-group mb-2">
                    <label for="taskTitle">Title</label>
                    <input type="text" class="form-control" id="task_title" placeholder="Title"  v-model="form.title" required>
                </div>
                <div class="form-group mb-2">
                    <label for="taskDescription">Description</label>
                    <textarea class="form-control" id="task_description" rows="5"  v-model="form.description"></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="taskDueDate">Due Date</label>
                    <input type="date" class="form-control" id="due_date"  v-model="form.due_date">
                </div>
                <div class="form-group mb-2">
                    <label for="taskStatus">Status</label>
                    <select class="form-control" id="status" v-model="form.status">
                        <option value="" selected disabled>- Select Option</option>
                        <option v-for="(statusOpt,i) in listStatus" :key="i" :value="statusOpt">{{ statusOpt }} </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="taskGroup">Group</label>
                    <select class="form-control" id="group" v-model="form.task_group">
                        <option value="" selected disabled>- Select Option</option>
                        <option v-for="(groupOpt, i) in listGroups" :key="i" :value="groupOpt">{{ groupOpt }} </option>
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-2     ">
                    <div>
                        <button type="submit" class="btn btn-primary mt-2 mx-2">Update</button>
                        <button class="btn btn-danger mt-2">Cancel</button>
                    </div>
                </div>
            </form>


        </div>
        
      </div>



    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    props: ['id'],
    data() {
        return {
            listStatus: ['Todo','In Progress','Done'],
            listGroups: ['Design', 'Feature Request', 'Backend', 'QA'],
            form: {
                title: '',
                description: '',
                due_date: '',
                status: '',
                task_group: ''
            }
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        ...mapActions("board", [
            "showTaskData",
            "updateData"
        ]),
        async fetchData() {
            await this.showTaskData(this.id).then((response) => {
                let result = response.data.data;
                this.form = {
                    id: result.id,
                    title: result.title,
                    description: result.description,
                    due_date: result.due_date,
                    status: result.status,
                    task_group: result.task_group,
                }

                
            })
        },
        async submit() {
            await this.updateData(this.form).then((response) => {
                if (response.data.success) {
                    this.form = {
                        title: '',
                        description: '',
                        due_date: '',
                        status: '',
                        task_group: ''
                    }

                    this.$notify({
                        group: 'notif',
                        type: 'success',
                        title: 'System Notification',
                        text: response.data.message
                    });
                    this.$router.push({ name: 'Board' });
                }
            }).catch(error => {
                if (error.response && error.response.data && error.response.data.message) {
                    const errorMessage = error.response.data.message;
                    this.$notify({
                        group: 'notif',
                        type: 'error',
                        title: 'System Notification',
                        text: errorMessage
                    });
                }
            });
        },

    },
};
</script>
