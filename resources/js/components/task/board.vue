<template>
    <div>
        <div class="d-flex">
            <div
              v-for="column in columns"
              :key="column.title"
              class="px-3 py-3 column-width rounded mr-4  tab-kanban"
              :data-tab="column.title"
            >
              <p class="font-weight-bold">{{ column.title }}</p>
              <draggable :list="column.tasks"  item-key="id" :animation="200" ghost-class="ghost-card" group="tasks" @change="updateTask">
                <task-card
                  v-for="(task) in column.tasks"
                  :key="task.id"
                  :task="task"
                  @deleteTask="destroyCard"
                  class="mt-3"
                  data-id=""
                ></task-card>
                <a slot="footer" class="marg-top add-task-link cursor" @click="addTask">Add Task</a>
              </draggable>
            </div>
          </div>

        
    </div>
</template>



<script>
import draggable from "vuedraggable";
import TaskCard from "@/components/task/utils/TaskCard.vue";

import { mapGetters, mapActions } from 'vuex'

export default {
    name: "Board",
    components: {
        TaskCard,
        draggable,
    },
    data() {
        return {
            columns: [],
            selectedId: [],
            showModal: false
        };
    },
    computed: {
        ...mapGetters("board", [
            "tasks",
        ]),
    },
    mounted() {
        this.getData();
    },
    methods: {
        ...mapActions("board", [
            "fetchTaskData",
            "destroyData",
            "updateTaskData"
        ]),

        async getData() {
            const self = this;
            await self.fetchTaskData()
            .then((data) => {
                self.columns = self.tasks;

              
            }).catch((error) => {})
        },

        async updateTask(event) {
            if (event.hasOwnProperty('added')) {
                this.selectedId = {
                    id: event.added.element.id,
                    title: event.added.element.title,
                    task_group: event.added.element.task_group,
                    status: this.findKeyById(event.added.element.id)
                }
            }
            await this.updateTaskData(this.selectedId);
                
        },

        findKeyById(id) {
            let selectedKey = ''
            for (const key in this.columns) {
                if (key) {
                    if (this.columns.hasOwnProperty(key)) {
                        const items = this.columns[key];
                        const foundItem = items.tasks.find(item => item.id === id);
                        if (foundItem) {
                            selectedKey = this.columns[key].title
                        }
                    }
                }
            }

            return selectedKey;
        },

        addTask(event) {

            const parentDiv = event.target.closest('[data-tab]');
            if (parentDiv) {
                const dataTabValue = parentDiv.getAttribute('data-tab');
                this.$router.push({ name: "Create", params: { status: dataTabValue } });
            }
        },

        async destroyCard(val) {
            await this.destroyData(val).then((response) => {
                if (response.data.success) {
                    this.getData();

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

        }

    }

};
</script>

<style scoped>
.column-width {
    min-width: 320px;
    width: 320px;
}

.ghost-card {
    opacity: 0.5;
    background: #F7FAFC;
    border: 1px solid #4299e1;
}
</style>
